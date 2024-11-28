<?php

namespace App\Http\Controllers\HSE;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\HSE\hseLocation;

class HSELocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:edit location hse', ['only' => ['viewLocation','locationUpdate','locationDelete','locationStore']]);
    }

    public function viewLocation(){
        $users = User::whereNotNull('nik')->get();
        $locations = hseLocation::all();

        $title = "Delete";
        $text = "Test Text";
        confirmDelete($title, $text);
        
        return view('hse.admin.table.viewLocationTable', compact('locations', 'users'));
    }

    public function locationUpdate(Request $request, $locationId){
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:hse_locations,name,'. $locationId,
            'pic' => 'required|string|max:255',
            'nik' => 'required|string|max:255'
        ]);

        $location = hseLocation::findOrFail($locationId);
        $location->name = $validatedData['name'];
        $location->pic = $validatedData['pic'];
        $location->nik = $validatedData['nik'];
        $location->save();
        
        Alert::toast('Location updated successfully!', 'success');
        return redirect('location')->with('status', 'Location updated successfully!');
    }

    public function locationDelete(Request $request, $locationId){

        $location = hseLocation::findOrFail($locationId);
        // dd($request,$locationId, $location, "delete");

        if ($location) {
            $location->delete();
            Alert::toast('Location deleted successfully!', 'success');
            return redirect('location')->with('status', 'Location deleted successfully!');
        }

        Alert::toast('Location delete failed!', 'failed');
        return redirect('location')->with('status', 'Location delete failed!');
    }

    public function locationStore(Request $request){

        $selectedValue = json_decode($request->input('pic'), true);
        $nik = $selectedValue['nik'];
        $name = $selectedValue['name'];
        // dd($request, $nik, $name);
        $request->validate([
            'name' => 'required|string|max:255|unique:hse_locations,name,'
        ]);

        hseLocation::create([
            'name' => $request->name,
            'pic' => $name,
            'nik' => $nik
        ]);

        Alert::toast('Location created successfully!', 'success');
        return redirect('location')->with('status', 'Location created successfully!');
    }
}
