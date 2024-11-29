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
        $forms;
        
        if($user->hasRole("hse")){
            $forms = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
            ->where('status', 'Approved')
            ->select('forms.id as id', 'extend_from_form_id', 'company_department', 'supervisor', 'location', 'start_date', 'end_date', 'hse_rating')
            ->orderBy('forms.id', 'asc')
            ->get();
        }else if($user->hasRole("engineering manager")){
            $forms = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
            ->where('status', 'Approved')
            ->whereNotNull('hse_rating')
            ->select('forms.id as id', 'extend_from_form_id', 'company_department', 'supervisor', 'location', 'start_date', 'end_date', 'engineering_rating')
            ->orderBy('forms.id', 'asc')
            ->get();
        }
        
        foreach($forms as $form){
            if ($form->extend_from_form_id) {
                // Temukan form yang memiliki ID yang sama dengan extend_from_form_id
                $relatedForm = $forms->firstWhere('id', $form->extend_from_form_id);
                
                if ($relatedForm) {
                    if (strtotime($relatedForm->end_date) < strtotime($form->end_date)) {
                        // Jika form->end_date lebih lama, maka perbarui relatedForm->end_date
                        $relatedForm->end_date = $form->end_date;
                    }
                }
            }
        }

        if($user->hasRole("hse")){
            $forms = $forms->filter(function($form) {
                return $form->extend_from_form_id == null && $form->hse_rating == null; // Pilih yang supervisor tidak null
            });
        }else if($user->hasRole("engineering manager")){
            
            $forms = $forms->filter(function($form) {
                return $form->extend_from_form_id == null && $form->engineering_rating == null; // Pilih yang supervisor tidak null
            });
        }
        confirmDelete();
        return view('hse.admin.table.jobEvaluationTable', compact('forms'));
    }

    public function evaluateJob(Request $request){
        $formId = $request->input('formId');
        $form = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')->find($formId);
        $extendedForm = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
        ->where('extend_from_form_id', $formId)
        ->orderBy('end_date', 'desc')
        ->select('end_date')
        ->first();
        if($extendedForm){
            $form->end_date = $extendedForm->end_date;
        }
        return view('hse.admin.form.jobEvaluateForm', compact('form', 'formId'));
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
        }

        return redirect()->route('jobEvaluation.table');
    }

    public function viewJobEvaluationReport(){
        $forms = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
        ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
        ->select('forms.id as id', 'extend_from_form_id', 'company_department', 'supervisor', 'location', 'start_date', 'end_date', 'total_rating')
        // ->whereNotNull('total_rating')
        ->get();
        
        
        foreach($forms as $form){
            if ($form->extend_from_form_id) {
                // Temukan form yang memiliki ID yang sama dengan extend_from_form_id
                $relatedForm = $forms->firstWhere('id', $form->extend_from_form_id);
                
                if ($relatedForm) {
                    if (strtotime($relatedForm->end_date) < strtotime($form->end_date)) {
                        // Jika form->end_date lebih lama, maka perbarui relatedForm->end_date
                        $relatedForm->end_date = $form->end_date;
                    }
                }
            }
        }

        $forms = $forms->filter(function($form) {
            return $form->extend_from_form_id == null && $form->total_rating != null; // Pilih yang supervisor tidak null
        });

        return view('hse.admin.table.jobEvaluationReportTable', compact('forms'));
    }

    public function evaluateJobReport(Request $request){
        $formId = $request->input('formId');
        $form = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
        ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
        ->find($formId);
        $extendedForm = Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
        ->where('extend_from_form_id', $formId)
        ->orderBy('end_date', 'desc')
        ->select('end_date')
        ->first();
        if($extendedForm){
            $form->end_date = $extendedForm->end_date;
        }
        return view('hse.admin.form.jobEvaluateReportForm', compact('form', 'formId'));
    }
}
