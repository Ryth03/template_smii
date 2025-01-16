<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\HSE\Form;
use App\Models\HSE\projectExecutor;
use App\Models\HSE\approvalDetail;
use App\Models\HSE\approver;
use App\Models\HSE\hseLocation;   
use App\Models\HSE\uploadFile;
use App\Models\HSE\extendedFormLog;  
use App\Models\HSE\additionalWorkPermits_master;
use App\Models\HSE\additionalWorkPermits_data;

class DashboardController extends Controller
{
    public function index()
    {
        confirmDelete();
        return view('dashboard');
    }

    public function getLeaderboardData(Request $request){
        
        $today = Carbon::today();
        $category = $request->get('category', '');
        $forms;
        if($category === 'activeTable')
        {
            $forms = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->whereRaw('LOWER(status) = ?', ['approved'])
            ->orderBy('start_date','ASC');

            if (auth()->user()->hasRole('hse')) {
                $forms->select('company_department',  DB::raw("CASE WHEN DATEDIFF(now(), start_date) > 3 THEN 'Send Reminder' ELSE DATE_FORMAT(end_date, '%e %M %Y') END as extra", $today));
            }else{
                $forms->select('company_department',  DB::raw("DATE_FORMAT(end_date, '%e %M %Y') as extra"));
            }

            $forms = $forms->limit(10)->get();
        }
        elseif($category === 'ratingTable'){
            $year = $request->get('year', '');
            $forms = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
            ->whereNotNull('total_rating')
            ->whereYear('start_date', $year)
            ->groupBy('company_department')
            ->select("company_department", DB::raw('SUM(total_rating) / COUNT(company_department) AS extra'))
            ->orderBy('extra','DESC')
            ->limit(10)
            ->get();
        }
        elseif($category === 'reviewTable'){
            $forms = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->whereRaw('LOWER(status) = ?', ['in review'])
            ->orderBy('forms.created_at','ASC')
            ->select("company_department", "status as extra")
            ->get();
        }
        elseif($category === 'approvalTable'){
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
                $forms = Form::where('status', 'In Approval')
                ->leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
                ->select('forms.id as id', 'project_executors.company_department as company_department', 'forms.status as extra')
                ->whereNotIn('forms.id',$approvalDetail)
                ->get();
            }elseif($approver->level === 2){
                $approvalDetail = approvalDetail::select('form_id')
                ->groupBy('form_id')
                ->havingRaw('COUNT(form_id) = 1')
                ->pluck('form_id');
                $forms = Form::where('status', 'In Approval')
                ->leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
                ->select('forms.id as id', 'project_executors.company_department as company_department', 'forms.status as extra')
                ->whereIn('forms.id',$approvalDetail)
                ->get();
            }elseif($approver->level === 3){
                $approvalDetail = approvalDetail::select('form_id')
                ->groupBy('form_id')
                ->havingRaw('COUNT(form_id) = 2')
                ->pluck('form_id');
                $forms = Form::where('status', 'In Approval')
                ->leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
                ->select('forms.id as id', 'project_executors.company_department as company_department', 'forms.status as extra')
                ->whereIn('forms.id',$approvalDetail)
                ->get();
            }
            if($userRole === 'pic location'){
                $location = hseLocation::where('nik', $user->nik)->get()->pluck('name');
                $forms = Form::leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
                ->where('status', 'In Approval')
                ->select('forms.id as id', 'project_executors.company_department as company_department', 'forms.status as extra')
                ->whereIn('forms.id',$approvalDetail)
                ->whereIn('location', $location)
                ->get();
            }
        }
        elseif($category === 'evaluationTable'){
            
            $user = Auth::user();
            $forms= Form::select("company_department", "forms.status as extra")
            ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
            ->whereRaw('LOWER(status) = ?', ['in evaluation'])
            ->orderBy('forms.created_at', 'asc');

            if($user->hasRole("hse")){
                $forms = $forms->whereNull('hse_rating')->get();
            }else if($user->hasRole("engineering manager")){
                $forms = $forms->whereNull('engineering_rating')->get();
            }else{
                return redirect()->route('dashboard');
            }
        
        }elseif($category === 'overdueTable'){
            $forms = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->where('end_date', '<', $today)
            ->whereRaw('LOWER(status) = ?', ['approved'])
            ->orderBy('start_date','ASC')
            ->select("company_department", DB::raw("'Overdue' as extra"))
            ->get();
        }
        
