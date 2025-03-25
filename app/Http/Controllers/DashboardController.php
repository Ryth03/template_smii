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
use App\Models\HSE\fitToWork;
use App\Models\HSE\additionalWorkPermits_master;
use App\Models\HSE\additionalWorkPermits_data;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RatingExport;

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
            $forms = [];
            $allForm = collect();
            $approvalDetail = null;

            $approvers = approver::where('role_name', $userRole)
            ->select('name', 'level')
            ->get();

            if($user->hasRole('super-admin'))
            {
                $forms = Form::where('status', 'In Approval')
                ->leftJoin('project_executors', 'forms.id', '=', 'project_executors.form_id')
                ->select('forms.id as id', 'project_executors.company_department as company_department', 'forms.status as extra')
                ->get();
                return response()->json($forms);
            }
            else
            {
                if($approvers->isEmpty()){
                    return redirect()->route("dashboard");
                }
    
                foreach($approvers as $approver){
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
                    $allForm = $allForm->merge($forms);
                }
            }

            
            return response()->json($allForm);
        }
        elseif($category === 'evaluationTable'){

            $user = Auth::user();
            $forms= Form::select("company_department", "forms.status as extra")
            ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
            ->whereRaw('LOWER(status) = ?', ['in evaluation'])
            ->orderBy('forms.created_at', 'asc');
            if($user->hasRole("super-admin")){
                $forms = $forms->get();
            }else if($user->hasRole("hse")){
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

        $formsCreatedQuery = Form::whereRaw('LOWER(status) != ?', ['draft']);
        $formsDoneQuery = Form::whereRaw('LOWER(status) = ?', ['finished']);

        if ($category) {
            $formsCreatedQuery = $formsCreatedQuery->whereHas('additionalWorkPermitsData', function($query) use ($category) {
                $query->where('master_id', $category);
            });

            $formsDoneQuery = $formsDoneQuery->whereHas('additionalWorkPermitsData', function($query) use ($category) {
                $query->where('master_id', $category);
            });
        }

        $formsCreated = $formsCreatedQuery->whereYear('created_at', $year)
            ->select(DB::raw('DATE_FORMAT(created_at, "%b") as month'))
            ->orderBy('created_at', 'ASC')
            ->pluck('month')
            ->toArray();

        $formsDone = $formsDoneQuery->whereYear('created_at', $year)
            ->select(DB::raw('DATE_FORMAT(created_at, "%b") as month'))
            ->orderBy('created_at', 'ASC')
            ->pluck('month')
            ->toArray();

        $monthCounts = [];
        foreach ($formsCreated as $month) {
            if (!isset($monthCounts[$month])) {
                $monthCounts[$month] = ['created' => 0, 'finished' => 0];
            }
            $monthCounts[$month]['created']++;
        }
        foreach ($formsDone as $month) {
            $monthCounts[$month]['finished']++;
        }

        $months = array_keys($monthCounts);
        $createdData = array_column($monthCounts, 'created');
        $doneData = array_column($monthCounts, 'finished');

        return response()->json([
            'formsCreated' => $createdData,
            'formsFinished' => $doneData,
            'months' => $months
        ]);
    }

    public function getSecurityData(){

        $today = Carbon::today();

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

        $hasFileList = uploadFile::whereHas('form', function($query) {
            $query->where('status', "Approved");
        })->pluck('form_id');

        return response()->json([
            'forms' => $forms,
            'files' => $files,
            'ktps' => $ktps,
            'hasFileList' => $hasFileList
        ]);
    }

    public function getDashboardUser(Request $request)
    {
        $user = Auth::user();
        $forms;
        if($user){
            if ($user->hasRole('super-admin') || $user->hasRole('hse') || $user->hasRole('engineering manager')) {
                $forms = Form::select('forms.id as id', 'forms.user_id as user_id', 'company_department', 'location', 'forms.status as status', 'start_date', 'end_date', DB::raw("COUNT(approval_details.form_id) as 'count'"), DB::raw("COUNT(CASE WHEN extended_form_logs.status = 'approved' THEN extended_form_logs.form_id END) as 'extendedCounts'"), DB::raw('COUNT(DISTINCT CASE WHEN hse_rating IS NOT NULL THEN 1 END) + COUNT(DISTINCT CASE WHEN engineering_rating IS NOT NULL THEN 1 END) AS count_rating'))
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
    
     public function getRatingData(Request $request)
    {
        $year = $request->get('year', date('Y')); // Default ke tahun saat ini jika tidak ada yang disediakan

        $forms = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
            ->whereYear('forms.created_at', $year)
            ->groupBy('company_department')
            ->orderBy(DB::raw('AVG(total_rating)'), 'DESC')
            ->select("company_department", DB::raw('AVG(IFNULL(total_rating, 0.00)) as average_rating'))
            ->limit(10)
            ->get();

        // Mendapatkan daftar tahun yang tersedia
        $availableYears = Form::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'DESC')
            ->pluck('year');

        return response()->json([
            'forms' => $forms,
            'availableYears' => $availableYears
        ]);
    }

    public function exportRatingToExcel(Request $request)
    {
        $year = $request->get('year', date('Y'));

        return Excel::download(new RatingExport($year), 'Rating-' . $year . '.xlsx');
    }
}
