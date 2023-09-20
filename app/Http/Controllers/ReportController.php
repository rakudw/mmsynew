<?php

namespace App\Http\Controllers;

use App\DataTables\ReportApplicationsDataTable;
use App\Enums\ApplicationStatusEnum;
use App\Models\ApplicationTimeline;
use App\Models\Bank;
use App\Models\BankBranch;
use App\Models\Region;
use App\Models\Views\ApplicationView;

class ReportController extends Controller
{
    public function banks()
    {
        $userBankIds = $this->user()->bank_ids;
        if (empty($userBankIds)) {
            return redirect()->route('dashboard');
        }

        if (count($userBankIds) == 1) {
            return redirect()->route('report.bank', ['bank' => $userBankIds[0]]);
        }

        $parameters = $this->getReportParameters();

        $stats = ApplicationView::when(
            $parameters['district'] > 0,
            fn($query) => $query->where('bank_branch_district_id', $parameters['district']),
            fn($query) => $query->whereIn('bank_branch_district_id', $this->user()->getDistricts())
        )->whereBetween('sponsored_at', array_values($parameters['period']))
            ->whereIn('bank_id', $userBankIds)
            ->where('status_id', '>', ApplicationStatusEnum::WITHDRAWN->id())
            ->select(['id', 'bank_id', 'bank_branch_id', 'status_id', 'capital_expenditure'])
            ->get()
            ->groupBy('bank_id')
            ->map(fn($applications) => $applications->groupBy('status_id')->all())
            ->all();

        $data = [];
        foreach ($stats as $bankId => $bankStats) {
            $data[$bankId] = [
                'sanctioned' => $this->getElementsCount($bankStats, $this->getSanctionedStatusIds()),
                'rejected' => $this->getElementsCount($bankStats, [ApplicationStatusEnum::LOAN_REJECTED->id()]),
                'pending' => $this->getElementsCount($bankStats, [ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id()]),
            ];
            $data[$bankId]['sponsored']['count'] = $data[$bankId]['sanctioned']['count'] + $data[$bankId]['rejected']['count'] + $data[$bankId]['pending']['count'];
            $data[$bankId]['sponsored']['capital_expenditure'] = $data[$bankId]['sanctioned']['capital_expenditure'] + $data[$bankId]['rejected']['capital_expenditure'] + $data[$bankId]['pending']['capital_expenditure'];
        }

        $this->setTitle('Banks Overview');
        $this->addJs('resources/ts/exporter.ts');
        return view('report.banks', [
            'banks' => Bank::select(['id', 'name', 'type_id'])
                ->whereIn('id', array_keys($data))
                ->orderBy('type_id')
                ->orderBy('name')
                ->get()
                ->groupBy('type_id'),
            'data' => $data,
            'parameters' => $parameters,
        ]);
    }

    public function bank(Bank $bank)
    {
        if (!in_array($bank->id, $this->user()->bank_ids)) {
            return redirect()->route('dashboard');
        }

        if ($this->user()->isBankManager() && count($this->user()->bank_branch_ids) == 1) {
            return redirect()->route('report.bank_branch', ['bankBranch' => $this->user()->bank_branch_ids[0]]);
        }

        $parameters = $this->getReportParameters();

        $stats = ApplicationView::when(
            $parameters['district'] > 0,
            fn($query) => $query->where('bank_branch_district_id', $parameters['district']),
            fn($query) => $query->whereIn('bank_branch_district_id', $this->user()->getDistricts())
        )->where('bank_id', $bank->id)->whereBetween('sponsored_at', array_values($parameters['period']))
            ->with(['bankBranch' => fn($query) => $query->select(['id', 'district_id', 'name', 'ifsc'])])
            ->where('status_id', '>', ApplicationStatusEnum::WITHDRAWN->id())
            ->when($this->user()->isBankManager(), fn($query) => $query->whereIn('bank_branch_id', $this->user()->bank_branch_ids))
            ->select(['bank_branch_id', 'status_id', 'bank_branch_district_id', 'capital_expenditure'])
            ->get()
            ->groupBy('bankBranch.district_id')
            ->map(fn($applications) => $applications
                    ->groupBy('bank_branch_id')
                    ->map(fn($records) => $records->groupBy('status_id'))
                    ->all()
            )->all();

        $data = [];
        foreach ($stats as $districtId => $districtStats) {
            foreach ($districtStats as $bankBranchId => $bankStats) {
                $arrBankStats = $bankStats->all();
                $data[$districtId][$bankBranchId] = [
                    'title' => $bankStats->first()[0]->bankBranch->name . ' - ' . $bankStats->first()[0]->bankBranch->ifsc,
                    'sanctioned' => $this->getElementsCount($arrBankStats, $this->getSanctionedStatusIds()),
                    'rejected' => $this->getElementsCount($arrBankStats, [ApplicationStatusEnum::LOAN_REJECTED->id()]),
                    'pending' => $this->getElementsCount($arrBankStats, [ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id()]),
                ];
                $data[$districtId][$bankBranchId]['sponsored'] = $data[$districtId][$bankBranchId]['sanctioned'] + $data[$districtId][$bankBranchId]['rejected'] + $data[$districtId][$bankBranchId]['pending'];
            }
        }

        $this->setTitle($bank->name);
        $this->addJs('resources/ts/exporter.ts');
        return view('report.bank', [
            'bank' => $bank,
            'data' => $data,
            'parameters' => $parameters,
        ]);
    }

