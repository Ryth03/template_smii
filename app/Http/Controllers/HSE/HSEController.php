<?php

namespace App\Http\Controllers\HSE;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
use App\Models\HSE\hseLocation;
use App\Models\HSE\extendedFormLog;
use App\Models\HSE\extendedFilesLog;
use App\Notifications\PrNotification;
use Illuminate\Support\Facades\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Jobs\sendToUserJob;
use App\Jobs\sendToApproverJob;
use App\Jobs\sendReminderToUserJob;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class HSEController extends Controller
{

    public function __construct(){
        $this->middleware('permission:review form hse', ['only' =>['reviewTable']]);
        $this->middleware('permission:review form hse', ['only' =>['reviewForm']]);
        $this->middleware('permission:review form hse', ['only' =>['updateForm']]);
        $this->middleware('permission:approve form hse', ['only' =>['approvalTable']]);
        $this->middleware('permission:approve form hse', ['only' =>['approvalForm']]);
        $this->middleware('permission:approve form hse', ['only' =>['approveForm']]);
        $this->middleware('permission:view all form hse', ['only' =>['viewAllTable']]);
    }

    private function userNotification($user_id, $status){

        $user = User::where('id', $user_id)->first();
        $data = [
            'title' => 'Form Status',
            'message' => 'Your form has been ' . $status . '.'
        ];
        Notification::send($user, new PrNotification($data));

    }

    private function approvalNotification($role){
        $approvalUser = User::role($role)->get();
        $data = [
            'title' => 'New Form To Approve',
            'message' => 'New form requires approval.'
        ];
        Notification::send($approvalUser, new PrNotification($data));
    }

    private function areaOwnerNotification($nik){
        $approvalUser = User::where('nik', $nik)->first();
        $data = [
            'title' => 'New Form To Approve',
            'message' => 'New form requires approval.'
        ];
        Notification::send($approvalUser, new PrNotification($data));
    }

    private function sendNotifAndEmailToApprover($formId, $level){
        $approver = approver::where('level', $level)
        ->pluck('name')
        ->first();

        $toUser = null;
        $form = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
        ->where('forms.id', $formId)
        ->first();

        if(strToLower($approver) === 'pic location'){


            $nik = hseLocation::where('name', $form->location)->pluck('nik')->first();
            $toUser = User::role($approver)->where('nik', $nik)->pluck('email')->toArray();
            $this->areaOwnerNotification($nik); // send notification
        }else{
            $toUser = User::role($approver)->pluck('email')->toArray();
            $this->approvalNotification(strToLower($approver)); //send notification
        }
        $projectExecutor = projectExecutor::where('form_id', $formId)->first();
        sendToApproverJob::dispatch($toUser, $form, $projectExecutor, $approver); // send email
    }

    public function store(Request $request)
    {
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
            'department_id' => $request->department_id,
            'company_department' => $request->company_department
        ]);

        $user->syncRoles($request->roles);

        Alert::toast('User created successfully with roles!', 'success');
        return redirect()->route('users.index');
    }

    public function viewAllTable()
    {
        $forms = Form::select('forms.id as id', 'company_department', 'location', 'forms.status as status', 'start_date', 'end_date', DB::raw("COUNT(approval_details.form_id) as 'count'"))
        ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
        ->leftJoin('approval_details', 'approval_details.form_id', '=', 'forms.id')
        ->groupBy('company_department', 'location', 'forms.status', 'forms.id', 'start_date', 'end_date')
        ->orderBy('forms.id', 'asc')
        ->get();
        confirmDelete();
        return view('hse.admin.table.viewAllTable', compact('forms'));
    }

    public function viewSecurityTable()
    {
        // Mendapatkan tanggal hari ini
        $today = Carbon::today();

        $forms = Form::whereHas('projectExecutor', function($query) use ($today) {
            $query->where('start_date', '<=', $today)
                  ->where('end_date', '>=', $today);
        })
        ->where('status', "Approved")
        ->with('projectExecutor') // Asumsi relasi sudah didefinisikan
        ->get();

        $files = uploadFile::whereHas('form', function($query) {
            $query->where('status', "Approved");
        })->get();

        $ktps = fitToWork:: whereHas('form', function($query) {
            $query->where('status', "Approved");
        })->get();

        $idList = uploadFile::whereHas('form', function($query) {
            $query->where('status', "Approved");
        })->pluck('form_id');

        return view('hse.admin.table.securityPostTable', compact('forms', 'files', 'ktps', 'idList'));
    }

    public function reviewTable()
    {
        $forms = Form::where('status', 'In Review')
        ->leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
        ->get();

        return view('hse.admin.table.reviewTable', compact('forms'));
    }

    public function approvalTable()
    {
        $user = Auth::user();
        $userRole =  strToLower($user->getRoleNames()->first());

        $approver = approver::where('role_name', $userRole)
        ->select('name', 'level')
        ->first();

        if(!$approver){
            return redirect()->route("dashboard");
        }

        $forms = [];
        $approvalDetail = null;
        if($approver->level === 1){
            $approvalDetail = approvalDetail::pluck('form_id');
            $forms = Form::leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
            ->leftJoin('extended_form_logs', 'forms.id', '=', 'extended_form_logs.form_id')
            ->select('forms.id as id', 'company_department', 'supervisor', 'location',
                'hp_number','start_date', 'end_date', 'start_time', 'end_time', 'workers_count')
            ->where(function($query) {
                $query->where('forms.status', 'In Approval')
                      ->orWhere('extended_form_logs.status', 'In Approval');
            })
            ->whereNotIn('forms.id',$approvalDetail)
            ->get();

        }elseif($approver->level === 2){
            $approvalDetail = approvalDetail::select('form_id')
            ->groupBy('form_id')
            ->havingRaw('COUNT(form_id) = 1')
            ->pluck('form_id');
            $forms = Form::where('status', 'In Approval')
            ->leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
            ->whereIn('forms.id',$approvalDetail)
            ->get();
        }elseif($approver->level === 3){
            $approvalDetail = approvalDetail::select('form_id')
            ->groupBy('form_id')
            ->havingRaw('COUNT(form_id) = 2')
            ->pluck('form_id');
            $forms = Form::where('status', 'In Approval')
            ->leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
            ->whereIn('forms.id',$approvalDetail)
            ->get();
        }
        if($userRole === 'pic location'){
            $location = hseLocation::where('nik', $user->nik)->get()->pluck('name');
            $forms = Form::leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
            ->where('status', 'In Approval')
            ->whereIn('forms.id',$approvalDetail)
            ->whereIn('location', $location)
            ->get();
        }

        return view('hse.admin.table.approvalTable', compact('forms','approver'));
    }

    public function reviewForm($formId)
    {
        $form = Form::leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
        ->where('forms.id', $formId)
        ->first();

        $workers = Form::leftJoin('fitToWork', 'forms.id', '=', 'fitToWork.form_id')
        ->where('forms.id', $formId)
        ->get();

        $permits = Form::leftJoin('additionalWorkPermits_data', 'forms.id', '=', 'additionalWorkPermits_data.form_id')
        ->where('forms.id', $formId)
        ->select('master_id')
        ->get();

        confirmDelete();

        $scaffs = scaffoldingRiskControl_master::all();
        return view('hse.admin.form.reviewForm', compact('form','workers','permits','scaffs'));
    }

    public function approvalForm($formId)
    {

        $form = Form::leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
        ->where('forms.id', $formId)
        ->first();

        if(!$form){
            return redirect()->route('dashboard');
        }

        $extendedForm = null;
        if($form->status !== "In Approval"){ // Cek apakah status in approval
            $extendedForm = extendedFormLog::where('form_id', $formId)
            ->where('status', 'In Approval')
            ->first();

            if(!$extendedForm){ // Jika bukan extend akan diredirect
                return redirect()->route('dashboard');
            }else{
                $form->end_date = $extendedForm->end_date_after;
            }
        }


        $potentialHazards = potentialHazardsInWorkplace_master::all();
        $potentialHazards_data = potentialHazardsInWorkplace_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id')
        ->toArray();

        $files = null;
        if($extendedForm){
            $files = collect();
            $extendedFiles = extendedFilesLog::where('extended_id', $extendedForm->id)->get();
            if($extendedFiles){ // Cek apakah ada file sio atau silo yang diupload pada extend form
                foreach($extendedFiles as $extendedFile){
                    $extendedFileName = json_decode($extendedFile->file_name_after); //Mengubah json menjadi array
                    foreach($extendedFileName as $fileName){
                        $newFile = new uploadFile();
                        $newFile->type = $extendedFile->type;
                        $newFile->file_location = $extendedFile->file_location . $fileName;
                        $newFile->file_name = preg_replace('/^[^_]+_/', '', $fileName);
                        $files->push($newFile); // Memasukan file kedalam collection
                    }
                }
            }
        }else{
            $files = uploadFile::select('type','file_location','file_name')
            ->where('form_id', $formId)
            ->get();
        }

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


        confirmDelete();

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

        // Send Notification to level 1
        $this->sendNotifAndEmailToApprover($formId, 1);

        return redirect()->route('review.table');
    }

    public function approveForm(Request $request)
    {
        $user = Auth::user();

        $userRole =  strToLower($user->getRoleNames()->first());
        $approver = approver::where('role_name', $userRole)
        ->first();

        $formId = $request->input('value');
        $comment = $request->input('comment');
        $action = $request->input('action'); // Ambil nilai action

        $extendedForm = extendedFormLog::where('form_id', $formId)
        ->where('status', 'In Approval')
        ->first();

        if($extendedForm)
        {
            if ($action === 'approve')
            {
                $form = Form::find($formId);
                if($form->status === 'Approved'){
                    $extendedForm->status = "Approved";
                    $projectExecutor = projectExecutor::where('form_id', $formId)->first();
                    $projectExecutor->end_date = $extendedForm->end_date_after;

                    $projectExecutor->save();
                    $extendedForm->save();

                    $files = collect();
                    $extendedFiles = extendedFilesLog::where('extended_id', $extendedForm->id)->get();

                    if($extendedFiles){ // Cek apakah ada file sio atau silo yang diupload pada extend form
                        foreach($extendedFiles as $extendedFile){
                            $extendedFileName = json_decode($extendedFile->file_name_after); //Mengubah json menjadi array
                            foreach($extendedFileName as $fileName){
                                $temp = uploadFile::create([
                                    'form_id' => $formId,
                                    'type' => $extendedFile->type,
                                    'file_name' => $fileName,
                                    'file_location' => "/storage/hseFile/" . $formId . "/" . $extendedFile->type . "/" . $fileName
                                ]);
                            }
                        }
                    }

                    // Send Notification to user
                    $this->userNotification($form->user_id,'Extended');

                    // Send Email to User
                    $projectExecutor = projectExecutor::where('form_id', $formId)->first();
                    $toUser = User::find($form->user_id);
                    $newForm = collect();
                    $newForm->status = "Extended";
                    sendToUserJob::dispatch($toUser, $newForm, $projectExecutor, $comment);
                }
            }
            else if($action === 'reject')
            {
                $extendedForm->status = "Rejected";
                $extendedForm->save();


                $form = Form::find($formId);

                // Send Notification to user
                $this->userNotification($form->user_id,'Rejected (Extend Request)');

                // Send Email to User
                $projectExecutor = projectExecutor::where('form_id', $formId)->first();
                $toUser = User::find($form->user_id);
                $newForm = collect();
                $newForm->status = "Rejected";
                sendToUserJob::dispatch($toUser, $newForm, $projectExecutor, $comment);
            }
        }
        else
        {
            if ($action === 'approve')
            {
                if (trim($comment) !== '') {
                    approvalDetail::updateOrCreate([
                        'form_id' => $formId,
                        'approver_id' => $approver->id
                    ],[
                        'status' => "Approved",
                        'comment' => $comment
                    ]);
                }else{
                    approvalDetail::updateOrCreate([
                        'form_id' => $formId,
                        'approver_id' => $approver->id
                    ],[
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

                    $user = User::find($form->user_id);

                    // Send Notification to user
                    $this->userNotification($form->user_id,'Approved');

                    // Send Email to User
                    $projectExecutor = projectExecutor::where('form_id', $formId)->first();
                    $toUser = User::find($form->user_id);
                    sendToUserJob::dispatch($toUser, $form, $projectExecutor, $comment);

                }else if($approvalDetail->count == 2){

                    // Send Notification and Email to level 3
                    $this->sendNotifAndEmailToApprover($formId, 3);

                }else if($approvalDetail->count == 1){

                    // Send Notification and Email to level 2
                    $this->sendNotifAndEmailToApprover($formId, 2);
                }
            }
            else if($action === 'reject')
            {
                if (trim($comment) == '') {
                    return redirect()->back()->with("error", "Data tidak berhasil. Komentar tidak boleh kosong atau hanya spasi.");
                }else{
                    $formId = $request->input('value');
                    approvalDetail::updateOrCreate([
                        'form_id' => $formId,
                        'approver_id' => $approver->id
                    ],[
                        'status' => "Rejected",
                        'comment' => $request->input('comment')
                    ]);
                    $form = Form::find($formId);
                    $form->status = 'Rejected';
                    $form->save();


                    // Send Notification to user
                    $this->userNotification($form->user_id,'Rejected');


                    // Send Email to User
                    $projectExecutor = projectExecutor::where('form_id', $formId)->first();
                    $toUser = User::find($form->user_id);
                    sendToUserJob::dispatch($toUser, $form, $projectExecutor, $comment);
                }

            }
        }


        return redirect()->route('approval.table');

    }

    public function printReport(Request $request)
    {
        $formId = $request->input('value');

        $form = Form::leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
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

        $approvalDetail = approvalDetail::where('approval_details.form_id', $formId)
        ->leftJoin('approvers','approval_details.approver_id','=','approvers.id')
        ->select('approvers.name as name','status','comment')
        ->get();

        return view('hse.admin.form.reportForm',
        compact('form','potentialHazards', 'potentialHazards_data',
            'personalProtectEquipments', 'personalProtectEquipments_data',
            'workEquipments', 'workEquipments_data', 'files',
            'additionalWorkPermits', 'additionalWorkPermits_data', 'scaffs', 'testResult',
            'fireHazardControls', 'fireHazardControls_data',
            'workers', 'jsas', 'approvalDetail'
        ));

        // set_time_limit(300);

        // $data = [
        //     'form' => $form,
        //     'potentialHazards' => $potentialHazards,
        //     'potentialHazards_data' => $potentialHazards_data,
        //     'personalProtectEquipments' => $personalProtectEquipments,
        //     'personalProtectEquipments_data' => $personalProtectEquipments_data,
        //     'workEquipments' => $workEquipments,
        //     'workEquipments_data' => $workEquipments_data,
        //     'files' => $files,
        //     'additionalWorkPermits' => $additionalWorkPermits,
        //     'additionalWorkPermits_data' => $additionalWorkPermits_data,
        //     'scaffs' => $scaffs,
        //     'testResult' => $testResult,
        //     'fireHazardControls' => $fireHazardControls,
        //     'fireHazardControls_data' => $fireHazardControls_data,
        //     'workers' => $workers,
        //     'jsas' => $jsas
        // ];

        // $pdf = Pdf::loadView('hse.admin.form.reportForm', $data)->setPaper('A4', 'portrait');

        // $pdf->output();

        // return response()->streamDownload(function() use ());
    }

    public function sendReminderToUser(Request $request)
    {
        $form = Form::find($request->input("formId"));
        // Send Email Reminder to User
        $projectExecutor = projectExecutor::where('form_id', $form->id)->first();
        $toUser = User::find($form->user_id);
        sendReminderToUserJob::dispatch($toUser, $form, $projectExecutor);

        return redirect()->route('viewAll.table');
    }
}
