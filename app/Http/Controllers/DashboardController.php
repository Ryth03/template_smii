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

class DashboardController extends Controller
{
    public function index()
    {
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
            $forms = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
            ->orderBy('total_rating','DESC')
            ->select("company_department", 'total_rating as extra')
            ->limit(10)
            ->get();
        }
        elseif($category === 'reviewTable'){
            $forms = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->whereRaw('LOWER(status) = ?', ['in review'])
            ->orderBy('forms.created_at','ASC')
            ->select("company_department", "status as extra")
            ->limit(10)
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
                ->whereNotIn('id',$approvalDetail)
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
            $forms = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->whereRaw('LOWER(status) = ?', ['in evaluation'])
            ->orderBy('forms.created_at','ASC')
            ->select("company_department", "forms.status as extra")
            ->limit(10)
            ->get();
        }
        
        return response()->json($forms);
    }

    public function getChartData(Request $request){
        $year = $request->get('year', '');

        $formsCreated = Form::whereRaw('LOWER(status) != ?', ['draft']) // ambil semua form kecuali draft
        ->whereRaw('YEAR(created_at) = ?', [$year])
        ->select(DB::raw('DATE_FORMAT(created_at, "%b")  as month'))
        ->orderBy('created_at', 'ASC')
        ->pluck('month')
        ->toArray(); 

        $formsDone = Form::whereRaw('LOWER(status) = ?', ['finished']) // ambil form yang sudah finished saja
        ->whereRaw('YEAR(created_at) = ?', [$year])
        ->select(DB::raw('DATE_FORMAT(created_at, "%b")  as month'))
        ->orderBy('created_at', 'ASC')
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

        
        // return response()->json("test");

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
}
