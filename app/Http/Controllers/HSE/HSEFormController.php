<?php

namespace App\Http\Controllers\HSE;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
use App\Models\HSE\hseLocation;
use App\Notifications\PrNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\HSE\approver;
use App\Jobs\sendToApproverJob;

class HSEFormController extends Controller
{
    public function __construct(){
        $this->middleware('permission:view user dashboard hse', ['only' =>['viewList']]);
        $this->middleware('permission:create form hse', ['only' =>['viewNewForm']]);
        $this->middleware('permission:create form hse', ['only' =>['viewDraftForm']]);
        $this->middleware('permission:create form hse', ['only' =>['viewExtendForm']]);
        $this->middleware('permission:create form hse', ['only' =>['insertNewForm']]);
        $this->middleware('permission:create form hse', ['only' =>['insertForm']]);
        $this->middleware('permission:create form hse', ['only' =>['insertExtendForm']]);
    }

    private function reviewNotification(){
        $hseUser = User::role('hse')->get();
        $data = [
            'title' => 'New Form To Review',
            'message' => 'New form awaiting your review.'
        ];
        Notification::send($hseUser, new PrNotification($data));
    }

    private function reviewEmail($formId){
        $approver = approver::where('level', 1)
        ->pluck('name')
        ->first();
        $toUser = User::role('hse')->pluck('email')->toArray();
        $form = Form::find($formId);
        $projectExecutor = projectExecutor::where('form_id', $formId)->first();
        sendToApproverJob::dispatch($toUser, $form, $projectExecutor, $approver); // send email
    }

    public function viewList()
    {
        $user = Auth::user();
        if($user){
            $forms = Form::where('user_id', $user->id)
            ->select('forms.id as id', 'forms.created_at as created_at', 'forms.updated_at as updated_at', 'forms.status as status' , DB::raw("COUNT(approval_details.form_id) as 'count'"))
            ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->leftJoin('approval_details', 'approval_details.form_id', '=', 'forms.id')
            ->groupBy('forms.id','forms.created_at', 'forms.updated_at', 'forms.status')
            ->orderBy('forms.id', 'asc')
            ->get(); 

            $today = Carbon::today();

            $extendValue = Form::where('user_id', $user->id)
            ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('status', "Approved")
            ->select('forms.id as id', 'project_executors.location as location', 'project_executors.start_date as start_date', 'project_executors.end_date as end_date')
            ->get();
            // dd($extendValue);

            return view('hse.guest.dashboard', compact('forms','extendValue'));
        }
        else{

        }
    }

