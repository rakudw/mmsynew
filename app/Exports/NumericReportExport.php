<?php
// app/Exports/NumericReportExport.php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NumericReportExport implements FromView
{
    private $reportData;
    private $title;
    private $totals;

    public function __construct($reportData, $title, $totals)
    {
        $this->reportData = $reportData;
        $this->title = $title;
        $this->totals = $totals;
    }

    public function view(): View
    {
        return view('exports.recieved_report', [
            'reportData' => $this->reportData,
            'title' => $this->title,
            'totals' => $this->totals,
        ]);
    }
}
