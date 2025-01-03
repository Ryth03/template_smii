<?php

namespace App\Console\Commands;
use App\Models\HSE\Form;
use Carbon\Carbon;

use Illuminate\Console\Command;

class UpdateFormStatus extends Command
{
    protected $signature = 'forms:update-status';
    protected $description = 'Change forms status from Approved to In Evaluation if the end_date has passed';

    public function handle()
    {
        $forms = Form::where('status', 'Approved')
                    ->leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
                    ->where('end_date', '<', Carbon::now())
                    ->get();

        foreach ($forms as $form) {
            $form->status = 'In Evaluation';
            $form->save();
        }
    }
}