    public function insertNewForm(Request $request)
    {
        $draft = $request->input('action');
        // dd($request);
        $form = null;
        if($draft){
            $form = Form::create([
                'user_id' => Auth::id(),
                'status' => "Draft"
            ]);
        }else{
            $form = Form::create([
                'user_id' => Auth::id(),
                'status' => "In Review"
            ]);
            
            // Notification Review to hse
            $this->reviewNotification();
        }
        
        
        $request->validate([
            'potentialHazards' => 'array',
            'personalProtectEquipments' => 'array',
            'workEquipments' => 'array',
            'fireHazardControls' => 'array',
            'additionalPermit' => ' array'
        ]);

        $formId = $form->id;

        projectExecutor::create([
            'form_id' => $formId,
            'company_department' => $request->input('Nama_Perusahaan_/_Departemen'),
            'hp_number' =>  (string) $request->input('No_HP'),
            'start_date' => $request->input('Tanggal_Mulai_Pelaksanaan'),
            'end_date' => $request->input('Tanggal_Berakhir_Pelaksanaan'),
            'supervisor' => $request->input('Penanggung_Jawab_Lapangan'),
            'location' => $request->input('Lokasi_Pekerjaan'),
            'start_time' => $request->input('Jam_Mulai_Kerja'),
            'end_time' => $request->input('Jam_Berakhir_Kerja'),
            'workers_count' => $request->input('Jumlah_Tenaga_Kerja'),
            'work_description' => $request->input('Penjelasan_Pekerjaan')
        ]);

        if ($request->filled('potentialHazards')) {
            foreach ($request->input('potentialHazards') as $item) {
                potentialHazardsInWorkplace_data::create([
                    'form_id' => $formId,
                    'master_id' => $item
                ]);
            }
        }
        if ($request->filled('newHazard')) {
            $newItemId = potentialHazardsInWorkplace_master::firstOrCreate([
                'name' => ucwords(strtolower($request->input('newHazardItem')))
            ]);
            potentialHazardsInWorkplace_data::create([
                'form_id' => $formId,
                'master_id' => $newItemId->id
            ]);
        }

        if ($request->filled('personalProtectEquipments')) {
            foreach ($request->input('personalProtectEquipments') as $item) {
                personalProtectiveEquipment_data::create([
                    'form_id' => $formId,
                    'master_id' => $item
                ]);
            }
        }
        if ($request->filled('workEquipments')) {
            foreach ($request->input('workEquipments') as $item) {
                workEquipments_data::create([
                    'form_id' => $formId,
                    'master_id' => $item
                ]);
            }
        }
        if ($request->filled('newEquipment')) {
            $newItemId = workEquipments_master::firstOrCreate([
                'name' => ucwords(strtolower($request->input('newEquipmentText')))
            ]);
            workEquipments_data::create([
                'form_id' => $formId,
                'master_id' => $newItemId->id
            ]);
        }

        if ($request->filled('fireHazardControls')) {
            foreach ($request->input('fireHazardControls') as $item) {
                fireHazardControl_data::create([
                    'form_id' => $formId,
                    'master_id' => $item
                ]);
            }
        }
        if ($request->filled('additionalPermit')) {
            foreach ($request->input('additionalPermit') as $item) {
                additionalWorkPermits_data::create([
                    'form_id' => $formId,
                    'master_id' => $item
                ]);
            }
        }
        if ($request->filled('namaTenagaKerja')){
            foreach($request->input('namaTenagaKerja') as $name){
                if (trim($name) !== ''){
                    fitToWork::create([
                        'form_id' => $formId,
                        'worker_name'=> $name,
                        'ok' => False,
                        'not_ok' => False,
                        'clinic_check' => False
                    ]);
                } 
            }
        }

        $work_step = $request->input('workStep');
        $potential_danger = $request->input('potentialDanger');
        $risk_chance = $request->input('riskChance');
        $danger_control = $request->input('dangerControl');

        foreach ($potential_danger as $key => $potentialDanger) {
            jobSafetyAnalysis::create([
                'form_id' => $formId,
                'work_step' => $work_step[$key],
                'potential_danger' => $potential_danger[$key],
                'risk_chance' => $risk_chance[$key],
                'danger_control' => $danger_control[$key]
            ]);
        }

        if ($request->hasFile('uploadSIO')) {
            foreach ($request->file('uploadSIO') as $file) {
                $file->storeAs("public/hseFile/".$formId."/SIO", $file->getClientOriginalName());
                uploadFile::create([
                    'form_id' => $formId,
                    'type' => "SIO",
                    'file_name' => $file->getClientOriginalName(),
                    'file_location' => "public/hseFile/".$formId."/SIO/". $file->getClientOriginalName()
                ]);
            }
        }
        if ($request->hasFile('uploadSILO')) {
            foreach ($request->file('uploadSILO') as $file) {
                $file->storeAs("public/hseFile/".$formId."/SILO", $file->getClientOriginalName());
                uploadFile::create([
                    'form_id' => $formId,
                    'type' => "SILO",
                    'file_name' => $file->getClientOriginalName(),
                    'file_location' => "public/hseFile/".$formId."/SILO/". $file->getClientOriginalName()
                ]);
            }
        }

        if(!$draft){
            $this->reviewEmail($form->id);
        }

        return redirect()->route('hse.dashboard');
    }

    public function viewNewForm()
    {
        $potentialHazards = potentialHazardsInWorkplace_master::all();
        $personalProtectEquipments = personalProtectiveEquipment_master::all();
        $workEquipments= workEquipments_master::all();
        $additionalWorkPermits = additionalWorkPermits_master::all();
        $fireHazardControls = fireHazardControl_master::all();
        $locations = hseLocation::pluck('name');
        
        confirmDelete();
        
        return view('hse.guest.permitForm'
        ,compact("potentialHazards","personalProtectEquipments","workEquipments"
        ,"additionalWorkPermits","fireHazardControls", "locations"));
    }

