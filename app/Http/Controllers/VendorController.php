<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class VendorController extends Controller
{
    public function index(User $user)
    {
        $users = User::whereNull('nik')->get();
        $positions = Position::all();
        $departments = Department::all();
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        confirmDelete();
        return view('roleuser.vendor.index', \compact('users', 'positions', 'roles', 'userRoles', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:20'
        ]);

        $user = User::create([
            'company_department' => $request->company,
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->syncRoles('user');

        Alert::toast('User created successfully with role user!', 'success');
        return redirect()->route('vendors.index');
    }


    public function update(Request $request, $userId)
    {
        // dd($request->all());
        $user = User::find($userId);

        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|string|max:255',
            'company_department' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,non active'
        ]);

        // Prepare the data for update
        $data = $request->only([
            'company_department',
            'username',
            'name',
            'email',
            'status'
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->avatar) {
                Storage::disk('public')->delete('user_avatars/' . $user->avatar);
            }

            // Get original extension
            $extension = $request->avatar->getClientOriginalExtension();

            // Store new avatar with original extension
            $avatarName = $request->username . '.' . $extension;
            $path = $request->avatar->storeAs('user_avatars', $avatarName, 'public');

            // Log path for debugging
            Log::channel('custom')->info('Avatar stored at path: ' . $path);
            Log::channel('custom')->info('Storage directory contents:', Storage::disk('public')->allFiles('user_avatars'));

            // Verify that file exists
            if (!Storage::disk('public')->exists('user_avatars/' . $avatarName)) {
                Log::error('Failed to store avatar: ' . $avatarName);
            }

            $data['avatar'] = $avatarName;
        }

        // dd($request, $data, $user);
        // Update user data
        $user->update($data);

        // Flash success message and redirect
        Alert::toast('User updated successfully with roles!', 'success');
        return redirect()->route('vendors.index');
    }
    
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);

        // Hapus avatar jika ada
        if ($user->avatar) {
            Storage::delete('public/user_avatars/' . $user->avatar);
        }

        $user->delete();

        Alert::toast('User deleted successfully!', 'success');
        return redirect()->route('vendors.index');
    }
}
