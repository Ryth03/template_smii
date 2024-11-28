<?php

namespace App\Http\Controllers\HSE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\HSE\approver;

class HSEApproverLevelController extends Controller
{
    public function __construct(){
        $this->middleware('permission:edit approver hse', ['only' =>['index']]);
    }

    public function index(){
        $approvers = approver::all();
        return view('hse.admin.table.approverTable', compact('approvers'));
    }

    public function update(Request $request, $approverId){
        $validatedData = $request->validate([
            'level' => 'required|integer'
        ]);
        $approver = approver::find($approverId);
        $approver->level = $validatedData['level'];
        $approver->save();
        
        Alert::toast('Approver level updated successfully!', 'success');
        return redirect()->route('approver.view.hse')->with('status', 'Approver level updated successfully!');
    }
}
