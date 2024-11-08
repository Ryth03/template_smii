<?php

namespace App\Http\Controllers\HSE;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HSE\Form;
use App\Models\HSE\projectExecutor;
use App\Models\HSE\potentialHazardsInWorkplace_master;
use App\Models\HSE\potentialHazardsInWorkplace_data;
use App\Models\HSE\personalProtectiveEquipment_master;
use App\Models\HSE\personalProtectiveEquipment_data;
use App\Models\HSE\workEquipments_master;
use App\Models\HSE\workEquipments_data;
use App\Models\HSE\additionalWorkPermits_master;
use App\Models\HSE\additionalWorkPermits_data;
use App\Models\HSE\fireHazardControl_master;
use App\Models\HSE\fireHazardControl_data;
use App\Models\HSE\fitToWork;
use App\Models\HSE\jobSafetyAnalysis;
use App\Models\HSE\uploadFile;
use App\Models\HSE\scaffoldingRiskControl_master;
use App\Models\HSE\scaffoldingRiskControl_data;
use App\Models\HSE\testResult;
use App\Models\HSE\approvalDetail;
use App\Models\HSE\approver;
use App\Models\HSE\userHasApprover;
use App\Models\HSE\hseLocation;

class HSEController extends Controller
{

    public function __construct(){
        $this->middleware('permission:review form hse', ['only' =>['reviewTable']]);
        $this->middleware('permission:approve form hse', ['only' =>['approvalTable']]);
        $this->middleware('permission:approve form hse', ['only' =>['approvalForm']]);
        $this->middleware('permission:approve form hse', ['only' =>['approveForm']]);
    }

    public function store(Request $request)
    {
        // \dd($request->all());
        $request->validate([
            'nik' => 'required|min:4|max:6|unique:users,nik',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required'
        ]);

        $user = User::create([
            'nik' => $request->nik,
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'position_id' => $request->position_id,
            'department_id' => $request->department_id
        ]);

        $user->syncRoles($request->roles);

        Alert::toast('User created successfully with roles!', 'success');
        return redirect()->route('users.index');
    }

    public function viewAllTable()
    {
        // $forms = Form::leftJoin('projectexecutors', 'projectexecutors.form_id', '=', 'forms.id')
        // ->get();
        $forms = Form::select('forms.id as id', 'supervisor', 'forms.created_at as created_at', 'forms.updated_at as updated_at', 'forms.status as status' , DB::raw("COUNT(approval_details.form_id) as 'count'"))
        ->leftJoin('projectexecutors', 'projectexecutors.form_id', '=', 'forms.id')
        ->leftJoin('approval_details', 'approval_details.form_id', '=', 'forms.id')
        ->groupBy('supervisor','forms.created_at', 'forms.updated_at', 'forms.status', 'forms.id')
        ->orderBy('forms.id', 'asc')
        ->get();
        return view('hse.admin.table.viewAllTable', compact('forms'));
    }

    public function viewSecurityTable()
    {
        // Mendapatkan tanggal hari ini
        $today = Carbon::today();

        $forms = Form::leftJoin('projectexecutors', 'forms.id', '=', 'projectexecutors.form_id')
        ->where('start_date', '<=', $today)
        ->where('end_date', '>=', $today)
        ->get();

        $files = uploadFile::leftJoin('forms', 'forms.id', '=', 'uploadfiles.form_id')
        ->where('status', "Approved")
        ->get();

        $idList = uploadFile::leftJoin('forms', 'forms.id', '=', 'uploadfiles.form_id')
        ->where('status', "Approved")
        ->pluck('uploadfiles.form_id');
        return view('hse.admin.table.securityPostTable', compact('forms', 'files', 'idList'));
    }

    public function reviewTable()
    {
        $forms = Form::where('status', 'In Review')
        ->leftJoin('projectexecutors', 'forms.id', '=', 'projectexecutors.form_id')
        ->get();

        return view('hse.admin.table.reviewTable', compact('forms'));
    }

