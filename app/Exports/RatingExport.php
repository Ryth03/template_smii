<?php

namespace App\Exports;

use App\Models\HSE\Form;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class RatingExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents, ShouldQueue
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

   public function collection()
    {
        return Form::leftJoin('project_executors', 'project_executors.form_id', '=', 'forms.id')
            ->leftJoin('job_evaluations', 'job_evaluations.form_id', '=', 'forms.id')
            ->whereYear('forms.created_at', $this->year)
            ->whereNotNull('job_evaluations.hse_rating')
            ->whereNotNull('job_evaluations.engineering_rating')
            ->whereNotNull('job_evaluations.total_rating')
            ->groupBy('company_department')
            ->orderBy(DB::raw('AVG(total_rating)'), 'DESC')
            ->select("company_department", DB::raw('AVG(IFNULL(total_rating, 0.00)) as average_rating'))
            ->get();
    }

    public function headings(): array
    {
        return [
            'Company Department',
            'Total Rating',
        ];
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // Set title
                $sheet->setCellValue('A1', 'Rating Vendor Tahun: ' . $this->year);
                $sheet->mergeCells('A1:B1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Set headings style
                $sheet->getStyle('A3:B3')->getFont()->setBold(true);
                $sheet->getStyle('A3:B3')->getFill()->setFillType('solid')->getStartColor()->setARGB('FFCCCCCC');

                // Set borders
                $sheet->getStyle('A3:B' . (3 + $this->collection()->count()))
                      ->getBorders()->getAllBorders()->setBorderStyle('thin');

                // Set column width
                $sheet->getColumnDimension('A')->setWidth(30);
                $sheet->getColumnDimension('B')->setWidth(15);
            },
        ];
    }
}
