<?php

namespace App\Http\Controllers\HSE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\HSE\Form;
use App\Models\HSE\jobEvaluation;

class FormStateController extends Controller
{
    public function finishedWork(Request $request){
        $form = Form::find($request->input('formId'));
        $form->status = "In Evaluation";
        $form->save();
        return redirect()->route('viewAll.table');
        // dd($request, $form);
    }
}