    public function approvalTable()
    {
        $user = Auth::user();
        $approver = approver::leftJoin('roles', "roles.id", "=", "approvers.role_id")
        ->leftJoin('model_has_roles', "model_has_roles.role_id" , "=", "roles.id")
        ->select('approvers.level as level', 'approvers.name as role_name')
        ->where('model_has_roles.model_id', $user->id)
        ->first();
        
        if(!$approver){
            return redirect()->route("dashboard");
        }

        $forms = [];
        $approvalDetail = null;
        if($approver->level === 1){
            $approvalDetail = approvalDetail::pluck('form_id');
            $forms = Form::where('status', 'In Approval')
            ->leftJoin('projectexecutors', 'forms.id', '=', 'projectexecutors.form_id')
            ->whereNotIn('forms.id',$approvalDetail)
            ->get();
        }elseif($approver->level === 2){
            $approvalDetail = approvalDetail::select('form_id')
            ->groupBy('form_id')
            ->havingRaw('COUNT(form_id) = 1')
            ->pluck('form_id');
            $forms = Form::where('status', 'In Approval')
            ->leftJoin('projectexecutors', 'forms.id', '=', 'projectexecutors.form_id')
            ->whereIn('forms.id',$approvalDetail)
            ->get();
        }elseif($approver->level === 3){
            $approvalDetail = approvalDetail::select('form_id')
            ->groupBy('form_id')
            ->havingRaw('COUNT(form_id) = 2')
            ->pluck('form_id');
            $forms = Form::where('status', 'In Approval')
            ->leftJoin('projectexecutors', 'forms.id', '=', 'projectexecutors.form_id')
            ->whereIn('forms.id',$approvalDetail)
            ->get();
        }
        if($approver->role_name === 'Area Owner'){
            $location = hseLocation::where('nik', $user->nik)->get()->pluck('name');
            $forms = Form::leftJoin('projectexecutors', 'forms.id', '=', 'projectexecutors.form_id')
            ->where('status', 'In Approval')
            ->whereIn('forms.id',$approvalDetail)
            ->whereIn('location', $location)
            ->get();
        }
        
        return view('hse.admin.table.approvalTable', compact('forms','approver'));
    }

    public function reviewForm(Request $request)
    {
        $form = Form::leftJoin('projectexecutors', 'forms.id', '=', 'projectexecutors.form_id')
        ->where('forms.id', $request->input('value'))
        ->first();

        $workers = Form::leftJoin('fitToWork', 'forms.id', '=', 'fitToWork.form_id')
        ->where('forms.id', $request->input('value'))
        ->get();

        $permits = Form::leftJoin('additionalWorkPermits_data', 'forms.id', '=', 'additionalWorkPermits_data.form_id')
        ->where('forms.id', $request->input('value'))
        ->select('master_id')
        ->get();

        $scaffs = scaffoldingRiskControl_master::all();
        return view('hse.admin.form.reviewForm', compact('form','workers','permits','scaffs'));
    }

    public function approvalForm(Request $request)
    {
        
        $formId = $request->input('value'); 

        $form = Form::leftJoin('projectexecutors', 'forms.id', '=', 'projectexecutors.form_id')
        ->where('forms.id', $formId)
        ->first();

        $potentialHazards = potentialHazardsInWorkplace_master::all();
        $potentialHazards_data = potentialHazardsInWorkplace_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id')
        ->toArray();

        $files = uploadFile::where('form_id', $formId)
        ->get();

        $personalProtectEquipments = personalProtectiveEquipment_master::all();
        $personalProtectEquipments_data = personalProtectiveEquipment_data::where('form_id', $formId)
        ->leftJoin('personalProtectiveEquipment_master', 'personalProtectiveEquipment_master.id', '=', 'personalProtectiveEquipment_data.master_id')
        ->get()
        ->pluck('master_id')
        ->toArray();

        $workEquipments = workEquipments_master::all();
        $workEquipments_data = workEquipments_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id')
        ->toArray();

        $additionalWorkPermits = additionalWorkPermits_master::all();
        $additionalWorkPermits_data = additionalWorkPermits_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id')
        ->toArray();

        $scaffs = scaffoldingRiskControl_master::leftJoin('scaffoldingRiskControl_data', 'scaffoldingRiskControl_master.id', '=', 'scaffoldingRiskControl_data.master_id')
        ->where('form_id', $formId)
        ->select('name', 'status')
        ->get();

        $testResult = testResult::where('form_id', $formId)
        ->first();

        $fireHazardControls = fireHazardControl_master::all();
        $fireHazardControls_data = fireHazardControl_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id')
        ->toArray();

        $workers = fitToWork::where('form_id', $formId)
        ->get();

        $jsas = jobSafetyAnalysis::where('form_id', $formId)
        ->get();

        
        return view('hse.admin.form.approvalForm', 
        compact('form','potentialHazards', 'potentialHazards_data',
            'personalProtectEquipments', 'personalProtectEquipments_data', 
            'workEquipments', 'workEquipments_data', 'files',
            'additionalWorkPermits', 'additionalWorkPermits_data', 'scaffs', 'testResult',
            'fireHazardControls', 'fireHazardControls_data',
            'workers', 'jsas'
        ));
    }

