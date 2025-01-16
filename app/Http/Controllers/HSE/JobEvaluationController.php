<?php

namespace App\Http\Controllers\HSE;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HSE\Form;
use App\Models\HSE\jobEvaluation;

class JobEvaluationController extends Controller
{
    public function viewJobEvaluation(){

        $user = Auth::user();
        $forms = Form::select('forms.id as id', 'company_department', 'location', 'start_date', 'end_date')
        ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
        ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
        ->where('status', 'In Evaluation')
        ->orderBy('forms.id', 'asc');
        
        if($user->hasRole("hse")){
            $forms = $forms->whereNull('hse_rating')->get();
        }else if($user->hasRole("engineering manager")){
            $forms = $forms->whereNull('engineering_rating')->get();
        }else{
            return redirect()->route('dashboard');
        }
        
        confirmDelete();
        return view('hse.admin.table.jobEvaluationTable', compact('forms'));
    }

    public function evaluateForm(Request $request){
        
        $user = Auth::user();

        $questions;
        if($user->hasRole("hse")){
            $questions = [
                "Kepatuhan penggunaan APD",
                "Kepatuhan terhadap rambu yang dipasang di area",
                "Peralatan kerja / perlengkapan kerja yang digunakan",
                "Kesesuaian pekerjaan dengan JSA",
                "Kedisiplinan dalam menjaga area pekerjaan tetap bersih"
            ];
        }else if($user->hasRole("engineering manager")){
            $questions = [
                "Kualitas hasil pekerjaan",
                "Kesesuaian waktu pekerjaan dengan time / work schedule",
                "Keaktifan dalam menyampaikan informasi",
                "Kemudahan dalam mengarahkan pekerjaan",
                "Kompetensi / keahlian pekerja dan penanggung jawab lapangan"
            ];
        }else{
            return redirect()->route('dashboard');
        }


        $formId = $request->input('formId');

        $form = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
        ->where('forms.id', $formId)
        ->select('forms.id', 'company_department', 'location', 'start_date', 'end_date', 'work_description')
        ->first();

        $ratings = jobEvaluation::where('form_id', $formId)->first();
        return view('hse.admin.form.jobEvaluateForm', compact('form', 'questions', 'ratings'));
    }

    public function evaluate(Request $request){
        $user = Auth::user();
        $column;
        $total = 0;
        $loop = true;
        $index = 1;
        $formId = $request->input('formId');

        while($loop){
            if($request->input($index)){
                $total += (int) $request->input($index);
                $index += 1;
            }else{
                $loop = false;
            }
        }
        $total = $total/($index-1);
        
        if($user->hasRole('hse')){
            $column = 'hse_rating';
        }elseif($user->hasRole('engineering manager')){
            $column = 'engineering_rating';
        }
        
        jobEvaluation::updateOrCreate(
            ['form_id' => $formId],
            [
                $column => $total
            ]
        );

        $eval = jobEvaluation::where('form_id',$formId)->first();

        if(!is_null($eval->hse_rating) && !is_null($eval->engineering_rating)){
            $eval->total_rating = ($eval->hse_rating + $eval->engineering_rating)/2;
            $eval->save();
            
            $form = Form::find($formId);
            $form->status = "Finished";
            $form->save();
        }

        return redirect()->route('dashboard');
    }

    public function viewJobEvaluationReport(){        
        $forms = Form::select('forms.id as id', 'company_department', 'location', 'start_date', 'end_date')
        ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
        ->where('status', 'Finished')
        ->orderBy('forms.id', 'asc')
        ->get();
        

        return view('hse.admin.table.jobEvaluationReportTable', compact('forms'));
    }

    public function evaluateJobReport(Request $request){
        $formId = $request->input('formId');
        $form = Form::select('forms.id as id', 'company_department', 'supervisor', 'location', 'work_description', 'total_rating')
        ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
        ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
        ->find($formId);
        
        return view('hse.admin.form.jobEvaluateReportForm', compact('form', 'formId'));
    }
}