    public function viewDraftForm(Request $request)
    {
        $user = Auth::user();

        $formId = $request->input('value'); 

        $form = Form::leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
        ->where('forms.id', $formId)
        ->first();
        
        if($form->status != "Draft" || $form->user_id != $user->id){
            return $this->viewList();
        }

        $locations = hseLocation::pluck('name');

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

        return view('hse.guest.formHSE', 
        compact('form', 'locations' ,'potentialHazards', 'potentialHazards_data',
            'personalProtectEquipments', 'personalProtectEquipments_data', 
            'workEquipments', 'workEquipments_data', 'files',
            'additionalWorkPermits', 'additionalWorkPermits_data', 
            'fireHazardControls', 'fireHazardControls_data',
            'workers', 'jsas'
        ));
        
    }

    public function insertForm(Request $request)
    {   

        $request->validate([
            'formId' => 'required',
            'potentialHazards' => 'array',
            'personalProtectEquipments' => 'array',
            'workEquipments' => 'array',
            'fireHazardControls' => 'array',
            'additionalPermit' => ' array'
        ]);
        
        $formId = $request->input('formId');

        // Pelaksana Pekerjaan
        projectExecutor::where('form_id', $formId)
        ->update(
            ['company_department' => $request->input('Nama_Perusahaan_/_Departemen'),
            'hp_number' => $request->input('No_HP'),
            'start_date' => $request->input('Tanggal_Mulai_Pelaksanaan'),
            'end_date' => $request->input('Tanggal_Berakhir_Pelaksanaan'),
            'supervisor' => $request->input('Penanggung_Jawab_Lapangan'),
            'location' => $request->input('Lokasi_Pekerjaan'),
            'start_time' => $request->input('Jam_Mulai_Kerja'),
            'end_time' => $request->input('Jam_Berakhir_Kerja'),
            'workers_count' => $request->input('Jumlah_Tenaga_Kerja'),
            'work_description' => $request->input('Penjelasan_Pekerjaan')
        ]);

        // Potensi Bahaya di Area Kerja
        $existingPotentialHazards = potentialHazardsInWorkplace_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id');
        $newPotentialHazardsInput = null;
        if ($request->filled('newHazard')){
            $newPotentialHazardsInput = potentialHazardsInWorkplace_master::where('name', ucwords(strtolower($request->input('newHazardItem'))))
            ->get()
            ->pluck('id')
            ->toArray();
        }
        $newPotentialHazardsInput = $newPotentialHazardsInput ?? []; 
        $newPotentialHazardsFromRequest = $request->input('potentialHazards') ?? [];
        $newPotentialHazards = array_merge($newPotentialHazardsFromRequest, $newPotentialHazardsInput);
        foreach ($existingPotentialHazards as $existingHazard) {
            if(!in_array($existingHazard, $newPotentialHazards)){
                potentialHazardsInWorkplace_data::where('form_id', $formId)
                ->where('master_id', $existingHazard)
                ->delete();
            }
        }
        if ($request->filled('potentialHazards')) {
            foreach ($request->input('potentialHazards') as $item) {
                potentialHazardsInWorkplace_data::firstOrCreate([
                    'form_id' => $formId,
                    'master_id' => $item
                ]);
            }
        }
        if ($request->filled('newHazard')) {
            $newItemId = potentialHazardsInWorkplace_master::firstOrCreate([
                'name' => ucwords(strtolower($request->input('newHazardItem')))
            ]);
            potentialHazardsInWorkplace_data::firstOrCreate([
                'form_id' => $formId,
                'master_id' => $newItemId->id
            ]);
        }
        
        // Alat Pelindung Diri(APD)
        $existingPersonalProtectiveEquipments = personalProtectiveEquipment_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id');
        $newPersonalProtectiveEquipments = $request->input('personalProtectEquipments') ?? [];
        foreach ($existingPersonalProtectiveEquipments as $existingEquipment) {
            if(!in_array($existingEquipment, $newPersonalProtectiveEquipments)){
                personalProtectiveEquipment_data::where('form_id', $formId)
                ->where('master_id', $existingEquipment)
                ->delete();
            }
        }
        if ($request->filled('personalProtectEquipments')) {
            foreach ($request->input('personalProtectEquipments') as $item) {
                personalProtectiveEquipment_data::firstOrCreate([
                    'form_id' => $formId,
                    'master_id' => $item
                ]);
            }
        }
        
        // Daftar Peralatan Kerja
        $existingWorkEquipments = workEquipments_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id');
        $newWorkEquipmentsInput = null;
        if ($request->filled('newEquipment')){
            $newWorkEquipmentsInput = workEquipments_master::where('name', ucwords(strtolower($request->input('newEquipmentText'))))
            ->get()
            ->pluck('id')
            ->toArray();
        }
        $newWorkEquipmentsInput = $newWorkEquipmentsInput ?? []; 
        $newWorkEquipmentsFromRequest = $request->input('workEquipments') ?? [];
        $newWorkEquipments = array_merge($newWorkEquipmentsFromRequest, $newWorkEquipmentsInput);
        foreach ($existingWorkEquipments as $existingEquipments) {
            if(!in_array($existingEquipments, $newWorkEquipments)){
                workEquipments_data::where('form_id', $formId)
                ->where('master_id', $existingEquipments)
                ->delete();
            }
        }
        if ($request->filled('workEquipments')) {
            foreach ($request->input('workEquipments') as $item) {
                workEquipments_data::firstOrCreate([
                    'form_id' => $formId,
                    'master_id' => $item
                ]);
            }
        }
        if ($request->filled('newEquipment')) {
            $newItemId = workEquipments_master::firstOrCreate([
                'name' => ucwords(strtolower($request->input('newEquipmentText')))
            ]);
            workEquipments_data::firstOrCreate([
                'form_id' => $formId,
                'master_id' => $newItemId->id
            ]);
        }

        // Ijin Kerja Tambahan yang Diperlukan
        $existingAdditionalPermits = additionalWorkPermits_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id');
        $newAdditionalPermits = $request->input('additionalPermit') ?? [];
        foreach ($existingAdditionalPermits as $existingPermit) {
            if(!in_array($existingPermit, $newAdditionalPermits)){
                additionalWorkPermits_data::where('form_id', $formId)
                ->where('master_id', $existingPermit)
                ->delete();
            }
        }
        if ($request->filled('additionalPermit')) {
            foreach ($request->input('additionalPermit') as $item) {
                additionalWorkPermits_data::firstOrCreate([
                    'form_id' => $formId,
                    'master_id' => $item
                ]);
            }
        }

        // Pengendali Bahaya Kebakaran
        $existingFireHazardControls= fireHazardControl_data::where('form_id', $formId)
        ->get()
        ->pluck('master_id');
        $newFireHazardControls = $request->input('fireHazardControls') ?? [];
        foreach ($existingFireHazardControls as $existingControl) {
            if(!in_array($existingControl, $newFireHazardControls)){
                fireHazardControl_data::where('form_id', $formId)
                ->where('master_id', $existingControl)
                ->delete();
            }
        }
        if ($request->filled('fireHazardControls')) {
            foreach ($request->input('fireHazardControls') as $item) {
                fireHazardControl_data::firstOrCreate([
                    'form_id' => $formId,
                    'master_id' => $item
                ]);
            }
        }

        //Fit To Work
        $existingWorkers= fitToWork::where('form_id', $formId)
        ->get()
        ->pluck('worker_name');
        $newWorkers = $request->input('namaTenagaKerja') ?? [];
        foreach ($existingWorkers as $existingWorker) {
            if(!in_array($existingWorker, $newWorkers)){
                fitToWork::where('form_id', $formId)
                ->where('worker_name', $existingWorker)
                ->delete();
            }
        }
        if ($request->filled('namaTenagaKerja')){
            foreach($request->input('namaTenagaKerja') as $name){
                if (trim($name) !== ''){
                    fitToWork::firstOrCreate([
                        'form_id' => $formId,
                        'worker_name'=> $name,
                        'ok' => False,
                        'not_ok' => False,
                        'clinic_check' => False
                    ]);
                } 
            }
        }
        
        // Job Safety Analysis
        $work_step = $request->input('workStep');
        $potential_danger = $request->input('potentialDanger');
        $risk_chance = $request->input('riskChance');
        $danger_control = $request->input('dangerControl');

        $existingJsasPotentialDanger= jobSafetyAnalysis::where('form_id', $formId)
        ->select('work_step')
        ->get()
        ->toArray();
        $newJsasPotentialDanger=[];
        foreach ($potential_danger as $key => $potentialDanger) {
            $newJsasPotentialDanger[] = [
                'work_step' => $work_step[$key]
            ];
        }
        foreach ($existingJsasPotentialDanger as $existingDanger) {
            if(!in_array($existingDanger, $newJsasPotentialDanger)){
                jobSafetyAnalysis::where('form_id', $formId)
                    ->where('work_step', $existingDanger["work_step"])
                    ->delete();
            }
        }

        foreach ($potential_danger as $key => $potentialDanger) {
            if (trim($potential_danger[$key]) !== '' || trim($danger_control[$key]) !== ''){
                jobSafetyAnalysis::updateOrCreate(
                    [
                    'form_id' => $formId,
                    'work_step' => $work_step[$key]
                    ],
                    [
                    'potential_danger' => $potential_danger[$key],
                    'risk_chance' => $risk_chance[$key],
                    'danger_control' => $danger_control[$key]
                    ]
                );
            }
        }

        if ($request->hasFile('uploadSIO')) {
            $sioFiles = uploadFile::where('form_id', $formId)
            ->where('type', 'SIO')
            ->get();

            if(!empty($sioFiles)){
                foreach($sioFiles as $file){
                    $filePath = "public/hseFile/".$formId."/SIO/". $file->file_name;
                    if (Storage::exists($filePath)) {
                        Storage::delete($filePath);
                        uploadFile::where('form_id', $formId)
                        ->where('type', 'SIO')
                        ->where('file_name', $file->file_name)
                        ->delete();
                    }
                }
            }

            foreach ($request->file('uploadSIO') as $file) {
                $file->storeAs("public/hseFile/".$formId."/SIO", $file->getClientOriginalName());
                uploadFile::create([
                    'form_id' => $formId,
                    'type' => "SIO",
                    'file_name' => $file->getClientOriginalName(),
                    'file_location' => "public/hseFile/".$formId."/SIO/". $file->getClientOriginalName()
                ]);
            }
        }

        if ($request->hasFile('uploadSILO')) {
            $siloFiles = uploadFile::where('form_id', $formId)
            ->where('type', 'SILO')
            ->get();

            if(!empty($siloFiles)){
                foreach($siloFiles as $file){
                    $filePath = "public/hseFile/".$formId."/SILO/". $file->file_name;
                    if (Storage::exists($filePath)) {
                        Storage::delete($filePath);
                        uploadFile::where('form_id', $formId)
                        ->where('type', 'SILO')
                        ->where('file_name', $file->file_name)
                        ->delete();
                    }
                }
            }
            foreach ($request->file('uploadSILO') as $file) {
                $file->storeAs("public/hseFile/".$formId."/SILO", $file->getClientOriginalName());
                uploadFile::create([
                    'form_id' => $formId,
                    'type' => "SILO",
                    'file_name' => $file->getClientOriginalName(),
                    'file_location' => "public/hseFile/".$formId."/SILO/". $file->getClientOriginalName()
                ]);
            }
        }
        
        $draft = $request->input('action');
        $form = null;
        if($draft){
            return redirect()->route('hse.dashboard');
        }else{
            $form = Form::find($formId);    
            $form->status = 'In Review';
            $form->save(); // Simpan perubahan
            
            // Notification Review to hse
            $this->reviewNotification();
            $this->reviewEmail($form->id);

            return redirect()->route('hse.dashboard');
        }

        return redirect()->route('hse.dashboard');
    }