    public function updateForm(Request $request)
    {

        $formId = $request->input('value'); 
        
        $permits = Form::leftJoin('additionalWorkPermits_data', 'forms.id', '=', 'additionalWorkPermits_data.form_id')
        ->where('forms.id', $request->input('value'))
        ->select('master_id')
        ->get();

        if ($permits->contains('master_id', 4)){
            $data = scaffoldingRiskControl_master::all();
            $count = $data->count(); // Menghitung jumlah baris

            for ($i = 0; $i < $count; $i++) {
                scaffoldingRiskControl_data::create([
                    "form_id" => $formId, 
                    "master_id" => $i+1, 
                    "status" => $request->input("scaff{$i}")
                ]);
            }
        }
        

        if ($permits->contains('master_id', 2)){
            testResult::create([
                'form_id' => $formId,
                'lel' => $request->input('LEL'),
                'o2' => $request->input('O2'),
                'h2s' => $request->input('H2S'),
                'co' => $request->input('CO'),
                'test_date' => date('Y-m-d')
            ]);
        }

        $workers = fitToWork::leftJoin('forms', 'forms.id', '=', 'fitToWork.form_id')
        ->where('forms.id', $request->input('value'))
        ->select('fitToWork.*')
        ->get();
        foreach ($workers as $index => $worker) {
            $statusInput = $request->input("tenagaKerja{$index}");
            $worker->ok = ($statusInput === 'ok') ? true : false;
            $worker->not_ok = ($statusInput === 'notOk') ? true : false;
            $worker->clinic_check = ($statusInput === 'cekKlinik') ? true : false;
            $worker->clinic_recomendation = $request->input("clinicRecomendation{$index}");
            $worker->save();
        }
        
        $form = Form::find($formId);
        $form->status = 'In Approval';
        $form->save(); 
        return redirect()->route('review.table');
    }

    public function approveForm(Request $request)
    {
        $user = Auth::user();
        $approver = approver::leftJoin('user_has_approvers', "user_has_approvers.approver_id", "=", "approvers.id")
        ->where("user_id", $user->id)
        ->first();

        $formId = $request->input('value');
        
        $comments = $request->input('comment');
        $action = $request->input('action'); // Ambil nilai action

        if ($action === 'approve') {

            if (trim($comments) !== '') {
                approvalDetail::create([
                    'form_id' => $formId,
                    'approver_id' => $approver->approver_id,
                    'status' => "Approved",
                    'comments' => $comments
                ]);
            }else{
                approvalDetail::create([
                    'form_id' => $formId,
                    'approver_id' => $approver->approver_id,
                    'status' => "Approved"
                ]);
            }

            
            
            $approvalDetail = approvalDetail::select(DB::raw("COUNT(form_id) as 'count'"))
            ->where('form_id', $formId)
            ->groupBy('form_id')
            ->first();
            if($approvalDetail->count == 3){
                $form = Form::find($formId);
                $form->status = 'Approved';
                $form->save(); 
            }
            return redirect()->route('approval.table');

        }else if($action === 'reject'){
            if (trim($comments) == '') {
                return redirect()->back()->with("error", "Data tidak berhasil. Komentar tidak boleh kosong atau hanya spasi.");
            }else{
                $formId = $request->input('value'); 
                approvalDetail::create([
                    'form_id' => $formId,
                    'approver_id' => $approver->approver_id,
                    'status' => "Rejected",
                    'comments' => $request->input('comment')
                ]);
                $form = Form::find($formId);
                $form->status = 'Rejected';
                $form->save(); 
                return redirect()->route('approval.table');
            }

        }

        
        
    }

    public function printReport(Request $request)
    {
        // dd($request);
        $formId = $request->input('value'); 

        $form = Form::leftJoin('projectexecutors', 'forms.id', '=', 'projectexecutors.form_id')
        ->where('forms.id', $formId)
        ->first();

        $potentialHazards = potentialHazardsInWorkplace_master::all();
        $potentialHazards_data = potentialHazardsInWorkplace_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id')
        ->toArray();

        $files = uploadFile::where('form_id', $formId)
        ->get();

        $personalProtectEquipments = personalProtectiveEquipment_master::all();
        $personalProtectEquipments_data = personalProtectiveEquipment_data::where('form_id', $formId)
        ->leftJoin('personalProtectiveEquipment_master', 'personalProtectiveEquipment_master.id', '=', 'personalProtectiveEquipment_data.master_id')
        ->get()
        ->pluck('master_id')
        ->toArray();

        $workEquipments = workEquipments_master::all();
        $workEquipments_data = workEquipments_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id')
        ->toArray();

        $additionalWorkPermits = additionalWorkPermits_master::all();
        $additionalWorkPermits_data = additionalWorkPermits_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id')
        ->toArray();

        $scaffs = scaffoldingRiskControl_master::leftJoin('scaffoldingRiskControl_data', 'scaffoldingRiskControl_master.id', '=', 'scaffoldingRiskControl_data.master_id')
        ->where('form_id', $formId)
        ->select('name', 'status')
        ->get();

        $testResult = testResult::where('form_id', $formId)
        ->first();

        $fireHazardControls = fireHazardControl_master::all();
        $fireHazardControls_data = fireHazardControl_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id')
        ->toArray();

        $workers = fitToWork::where('form_id', $formId)
        ->get();

        $jsas = jobSafetyAnalysis::where('form_id', $formId)
        ->get();

        
        return view('hse.admin.form.reportForm', 
        compact('form','potentialHazards', 'potentialHazards_data',
            'personalProtectEquipments', 'personalProtectEquipments_data', 
            'workEquipments', 'workEquipments_data', 'files',
            'additionalWorkPermits', 'additionalWorkPermits_data', 'scaffs', 'testResult',
            'fireHazardControls', 'fireHazardControls_data',
            'workers', 'jsas'
        ));
    }
}
