<?php

namespace App\Helpers;

use App\Models\Meeting;
use App\Helpers\ApplicationHelper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportHelper
{

    public static function agenda(Meeting $meeting): Xlsx
    {
        $formatter = new \NumberFormatter('en-IN', \NumberFormatter::DECIMAL);
        $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 2);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet();

        // $spreadsheet->writeSheetRow('Sheet1', ['#', 'ID', 'Enterprise', 'Activity', 'Applicant', 'Category', 'Land', 'Building', 'Furniture, Fixtures & Other Fixed Assets', 'Machinery', 'Working Capital', 'Own Contribution', 'Term Loan', 'Working Capital', 'Project Cost', 'Subsidy', 'Bank', 'Bank Comments']);

        foreach (['#', 'Name', 'Mobile', 'Email', 'ID', 'Enterprise', 'Activity', 'Category', 'Employment Generation', 'Land', 'Building', 'Furniture, Fixtures & Other Fixed Assets', 'Machinery', 'Working Capital', 'Own Contribution', 'Term Loan', 'Working Capital', 'Project Cost', 'Subsidy', 'Bank',  'Bank Email', 'Bank Comments'] as $i => $header) {
            $spreadsheet->getActiveSheet()->setCellValue(self::getExcelColumnName($i) . '1', $header);
        }

        $totals = ['land_cost' => 0, 'building_cost' => 0, 'assets_cost' => 0, 'machinery_cost' => 0, 'working_capital' => 0, 'own_contribution_amount' => 0, 'term_loan' => 0, 'finance_working_capital' => 0, 'project_cost' => 0, 'subsidy' => 0];

        $dataArray = [];

        foreach ($meeting->applications as $i => $application) {
            $applicantCategory = 'General';
            foreach ($application->getCategories() as $category => $info) {
                if ($info['eligible'] > 0) {
                    $applicantCategory = $category;
                }
            }
            $branchEmail = [];
            if(ApplicationHelper::getBranchEmail($application->data->finance->bank_branch_id)){
                foreach(ApplicationHelper::getBranchEmail($application->data->finance->bank_branch_id) as $data){
                    $branchEmail = "[".$data['email']."]";
                }
            }
            $dataArray[] = [
                $i + 1,
                ($application->getData('owner', 'gender') == 'Male' ? 'Mr.' : ($application->getData('owner', 'gender') == 'Female' ? 'Ms.' : '')) . ' ' . $application->getData('owner', 'name'),
                $application->getData('owner', 'mobile'),
                ($application->getData('owner', 'email') ? "\n" . $application->getData('owner', 'email') : ''),
                $application->unique_id,
                "M/s {$application->getData('enterprise', 'name')}\n{$application->address}",
                "{$application->activity_type->value} - {$application->activity}",

                $applicantCategory,
                $application->getData('enterprise', 'employment'),
                $formatter->format($application->getData('cost', 'land_cost', null, 0) / 100000),
                $formatter->format($application->getData('cost', 'building_cost') / 100000),
                $formatter->format($application->getData('cost', 'assets_cost') / 100000),
                $formatter->format($application->getData('cost', 'machinery_cost') / 100000),
                $formatter->format($application->getData('cost', 'working_capital') / 100000),
                $formatter->format($application->own_contribution_amount / 100000),
                $formatter->format($application->term_loan / 100000),
                $formatter->format($application->finance_working_capital / 100000),
                $formatter->format($application->project_cost / 100000),
                $formatter->format($application->subsidy_amount / 100000),
                $application->bank_branch_details,
                $branchEmail,
                $application->bank_branch_details,
                $application->bank_remarks,
            ];

            $totals['land_cost'] += $application->getData('cost', 'land_cost');
            $totals['building_cost'] += $application->getData('cost', 'building_cost');
            $totals['assets_cost'] += $application->getData('cost', 'assets_cost');
            $totals['machinery_cost'] += $application->getData('cost', 'machinery_cost');
            $totals['working_capital'] += $application->getData('cost', 'working_capital');
            $totals['own_contribution_amount'] += $application->own_contribution_amount;
            $totals['term_loan'] += $application->term_loan;
            $totals['finance_working_capital'] += $application->finance_working_capital;
            $totals['project_cost'] += $application->project_cost;
            $totals['subsidy'] += $application->subsidy_amount;
        }

        $spreadsheet->getActiveSheet()->fromArray($dataArray, null, 'A2');

        return new Xlsx($spreadsheet);
    }

    private static function getExcelColumnName(int $index): string
    {
        return str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ')[$index];
    }
}
