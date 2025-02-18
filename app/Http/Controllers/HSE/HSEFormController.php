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
use App\Models\HSE\extendedFormLog;
use App\Models\HSE\extendedFilesLog;
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
        $toUser = User::role(strToLower($approver))->pluck('email')->toArray();
        $form = Form::find($formId);
        $projectExecutor = projectExecutor::where('form_id', $formId)->first();
        sendToApproverJob::dispatch($toUser, $form, $projectExecutor, $approver); // send email
    }

    private function extendFormNotif($formId){
        $hseUser = User::role('hse')->get();
        $data = [
            'title' => 'New Form To Extend',
            'message' => 'A form awaiting your approval.'
        ];
        Notification::send($hseUser, new PrNotification($data));

        $approver = approver::where('role_name', 'hse')
        ->pluck('name')
        ->first();
        $toUser = User::role('hse')->pluck('email')->toArray();
        $newForm = collect();
        $newForm->status = 'In Approval (Extend)';
        $projectExecutor = projectExecutor::where('form_id', $formId)->first();
        sendToApproverJob::dispatch($toUser, $newForm, $projectExecutor, $approver); // send email
    }

    public function viewList()
    {
        return redirect()->route('dashboard');
    }

    public function insertNewForm(Request $request)
    {
        $draft = $request->input('action');
        
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
            foreach($request->input('namaTenagaKerja') as $index => $name){
                if (trim($name) !== ''){
                    $file = $request->file('ktpTenagaKerja')[$index];
                    $file->storeAs("public/hseFile/".$formId."/KTP", $index+1 . '_' . $name . '.' . $file->getClientOriginalExtension());
                    fitToWork::firstOrCreate([
                        'form_id' => $formId,
                        'worker_name'=> $name,
                        'ok' => False,
                        'not_ok' => False,
                        'clinic_check' => False,
                        'file_path' => "/storage/hseFile/".$formId."/KTP/". $index+1 . '_' . $name . '.' . $file->getClientOriginalExtension()
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
                    'file_location' => "/storage/hseFile/".$formId."/SIO/". $file->getClientOriginalName()
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
                    'file_location' => "/storage/hseFile/".$formId."/SILO/". $file->getClientOriginalName()
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
        $department = Auth::user()->company_department;
        confirmDelete();
        
        return view('hse.guest.permitForm'
        ,compact("department","potentialHazards","personalProtectEquipments","workEquipments"
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
        // $tempFile = null;
        // if(isset($request->file('ktpTenagaKerja')[1])){
        //     $tempFile = $request->file('ktpTenagaKerja')[1];
        // }
        // dd($tempFile, $request, $request->input('ktpTenagaKerja'));
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
            foreach($request->input('namaTenagaKerja') as $index => $name){
                if (trim($name) !== ''){
                    if(isset($request->file('ktpTenagaKerja')[$index])){
                        $file = $request->file('ktpTenagaKerja')[$index];
                        $file->storeAs("public/hseFile/".$formId."/KTP", $index+1 . '_' . $name . '.' . $file->getClientOriginalExtension());
                        fitToWork::updateOrCreate([
                            'form_id' => $formId,
                            'worker_name'=> $name
                        ],[
                            'ok' => False,
                            'not_ok' => False,
                            'clinic_check' => False,
                            'file_path' => "/storage/hseFile/".$formId."/KTP/". $index+1 . '_' . $name . '.' . $file->getClientOriginalExtension()
                        ]);
                    }else{
                        fitToWork::updateOrCreate([
                            'form_id' => $formId,
                            'worker_name'=> $name
                        ],[
                            'ok' => False,
                            'not_ok' => False,
                            'clinic_check' => False,
                            'file_path' => $request->input('ktpTenagaKerja')[$index]
                        ]);
                    }
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
                    'file_location' => "/storage/hseFile/".$formId."/SIO/". $file->getClientOriginalName()
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
                    'file_location' => "/storage/hseFile/".$formId."/SILO/". $file->getClientOriginalName()
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

        if($form->user_id != $user->id){
            return $this->viewList();
        }

        $locations = hseLocation::pluck('name');

        confirmDelete();

        return view('hse.guest.extendForm', compact('form', 'locations'));
    }

    public function insertExtendForm(Request $request){
        // $path = $file[0]->storeAs("public/hseFile/16/SIO", $file[0]->getClientOriginalName());
        // $url = Storage::url($path);
        
        $user = Auth::user();
        $formId = $request->input('formId');
        $form = Form::find($formId);

        if($user->id === $form->user_id && $form->status === 'Approved'){

            $formDetail = projectExecutor::where('form_id', $formId)->first();
            $extendedForm = extendedFormLog::create([
                'form_id' => $formId,
                'start_date_before' => $formDetail->start_date,
                'end_date_before' => $formDetail->start_date,
                'start_date_after' => $request->input('Tanggal_Mulai_Pelaksanaan'),
                'end_date_after' => $request->input('Tanggal_Berakhir_Pelaksanaan'),
                'status' => 'In Approval'
            ]);

            if ($request->hasFile('uploadSIO')) {
                $oldFileNames = [];
                $newFileNames = [];

                $sioFiles = uploadFile::where('form_id', $formId)
                ->where('type', 'SIO')
                ->get();

                if(!empty($sioFiles)){
                    foreach($sioFiles as $file){
                        $fileName = $file->file_name;
                        $oldFileNames = $fileName;
                    }
                }

                foreach ($request->file('uploadSIO') as $file) {
                    $fileName = time(). '_' .$file->getClientOriginalName();
                    $file->storeAs("public/hseFile/".$formId."/SIO", $fileName);
                    $newFileNames[] = $fileName;
                }
                
                extendedFilesLog::Create([
                    'extended_id' => $extendedForm->id,
                    'form_id' => $formId,
                    'type' => 'SIO',
                    'file_location' => '/storage/hseFile/'.$formId.'/SIO/',
                    'file_name_before' =>  empty($oldFileNames) ? null : json_encode($oldFileNames),
                    'file_name_after' => json_encode($newFileNames)
                ]);
            }
    
            if ($request->hasFile('uploadSILO')) {
                $oldFileNames = [];
                $newFileNames = [];
                
                $siloFiles = uploadFile::where('form_id', $formId)
                ->where('type', 'SILO')
                ->get();
    
                if(!empty($siloFiles)){
                    foreach($siloFiles as $file){
                        $fileName = $file->file_name;
                        $oldFileNames = $fileName;
                    }
                }
                
                foreach ($request->file('uploadSILO') as $file) {
                    $fileName = time(). '_' .$file->getClientOriginalName();
                    $file->storeAs("public/hseFile/".$formId."/SILO", $fileName);
                    $newFileNames[] = $fileName;
                }

                
                extendedFilesLog::Create([
                    'extended_id' => $extendedForm->id,
                    'form_id' => $formId,
                    'type' => 'SILO',
                    'file_location' => '/storage/hseFile/'.$formId.'/SILO/',
                    'file_name_before' =>  empty($oldFileNames) ? null : json_encode($oldFileNames),
                    'file_name_after' => json_encode($newFileNames)
                ]);
            }

            $this->extendFormNotif($formId);
        }
        
        return redirect()->route('dashboard');
    }

    public function destroyFile($id)
    {
        $file = fitToWork::findOrFail($id);
        Storage::delete('public/' . $file->file_path);
        $file->file_path = null;
        $file->save();

        return response()->json(['message' => 'File deleted successfully']);
    }
}