    public function bankBranch(BankBranch $bankBranch)
    {

        $parameters = $this->getReportParameters();

        $stats = ApplicationView::where('bank_branch_id', $bankBranch->id)
            ->with([
                'applicationTimelines' => fn($query) => $query->where('new_status_id', ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())->orderByDesc('created_at'),
            ])->whereBetween('sponsored_at', array_values($parameters['period']))
            ->where('status_id', '>', ApplicationStatusEnum::WITHDRAWN->id())
            ->get();

        $data = [
            'sanctioned' => $stats->filter(fn($r) => in_array($r->status_id, $this->getSanctionedStatusIds()))->all(),
            'pending' => $stats->filter(fn($r) => $r->status_id == ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())->all(),
            'rejected' => $stats->filter(fn($r) => $r->status_id == ApplicationStatusEnum::LOAN_REJECTED->id())->all(),
        ];

        $rejections = [];
        if (count($data['rejected']) > 0) {
            $rejections = ApplicationTimeline::whereIn('application_id', collect($data['rejected'])->pluck('id')->all())->where('new_status_id', ApplicationStatusEnum::LOAN_REJECTED->id())->select(['application_id', 'remarks', 'created_at'])->get()->keyBy('application_id')->all();
        }

        $this->setTitle($bankBranch->name . ' - ' . $bankBranch->bank->name);
        $this->addJs('resources/ts/exporter.ts');
        return view('report.bank_branch', [
            'bankBranch' => $bankBranch,
            'data' => $data,
            'rejections' => $rejections,
            'parameters' => $parameters,
        ]);
    }

    private function getElementsCount(array $arr, array $keys): array
    {
        $result = ['count' => 0, 'capital_expenditure' => 0];
        foreach ($keys as $key) {
            if (isset($arr[$key])) {
                $result['count'] += count($arr[$key]);
                $result['capital_expenditure'] += $arr[$key]->sum('capital_expenditure');
            }
        }
        $result['capital_expenditure'] = $result['capital_expenditure'] / 100000;
        return $result;
    }

    private function getSanctionedStatusIds(): array
    {
        return collect(ApplicationStatusEnum::cases())->filter(fn(ApplicationStatusEnum $status) => $status->id() > ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())->map(fn(ApplicationStatusEnum $status) => $status->id())->all();
    }

    private function getReportParameters($date = null): array
    {
        $time = $date ? strtotime($date) : time();
        $currentYear = date('Y', $time);
        $period = [
            'start' => (date('m', $time) > 3 ? $currentYear : $currentYear - 1) . '-04-01',
            'end' => (date('m', $time) > 3 ? $currentYear + 1 : $currentYear) . '-03-31',
        ];

        if (request()->get('start')) {
            $period['start'] = request()->get('start');
        }
        if (request()->get('end')) {
            $period['end'] = request()->get('end');
        }
        if ($period['end'] > date('Y-m-d')) {
            $period['end'] = date('Y-m-d');
        }

        if ($period['start'] > $period['end']) {
            $endTime = strtotime($period['end']);
            $endPeriodYear = date('Y', $endTime);
            $period['start'] = (date('m', $endTime) > 3 ? $endPeriodYear : $endPeriodYear - 1) . '-04-01';
        }

        $userDistrictIds = $this->user()->getDistricts();
        $districtId = intval(request()->get('district'));
        if ($districtId && !in_array($districtId, $userDistrictIds)) {
            $districtId = null;
        }

        return [
            'period' => $period,
            'district' => $districtId,
            'districts' => Region::whereIn('id', $userDistrictIds)
                ->select(['id', 'name'])
                ->orderBy('name')
                ->pluck('name', 'id'),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function applications(ReportApplicationsDataTable $dataTable, string $type)
    {
        $this->setTitle(ucfirst($type) . ' Applications');
        return $dataTable->render('report.applications');
    }
}