    public function deleteForm(Request $request)
    {
        $user = Auth::user();
        $form = Form::findOrFail($request->input('value'));
        if($form->status === "Draft"  && $form->user_id == $user->id){
            if (Storage::exists("public/hseFile/".$form->id)) {
                Storage::disk('public')->deleteDirectory('hseFile/'.$form->id);
            }
            $form->delete();
            return redirect()->back()->with('success', 'Data berhasil di delete!');
        }
        else{
            return redirect()->back();
        }

        
    }

    public function viewExtendForm(Request $request){
        $user = Auth::user();

        $formId = $request->input('value'); 

        $form = Form::leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
        ->where('forms.id', $formId)
        ->first();      

        // dd($formId);

        if($form->user_id != $user->id){
            return $this->viewList();
        }

        $locations = hseLocation::pluck('name');

        confirmDelete();

        return view('hse.guest.extendForm', compact('form', 'locations'));
    }

    public function insertExtendForm(Request $request){
        $user = Auth::user();

        $newForm = Form::create([
            'user_id' => Auth::id(),
            'status' => "In Review"
        ]);

        $formId = $request->input('formId');
        
        
        // Pelaksana Pekerjaan
        $oldProject = projectExecutor::findOrFail($formId);
        if($oldProject){
            $newProject = $oldProject->replicate();
            $newProject->form_id = $newForm->id;
            $newProject->start_date = $request->input('Tanggal_Mulai_Pelaksanaan');
            $newProject->end_date = $request->input('Tanggal_Berakhir_Pelaksanaan');
            $newProject->start_time = $request->input('Jam_Mulai_Kerja');
            $newProject->end_time = $request->input('Jam_Berakhir_Kerja');
            $newProject->save();
        }

        // Potensi Bahaya di Area Kerja
        $oldPotentials = potentialHazardsInWorkplace_data::where('form_id', $formId)->get();
        if($oldPotentials){
            foreach($oldPotentials as $oldPotential){
                $newPotential = $oldPotential->replicate();
                $newPotential->form_id = $newForm->id;
                $newPotential->save();
            }
        }

        // Alat Pelindung Diri (APD)
        $oldProtectiveEquipments = personalProtectiveEquipment_data::where('form_id', $formId)->get();
        if($oldProtectiveEquipments){
            foreach($oldProtectiveEquipments as $oldEquipment){
                $newEquipment = $oldEquipment->replicate();
                $newEquipment->form_id = $newForm->id;
                $newEquipment->save();
            }
        }
        
        // Daftar Peralatan Kerja
        $oldEquipments = workEquipments_data::where('form_id', $formId)->get();
        if($oldEquipments){
            foreach($oldEquipments as $oldEquipment){
                $newEquipment = $oldEquipment->replicate();
                $newEquipment->form_id = $newForm->id;
                $newEquipment->save();
            }
        }

        // Pengendali Bahaya Kebakaran
        $oldFireHazards = fireHazardControl_data::where('form_id', $formId)->get();
        if($oldFireHazards){
            foreach($oldFireHazards as $oldFireHazard){
                $newFireHazard = $oldFireHazard->replicate();
                $newFireHazard->form_id = $newForm->id;
                $newFireHazard->save();
            }
        }
        
        // Ijin Kerja Tambahan Yang Diperlukan
        $oldAdditionalPermits = additionalWorkPermits_data::where('form_id', $formId)->get();
        if($oldAdditionalPermits){
            foreach($oldAdditionalPermits as $oldAdditionalPermit){
                $newAdditionalPermit = $oldAdditionalPermit->replicate();
                $newAdditionalPermit->form_id = $newForm->id;
                $newAdditionalPermit->save();
            }
        }
        

        // Fit To Work
        $oldWorkers = fitToWork::where('form_id', $formId)->get();
        if($oldWorkers){
            foreach($oldWorkers as $oldWorker){
                $newWorker = $oldWorker->replicate();
                $newWorker->form_id = $newForm->id;
                $newWorker->save();
            }
        }
        
        
        // JobSafetyAnalysis
        $oldJsas = jobSafetyAnalysis::where('form_id', $formId)->get();
        if($oldJsas){
            foreach($oldJsas as $oldJsa){
                $newJsa = $oldJsa->replicate();
                $newJsa->form_id = $newForm->id;
                $newJsa->save();
            }
        }

        // Upload File
        $oldFiles = uploadFile::where('form_id', $formId)->get();
        if($oldFiles){
            foreach($oldFiles as $oldFile){
                $newFile = $oldFile->replicate();
                $newFile->form_id = $newForm->id;
                $newFile->file_location = "public/hseFile/".$newForm->id.'/'.$oldFile->type.'/'.$oldFile->file_name;
                $filePath = "public/hseFile/".$oldFile->form_id.'/'.$oldFile->type.'/'.$oldFile->file_name;
                
                $newFile->save();
                if (Storage::exists($filePath)) {
                    if (!Storage::exists("public/hseFile/".$newForm->id.'/'.$oldFile->type)) {
                        Storage::makeDirectory("public/hseFile/".$newForm->id.'/'.$oldFile->type);
                    }
                    Storage::copy($filePath,$newFile->file_location);
                }
            }
        }


        // Notification Review to hse
        $this->reviewNotification();
        $this->reviewEmail($newForm->id);

        return redirect()->route('hse.dashboard');
    }
}
