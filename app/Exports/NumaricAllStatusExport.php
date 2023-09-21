<?php
// app/Exports/NumaricAllStatusExport.php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NumaricAllStatusExport implements FromView
{
    private $reportData;
    private $title;
    private $totals;
    private $statusCodes;

    public function __construct($reportData, $title, $totals, $statusCodes)
    {
        $this->reportData = $reportData;
        $this->title = $title;
        $this->totals = $totals;
        $this->statusCodes = $statusCodes;
    }

    public function view(): View
    {
        return view('exports.allstatus_report', [
            'statusCodes' => $this->statusCodes,
            'reportData' => $this->reportData,
            'title' => $this->title,
            'totals' => $this->totals,
        ]);
    }
}