        return response()->json($forms);
    }

    public function getChartCategoryData(){
        $category = additionalWorkPermits_master::where('name', '!=', 'Menggunakan Scaffolding')->get();
        return response()->json($category);
    }

    public function getChartData(Request $request){
        $year = $request->get('year', '');
        $category = $request->get('category', '');

        $formsCreated = Form::whereRaw('LOWER(status) != ?', ['draft']); // ambil semua form kecuali draft
        $formsDone = Form::whereRaw('LOWER(status) = ?', ['finished']); // ambil form yang sudah finished saja

        if($category){
            $formsCreated = $formsCreated->leftJoin('additionalworkpermits_data', 'additionalworkpermits_data.form_id', '=', 'forms.id')
            ->where('additionalworkpermits_data.master_id', $category);
            
            $formsDone = $formsDone->leftJoin('additionalworkpermits_data', 'additionalworkpermits_data.form_id', '=', 'forms.id')
            ->where('additionalworkpermits_data.master_id', $category);
        }


        $formsCreated = $formsCreated->whereRaw('YEAR(forms.created_at) = ?', [$year])
        ->select(DB::raw('DATE_FORMAT(forms.created_at, "%b")  as month'))
        ->orderBy('forms.created_at', 'ASC')
        ->pluck('month')
        ->toArray(); 
        
        $formsDone = $formsDone->whereRaw('YEAR(forms.created_at) = ?', [$year])
        ->select(DB::raw('DATE_FORMAT(forms.created_at, "%b")  as month'))
        ->orderBy('forms.created_at', 'ASC')
        ->pluck('month')
        ->toArray(); 


        $monthCounts = [];
        foreach ($formsCreated as $month) {
            // Inisialisasi data
            if (!isset($monthCounts[$month])) {
                $monthCounts[$month] = ['created' => 0, 'finished' => 0];
            }
            $monthCounts[$month]['created']++; // Increment form created
        }
        foreach ($formsDone as $month) {
            $monthCounts[$month]['finished']++; // Increment form finished
        }

        $months = array_keys($monthCounts);  // Nama bulan
        $createdData = array_column($monthCounts, 'created'); // Data jumlah 'created'
        $doneData = array_column($monthCounts, 'finished');     // Data jumlah 'done'

        return response()->json([
            'formsCreated' => $createdData,
            'formsFinished' => $doneData,
            'months' => $months
        ]);
    }

    public function getSecurityData(Request $request){

        $today = Carbon::today();

        $forms = Form::leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
        ->where('start_date', '<=', $today)
        ->where('end_date', '>=', $today)
        ->where('status', "Approved")
        ->get();

        $files = uploadFile::leftJoin('forms', 'forms.id', '=', 'uploadfiles.form_id')
        ->where('status', "Approved")
        ->get();

        $hasFileList = uploadFile::leftJoin('forms', 'forms.id', '=', 'uploadfiles.form_id')
        ->where('status', "Approved")
        ->pluck('uploadfiles.form_id');

        return response()->json([
            'forms' => $forms,
            'files' => $files,
            'hasFileList' => $hasFileList
        ]);
    }

    public function getDashboardUser(Request $request){
        $user = Auth::user();
        $forms;
        if($user){
            if ($user->hasRole('hse') || $user->hasRole('engineering manager')) {
                $forms = Form::select('forms.id as id', 'forms.user_id as user_id', 'company_department', 'location', 'forms.status as status', 'start_date', 'end_date', DB::raw("COUNT(approval_details.form_id) as 'count'"), DB::raw("COUNT(CASE WHEN extended_form_logs.status = 'approved' THEN extended_form_logs.form_id END) as 'extendedCounts'"), DB::raw('COUNT(CASE WHEN hse_rating IS NOT NULL THEN 1 END) + COUNT(CASE WHEN engineering_rating IS NOT NULL THEN 1 END) AS count_rating'))
                ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
                ->leftJoin('approval_details', 'approval_details.form_id', '=', 'forms.id')
                ->leftJoin('extended_form_logs', 'extended_form_logs.form_id', '=', 'forms.id')
                ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
                ->groupBy('company_department', 'location', 'forms.status', 'forms.id', 'user_id', 'start_date', 'end_date')
                ->orderBy('forms.id', 'desc')
                ->orderBy('company_department', 'desc')
                ->get();
            }else{
                $forms = Form::where('user_id', $user->id)
                ->select('company_department','location','start_date', 'end_date','forms.id as id', 'forms.user_id as user_id', 'forms.created_at as created_at', 'forms.updated_at as updated_at', 'forms.status as status' , DB::raw("COUNT(approval_details.form_id) as 'count'"))
                ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
                ->leftJoin('approval_details', 'approval_details.form_id', '=', 'forms.id')
                ->groupBy( 'forms.id','company_department','user_id','location','start_date', 'end_date','forms.created_at', 'forms.updated_at', 'forms.status')
                ->orderBy('forms.id', 'desc')
                ->get(); 
            }
            

            return response()->json($forms);
        }
        return response()->json("No Data");
    }

    public function getExtendForms(Request $request){
        
        $today = Carbon::today();
        $user = Auth::user();
        if($user){
            $extendedForms = extendedFormLog::where('status', 'In Approval')->pluck('form_id');
            $forms = Form::where('user_id', $user->id)
            ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('status', "Approved")
            ->whereNotIn('forms.id', $extendedForms)
            ->select('forms.id as id', 'project_executors.location as location', 'project_executors.start_date as start_date', 'project_executors.end_date as end_date', 'status')
            ->get();

            return response()->json($forms);
        }

        return response()->json('test');
    }

    public function getExtendFormHistory(Request $request){
        
        $user = Auth::user();
        if($user){

            $form = Form::where('forms.id', $request->get('formId'))
            ->leftJoin('extended_form_logs', 'extended_form_logs.form_id', '=', 'forms.id')
            ->get();

            $form->each(function($item) {
                if ($item->start_date_before) {
                    $item->start_date_before = Carbon::parse($item->start_date_before)->format('d M Y');
                }
                if ($item->start_date_after) {
                    $item->start_date_after = Carbon::parse($item->start_date_after)->format('d M Y');
                }
                if ($item->end_date_before) {
                    $item->end_date_before = Carbon::parse($item->end_date_before)->format('d M Y');
                }
                if ($item->end_date_after) {
                    $item->end_date_after = Carbon::parse($item->end_date_after)->format('d M Y');
                }
            });

            return response()->json($form);
        }

        return response()->json('test');
    }
}
