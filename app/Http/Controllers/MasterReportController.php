<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Region;
use App\Models\Enum;
use App\Models\Activity;
use App\Enums\ApplicationStatusEnum;
use App\Exports\NumericReportExport;
use App\Exports\NumaricAllStatusExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class MasterReportController extends Controller
{
    public function index(Request $request)
    {
        // Get Data from Filters
        $district_ids = request()->get('district_id') ? request()->get('district_id') : 'All';
        $tehsil_ids = request()->get('tehsil_id') ? request()->get('tehsil_id') : 'All';
        $constituency_ids = request()->get('constituency_id') ? request()->get('constituency_id') : 'All';
        $block_ids = request()->get('block_id') ? request()->get('block_id') : 'All';
        $panchayat_ids = request()->get('panchayat_id') ? request()->get('panchayat_id') : 'All';
        $category_ids = request()->get('cat_id') ? request()->get('cat_id') : 'All';
        $activity_ids = request()->get('activity_id') ? request()->get('activity_id') : 'All';
        $perPage = request()->get('per_page') ? request()->get('per_page') : 50;
        // $cat_id = request()->get('cat_id') ? request()->get('cat_id') : 'All';
        // Get Data from Filters
        $result = $this->query(Application::forCurrentUser());
        $statusId = $result['statusId'];
        $title = $result['title'];
        $districts = Region::userBasedDistricts(null)->select('name', 'id')->get();
        $districtsIds = $district_ids == 'All' ? Region::userBasedDistricts(null)->pluck('id')->values() : $district_ids;

        $query = $result['query']->whereIn('region_id', $districtsIds);
        $constituencies = Region::getConstituency(null)->select('name', 'id')->get();
        $constituenciesIds = $constituency_ids == 'All' ? Region::getConstituency(null)->pluck('id')->values() : $constituency_ids;
        $tehsils = Region::getTehsil(null)->select('name', 'id')->get();
        $tehsilsIds = $tehsil_ids == 'All' ? Region::getTehsil(null)->pluck('id')->values() : $tehsil_ids;
        $blocks = Region::getBlock(null)->select('name', 'id')->get();
        $blockIds = $block_ids == 'All' ? Region::getBlock(null)->pluck('id')->values() : $block_ids;
        $panchayatWards = Region::getPanchayatWard($blockIds)->select('name', 'id')->get();
        $panchayatWardsIds =  $panchayat_ids == 'All' ? Region::getPanchayatWard($blockIds)->pluck('id')->values() : $panchayat_ids;

        // tehsilsIds
        if ($tehsil_ids != 'All') {
            $query->where(function ($query) use ($tehsilsIds) {
                $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.tehsil_id'))) LIKE ?", ['%' . strtolower('null') . '%']);
                foreach ($tehsilsIds as $tehsilId) {
                    $tehsilIdAsString = strval($tehsilId);
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.tehsil_id'))) LIKE ?", ['%' . strtolower($tehsilIdAsString) . '%']);
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.tehsil_id'))) LIKE ?", ['%' . strtolower($tehsilIdAsString) . '%']);
                }
            })->get();
        }
        // constituenciesIds
        if ($constituency_ids != 'All') {
            $query->where(function ($query) use ($constituenciesIds) {
                foreach ($constituenciesIds as $constituenciesId) {
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.constituency_id'))) LIKE ?", ['%' . strtolower('null') . '%']);
                    $constituenciesIdAsString = strval($constituenciesId);
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.constituency_id'))) LIKE ?", ['%' . strtolower($constituenciesIdAsString) . '%']);
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.constituency_id'))) LIKE ?", ['%' . strtolower($constituenciesIdAsString) . '%']);
                }
            })->get();
        }

        // blockIds
        if ($block_ids != 'All') {
            $query->where(function ($query) use ($blockIds) {
                foreach ($blockIds as $blockId) {
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.block_id'))) LIKE ?", ['%' . strtolower('null') . '%']);
                    $blockIdAsString = strval($blockId);
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.block_id'))) LIKE ?", ['%' . strtolower($blockIdAsString) . '%']);
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.block_id'))) LIKE ?", ['%' . strtolower($blockIdAsString) . '%']);
                }
            })->get();
        }
        // panchayatWardsIds
        if ($panchayat_ids != 'All') {
            $query->where(function ($query) use ($panchayatWardsIds) {
                foreach ($panchayatWardsIds as $panchayatWardsId) {
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.panchayat_id'))) LIKE ?", ['%' . strtolower('null') . '%']);
                    $panchayatWardsIdAsString = strval($panchayatWardsId);
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.panchayat_id'))) LIKE ?", ['%' . strtolower($panchayatWardsIdAsString) . '%']);
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.panchayat_id'))) LIKE ?", ['%' . strtolower($panchayatWardsIdAsString) . '%']);
                }
            })->get();
        }
        // categoryIds
        if ($category_ids != 'All') {
            $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.social_category_id'))) LIKE ?", ['%' . $category_ids . '%'])->get();
        }
        // ActivityIds
        if ($activity_ids != 'All') {
            $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.activity_id'))) LIKE ?", ['%' . $activity_ids . '%'])->get();
        }

        $applications = $query->paginate($perPage == "All" ? 500000 : $perPage);
        // dd($applications);

        $categories = DB::table('enums')
            ->where('type', 'SOCIAL_CATEGORY')
            ->select('id', 'name')
            ->get();

        $activities = Activity::select('id', 'name')->get();
        // dd($query->toSql());
        return view('master_report.index', compact('applications', 'statusId', 'districts', 'constituencies', 'tehsils', 'blocks', 'panchayatWards', 'title', 'categories', 'activities', 'perPage'));
    }
    public function convertDate($dateString) {
        // Define the possible date formats
        $formats = ['d/m/Y', 'Y/m/d', 'm/d/Y'];

        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $dateString);
            if ($date !== false) {
                // If the date was successfully created, return the DateTime object
                return $date;
            }
        }

        // If no format worked, return null or throw an exception
        throw new \Exception("Invalid date format: $dateString");
    }
    public function query($query)
    {
        $statusId = null;
        $title = '';
        $selectedFY = request()->get('fy'); // Get the selected fiscal year from the request
        if ($selectedFY && $selectedFY != 'All') {
            // Split the fiscal year into two years
            list($startYear, $endYear) = explode('-', $selectedFY);

            // Calculate the start and end dates of the fiscal year
            $startDate = "{$startYear}-04-01";
            $endDate = "{$endYear}-03-31";

            // Add a condition to filter by fiscal year
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } else {
            if (request()->get('startDate')) {
                $endDate = $this->convertDate(request()->get('endDate'));
                $formattedEndDate = $endDate->format('Y-m-d');
                $startDate = $this->convertDate(request()->get('startDate'));
                $formattedstartDate = $startDate->format('Y-m-d');
                $query->whereBetween('created_at', [$formattedstartDate, $formattedEndDate]);
            }
        }

        switch (request()->route()->parameter('type')) {
            case 'pending':
                $statusId =  [
                    ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER->id(),
                    ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS->id(),
                    ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id(),
                    ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST->id(),
                    ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE->id(),
                    ApplicationStatusEnum::PENDING_40_SUBSIDY_APPROVAL->id(),
                    ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE->id(),
                ];
                $query->whereIn('status_id', request()->get('status_id') ? [request()->get('status_id')] : $statusId)->orderBy('updated_at', 'DESC');
                $title = "Pending Applications at DIC or Before";
                break;
            case 'sponsored':
                $statusId = [
                    ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id(),
                    ApplicationStatusEnum::LOAN_DISBURSED->id()
                ];
                $query->whereIn('status_id', request()->get('status_id') ? [request()->get('status_id')] : $statusId)->orderBy('updated_at', 'DESC');
                $title = "Sponsored Applications to Bank";
                break;
            case 'sanctioned':
                if (request()->route()->parameter('step') == '60') {
                    $statusId = [
                        ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST->id(),
                        ApplicationStatusEnum::PENDING_60_SUBSIDY_RELEASE->id(),
                        ApplicationStatusEnum::SUBSIDY_60_RELEASED->id()
                    ];
                    $title = "Senctioned Applications for 60% subsidy";
                } else {
                    $statusId = [
                        ApplicationStatusEnum::PENDING_40_SUBSIDY_RELEASE->id(),
                        ApplicationStatusEnum::SUBSIDY_40_RELEASED->id()
                    ];
                    $title = "Senctioned Applications for 40% subsidy";
                }
                $query->whereIn('status_id', request()->get('status_id') ? [request()->get('status_id')] : $statusId)->orderBy('updated_at', 'DESC');
                break;
            case 'rejected':
                // dd(intval(request()->get('status_id')));
                $statusId = intval(request()->get('status_id')) ? [intval(request()->get('status_id'))] :  [
                    ApplicationStatusEnum::LOAN_REJECTED->id(),
                    ApplicationStatusEnum::REJECTED_AT_DISTRICT_INDUSTRIES_CENTER->id(),
                    ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id()
                ];
                $query->whereIn('status_id', request()->get('status_id') ? [request()->get('status_id')] : $statusId)->orderBy('updated_at', 'DESC');
                $title = "Rejeted Application at all level";
                break;
            case 'cgtmse':
                $statusId = null;
                $query->where('status_id', '>', 314)->orderBy('updated_at', 'DESC');
                $query->where(function ($query) {
                    $query->where(function ($query) {
                        $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.old_annexure_a.gaa_amount_cgtmse')) > 0");
                    })->orWhere(function ($query) {
                        $query->where('id', '<', 25000);
                        $query->where(function ($query) {
                            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.subsidy.cgtmse_fee')) > 0");
                        });
                    });
                });

                $title = "CGTMSE Fee";
                break;
            default:

                if (request()->get('status_id') == 100) {
                    $statusId = [
                        309, 310, 311, 312, 313, 314, 315, 316, 317, 318, 319, 320, 321
                    ];
                } else {
                    $statusId = intval(request()->get('status_id')) ? [intval(request()->get('status_id'))] :  [
                        303, 304, 305, 306, 307, 308, 309, 310, 311, 312, 313, 314, 315, 316, 317, 318, 319, 320, 321
                    ];
                }
                // dd($statusId);
                if (request()->route()->parameter('step') == 1) {
                    $statusId = intval(request()->get('status_id')) ? [intval(request()->get('status_id'))] :  [314, 315, 316, 317, 318, 319, 320, 321];
                    $query = Application::whereIn('status_id', $statusId);
                } else if (request()->get('kind') == 'inc') {
                    $query->where('status_id','>', $statusId);
                } else if (request()->get('kind') == 'not') {
                    $query->whereNot('status_id', $statusId);
                } else if (request()->get('kind') == 'arr_not') {
                    $statusIds = request()->get('status_id')[0];
                    $statusIdsArray = explode(',', $statusIds);
                        $query->where('status_id', '>', trim($statusIdsArray[0]))
                              ->whereNot('status_id', trim($statusIdsArray[1]));
                } else if (request()->get('kind') == 'arr') {
                    $status_ids = explode(',', request()->get('status_id')[0]);
                    $query->whereIn('status_id', $status_ids);
                }else{
                    $query->whereIn('status_id', $statusId);
                }

                $title = "All Applications";
                break;
        }

        return ['query' => $query, 'statusId' => $statusId, 'title' => $title];
    }
    public function getDataFromDistricts(Request $request)
    {
        $type = $request->get('type');
        $dataIds = $request->get('data');
        // print_r($dataIds);
        $districts = [];
        $constituencies = [];
        $tehsils = [];
        $blocks = [];
        $blockIds = [];
        $panchayatWards = [];
        if ($type == "district") {
            $constituencies = Region::getConstituency($dataIds)->select('name', 'id')->get();
            $tehsils = Region::getTehsil($dataIds)->select('name', 'id')->get();
            $blocks = Region::getBlock($dataIds)->select('name', 'id')->get();
            $blockIds = Region::getBlock($dataIds)->pluck('id')->values();
            $panchayatWards = Region::getPanchayatWard($blockIds)->select('name', 'id')->get();
        } elseif ($type == "block") {
            $panchayatWards = Region::getPanchayatWard($dataIds)->select('name', 'id')->get();
        }
        $data = [
            'constituencies' => $constituencies,
            'tehsils' => $tehsils,
            'blocks' => $blocks,
            'panchayatWards' => $panchayatWards,
            'message' => 'Data fetched successfully',
        ];

        // Return the data as JSON response
        return response()->json($data);
    }

    // Numaric reports here
    public function recievedApplication(Request $request)
    {
        $district_ids = $request->input('district_id', 'All');
        $tehsil_ids = $request->input('tehsil_id', 'All');
        $constituency_ids = $request->input('constituency_id', 'All');
        $block_ids = $request->input('block_id', 'All');
        $panchayat_ids = $request->input('panchayat_id', 'All');

        // Get Data from Filters
        $title = 'Recieved Applications';
        $districts = Region::userBasedDistricts(null)->select('name', 'id')->get();
        $districtsIds = $district_ids == 'All' ? Region::userBasedDistricts(null)->pluck('id')->values() : $district_ids;
        $constituencies = null;
        $tehsils = null;
        $blocks = null;
        $panchayatWards = null;
        $statusId = null;
        $categories = null;
        $activities = null;
        $perPage = null;
        $selectedFY = request()->get('fy'); // Get the selected fiscal year from the request
        if ($selectedFY && $selectedFY != 'All') {
            // dd($selectedFY);
            // Split the fiscal year into two years
            list($startYear, $endYear) = explode('-', $selectedFY);

            // Calculate the start and end dates of the fiscal year
            $startDate = "{$startYear}-04-01";
            $endDate = "{$endYear}-03-31";
        }
        $reportData = $this->numaricQueryRecieved($districtsIds, $selectedFY);
        $totals = null;

        foreach ($reportData as $item) {
            if (isset($item['Total'])) {
                $totals = $item['Total'];
                break;
            }
        }
        $request->session()->flash('exportData', $reportData);
        $request->session()->flash('totals', $totals);
        return view('numaric_reports.recieved', compact('districts', 'constituencies', 'tehsils', 'blocks', 'panchayatWards', 'title', 'statusId', 'reportData', 'totals', 'categories', 'activities', 'perPage'));
    }
    public function releasedApplication(Request $request)
    {
        $district_ids = $request->input('district_id', 'All');
        $tehsil_ids = $request->input('tehsil_id', 'All');
        $constituency_ids = $request->input('constituency_id', 'All');
        $block_ids = $request->input('block_id', 'All');
        $panchayat_ids = $request->input('panchayat_id', 'All');

        // Get Data from Filters
        $title = 'Recieved Applications';
        $districts = Region::userBasedDistricts(null)->select('name', 'id')->get();
        $districtsIds = $district_ids == 'All' ? Region::userBasedDistricts(null)->pluck('id')->values() : $district_ids;
        $constituencies = null;
        $tehsils = null;
        $blocks = null;
        $panchayatWards = null;
        $statusId = null;
        $categories = null;
        $activities = null;
        $perPage = null;
        $selectedFY = request()->get('fy'); // Get the selected fiscal year from the request
        if ($selectedFY && $selectedFY != 'All') {
            // dd($selectedFY);
            // Split the fiscal year into two years
            list($startYear, $endYear) = explode('-', $selectedFY);

            // Calculate the start and end dates of the fiscal year
            $startDate = "{$startYear}-04-01";
            $endDate = "{$endYear}-03-31";
        }
        $statusCodes = Enum::where('type', 'APPLICATION_STATUS')->whereNot('name', 'Unknown')->select('id', 'name')->get()->toArray();
        $reportData = $this->numaricQueryReleased($districtsIds, $selectedFY, $statusCodes);
        //    dd($reportData);
        $totals = null;

        foreach ($reportData as $item) {
            if (isset($item['Total'])) {
                $totals = $item['Total'];
                break;
            }
        }
        $request->session()->flash('exportData', $reportData);
        $request->session()->flash('totals', $totals);
        $request->session()->flash('statusCodes', $statusCodes);
        return view('numaric_reports.released', compact('districts', 'constituencies', 'tehsils', 'blocks', 'panchayatWards', 'title', 'statusId', 'reportData', 'totals', 'statusCodes', 'categories', 'activities', 'perPage'));
    }
    public function numaricQueryRecieved($districtIds, $selectedFY)
    {
        $selectedFiscalYears = $selectedFY && $selectedFY !== "All" ? [$selectedFY] : ['2020-2021', '2021-2022', '2022-2023', '2023-2024'];

        $reportData = [];

        // Initialize totals
        $totals = [
            'Received' => 0,
            'Approved' => 0,
            'RejectedByDLC' => 0,
            'RejectedByBank' => 0,
            'PendingForDLC' => 0,
            'PendingAtBank' => 0,
        ];

        // Loop through each district
        foreach ($districtIds as $districtId) {
            $districtData = [
                'District' => Region::find($districtId)->name,
                'DistrictId' => $districtId,
                'Year' => [],
            ];

            // Loop through each fiscal year
            if (!$selectedFY) {
                $startDate = request()->get('startDate') ?: '2019/04/01';
                $endDate = request()->get('endDate') ?: date('Y/m/d');
                $districtData['Year'][] = $this->iterateBetweenDates($startDate, $endDate, null, $districtId, $totals);
            } else {
                foreach ($selectedFiscalYears as $fiscalYear) {
                    list($startYear, $endYear) = explode('-', $fiscalYear);
                    $startDate = "{$startYear}-04-01";
                    $endDate = "{$endYear}-03-31";
                    $districtData['Year'][] = $this->iterateBetweenDates($startDate, $endDate, $fiscalYear, $districtId, $totals);
                }
            }
            // Add the district data to the report data
            $reportData[] = $districtData;
        }
        // dd($reportData);
        // Add the totals to the report data
        $reportData[] = ['Total' => $totals];

        return $reportData;
    }
    public function iterateBetweenDates($startDate, $endDate, $fiscalYear, $districtId, $totals)
    {

        $receivedCount = Application::where('region_id', $districtId)
            ->whereNot('status_id', 302)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        // Build the query to count approved applications
        $approvedCount = Application::where('region_id', $districtId)
            ->where('status_id', '>', 308)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Build the query to count rejected applications by DLC
        $rejectedByDlcCount = Application::where('region_id', $districtId)
            ->whereIn('status_id', [310])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Build the query to count rejected applications by bank
        $rejectedByBankCount = Application::where('region_id', $districtId)
            ->whereIn('status_id', [304])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Build the query to count pending applications for DLC
        $pendingForDlcCount = Application::where('region_id', $districtId)
            ->whereIn('status_id', [309])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Build the query to count pending applications at the bank
        $pendingAtBankCount = Application::where('region_id', $districtId)
            ->whereIn('status_id', [308])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totals['Received'] += $receivedCount;
        $totals['Approved'] += $approvedCount;
        $totals['RejectedByDLC'] += $rejectedByDlcCount;
        $totals['RejectedByBank'] += $rejectedByBankCount;
        $totals['PendingForDLC'] += $pendingForDlcCount;
        $totals['PendingAtBank'] += $pendingAtBankCount;

        // Create an array for the current fiscal year's data
        $fiscalYearData = [
            'Year' => $fiscalYear ? $fiscalYear : null,
            'Received' => $receivedCount,
            'Approved' => $approvedCount,
            'Rejected By DLC' => $rejectedByDlcCount,
            'Rejected By Bank' => $rejectedByBankCount,
            'Pending For DLC' => $pendingForDlcCount,
            'Pending At Bank' => $pendingAtBankCount,
        ];

        // Return only the fiscal year data
        return $fiscalYearData;
    }
    public function numaricQueryReleased($districtIds, $selectedFY, $statusCodes)
    {
        $selectedFiscalYears = $selectedFY && $selectedFY !== "All" ? [$selectedFY] : ['2020-2021', '2021-2022', '2022-2023', '2023-2024'];
        $reportData = [];
        $totals = [];

        foreach ($statusCodes as $status) {
            $totals[$status['name']] = 0;
        }

        foreach ($districtIds as $districtId) {
            $districtData = [
                'District' => Region::find($districtId)->name,
                'DistrictId' => $districtId,
                'Year' => [],
            ];

            $fronFun = [];
            if (!$selectedFY) {
                $startDate = request()->get('startDate') ?: '2019/04/01';
                $endDate = request()->get('endDate') ?: date('Y/m/d');
                $fronFun[] = $this->iterateBetweenDatesAllStatus($statusCodes, $startDate, $endDate, null, $districtId, $totals, $districtData);
            } else {
                foreach ($selectedFiscalYears as $fiscalYear) {
                    list($startYear, $endYear) = explode('-', $fiscalYear);
                    $startDate = "{$startYear}-04-01";
                    $endDate = "{$endYear}-03-31";
                    $fronFun[] = $this->iterateBetweenDatesAllStatus($statusCodes, $startDate, $endDate, $fiscalYear, $districtId, $totals, $districtData);
                }
            }

            $reportData = array_merge($reportData, $fronFun);
        }
        $reportData[] = ['Total' => $totals];

        return $reportData;
    }

    public function iterateBetweenDatesAllStatus($statusCodes, $startDate, $endDate, $fiscalYear, $districtId, &$totals)
    {
        $statusCounts = [];

        foreach ($statusCodes as $status) {
            $statusCount = Application::where('region_id', $districtId)
                ->where('status_id', $status['id'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $statusCounts[$status['name']] = $statusCount;
            $totals[$status['name']] += $statusCount;
        }

        $fiscalYearData = [
            'Year' => $fiscalYear,
        ];

        $fiscalYearData = array_merge($fiscalYearData, $statusCounts);

        $districtData = [
            'District' => Region::find($districtId)->name,
            'DistrictId' => $districtId,
            'Year' => [$fiscalYearData],
        ];

        return $districtData;
    }

    // Reports for UCO Bank


    public function bankReportLB(Request $request)
    {



        $district_ids = $request->input('district_id', 'All');
        $tehsil_ids = $request->input('tehsil_id', 'All');
        $constituency_ids = $request->input('constituency_id', 'All');
        $block_ids = $request->input('block_id', 'All');
        $panchayat_ids = $request->input('panchayat_id', 'All');

            // $district_ids=['3'];
        // Get Data from Filters
        $title = 'Recieved Applications';
        $districts = Region::userBasedDistricts(null)->select('name', 'id')->get();

        $districtsIds = $district_ids == 'All' ? Region::where('parent_id', 2)->pluck('id')->toArray() : $district_ids;
        $constituencies = null;
        $tehsils = null;
        $blocks = null;
        $panchayatWards = null;
        $statusId = null;
        $categories = null;
        $activities = null;
        $perPage = null;
        $selectedFY = request()->get('fy'); // Get the selected fiscal year from the request
        if ($selectedFY && $selectedFY != 'All') {
            // dd($selectedFY);
            // Split the fiscal year into two years
            list($startYear, $endYear) = explode('-', $selectedFY);

            // Calculate the start and end dates of the fiscal year
            $startDate = "{$startYear}-04-01";
            $endDate = "{$endYear}-03-31";
        }
        // dd($districtsIds);
        $reportData = $this->numaricQueryRecievedBank($districtsIds, $selectedFY);
        $totals = null;

        foreach ($reportData as $item) {
            if (isset($item['Total'])) {
                $totals = $item['Total'];
                break;
            }
        }

         echo"<pre>"; print_r($reportData); die;
        $request->session()->flash('exportData', $reportData);
        $request->session()->flash('totals', $totals);
        return view('numaric_reports.bankreport', compact('districts', 'districtsIds', 'constituencies', 'tehsils', 'blocks', 'panchayatWards', 'title', 'statusId', 'reportData', 'totals', 'categories', 'activities', 'perPage'));
    }




    public function bankReport(Request $request)
    {



        $district_ids = $request->input('district_id', 'All');
        $tehsil_ids = $request->input('tehsil_id', 'All');
        $constituency_ids = $request->input('constituency_id', 'All');
        $block_ids = $request->input('block_id', 'All');
        $panchayat_ids = $request->input('panchayat_id', 'All');

            // $district_ids=['3'];
        // Get Data from Filters
        $title = 'Recieved Applications';
        $districts = Region::userBasedDistricts(null)->select('name', 'id')->get();

        $districtsIds = $district_ids == 'All' ? Region::where('parent_id', 2)->pluck('id')->toArray() : $district_ids;
        $constituencies = null;
        $tehsils = null;
        $blocks = null;
        $panchayatWards = null;
        $statusId = null;
        $categories = null;
        $activities = null;
        $perPage = null;
        $selectedFY = request()->get('fy'); // Get the selected fiscal year from the request
        if ($selectedFY && $selectedFY != 'All') {
            // dd($selectedFY);
            // Split the fiscal year into two years
            list($startYear, $endYear) = explode('-', $selectedFY);

            // Calculate the start and end dates of the fiscal year
            $startDate = "{$startYear}-04-01";
            $endDate = "{$endYear}-03-31";
        }
        // dd($districtsIds);
        $reportData = $this->numaricQueryRecievedBank($districtsIds, $selectedFY);
        $totals = null;

        foreach ($reportData as $item) {
            if (isset($item['Total'])) {
                $totals = $item['Total'];
                break;
            }
        }

        //  echo"<pre>"; print_r($reportData); die;
        $request->session()->flash('exportData', $reportData);
        $request->session()->flash('totals', $totals);
        return view('numaric_reports.bankreport', compact('districts', 'districtsIds', 'constituencies', 'tehsils', 'blocks', 'panchayatWards', 'title', 'statusId', 'reportData', 'totals', 'categories', 'activities', 'perPage'));
    }

    public function numaricQueryRecievedBank($districtIds, $selectedFY)
    {
        $selectedFiscalYears = $selectedFY && $selectedFY !== "All" ? [$selectedFY] : ['2020-2021', '2021-2022', '2022-2023', '2023-2024'];

        $reportData = [];

        // Initialize totals
        $totals = [
            'Received' => 0,
            'Returned' => 0,
            'Forwarded To DLC' => 0,
            'Pending At Bank For Comments' => 0,
            'Approved By DLC' => 0,
            'Pending By DLC' => 0,
            'Rejected By DLC' => 0,
            'No of Applications Pending ar DLC' => 0,
            'No of Applications Forwarded to Bank' => 0,
            'No Of Cases' => 0,
            'Total Amount of Loan Involved' => 0,
            'Total Amount of Subsidy Involved' => 0,
            'No Of Application Rejected By The Bank' => 0,
            'No Of Cases Pending at Bank Level' => 0,
            'Application Reverted Back By GM' => 0,
        ];

        // Loop through each district
        foreach ($districtIds as $districtId) {
            $districtData = [
                'District' => Region::find($districtId)->name,
                'DistrictId' => $districtId,
                'Year' => [],
            ];
            // Loop through each fiscal year
            if (!$selectedFY) {
                $startDateString = request()->get('startDate');
                $startDate = date_create_from_format('d/m/Y', $startDateString);

                $formattedStartDate = $startDate ? $startDate->format('Y-m-d') : '2019-04-01';

                // $startDate = date("Y-m-d", strtotime(request()->get('startDate'))) ?: '2019-04-01';

                $endDateString = request()->get('endDate');
                $endDate = date_create_from_format('d/m/Y', $endDateString);

                $formattedEndDate = $endDate ? $endDate->format('Y-m-d') : date('Y-m-d');

                $districtData['Year'][] = $this->iterateBetweenDatesForBank($formattedStartDate, $formattedEndDate, null, $districtId, $totals);

            } else {
                foreach ($selectedFiscalYears as $fiscalYear) {
                    list($startYear, $endYear) = explode('-', $fiscalYear);
                    $startDate = "{$startYear}-04-01";
                    $endDate = "{$endYear}-03-31";
                    $districtData['Year'][] = $this->iterateBetweenDatesForBank($startDate, $endDate, $fiscalYear, $districtId, $totals);
                }
            }
            // Add the district data to the report data
            $reportData[] = $districtData;
        }
        // dd($reportData);
        // Add the totals to the report data
        $reportData[] = ['Total' => $totals];
        // dd($totals);
        return $reportData;
    }

    public function iterateBetweenDatesForBank($startDate, $endDate, $fiscalYear, $districtId, $totals)
    {

        // At DIC
        $receivedCountDic = Application::where('region_id', $districtId)
            ->where('status_id', '>', 305)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $approvedCountDic = Application::where('region_id', $districtId)
            ->where('status_id', '>', 307)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $returnedCountDic = Application::where('region_id', $districtId)
            ->whereIn('status_id', [305])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $rejectedCountDic = Application::where('region_id', $districtId)
            ->whereIn('status_id', [307])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $pendingCountDic = Application::where('region_id', $districtId)
            ->whereIn('status_id', [306])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // At DIC

        // At Bank For Comments

        $pendingForBankCommentsCount = Application::where('region_id', $districtId)
            ->whereIn('status_id', [308])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // At Bank For Comments

        // At DLC
        $recievedToDlcCount = Application::where('region_id', $districtId)
            ->where('status_id', '>', 308)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $approvedByDlcCount = Application::where('region_id', $districtId)
            ->where('status_id', '>', 310)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $rejectedByDlcCount = Application::where('region_id', $districtId)
            ->whereIn('status_id', [310])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $pendingCountDlc = Application::where('region_id', $districtId)
            ->whereIn('status_id', [309])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // At DLC

        // At Bank For Loan Disbursment

        $pendingAtBankDisbursmentCount = Application::where('region_id', $districtId)
            ->whereIn('status_id', [311])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        // At Bank For Loan Disbursment
        // At Nodal DIC
        $pendingAtNodalDICCount = Application::where('region_id', $districtId)
            ->whereIn('status_id', [313,322])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        // At Nodal DIC
        // At Nodal Bank

        $recievedToNodalCount = Application::where('region_id', $districtId)
            ->where('status_id', '>', 313)
            ->whereNot('status_id', 322)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $sanctionedByNodalCount = Application::where('region_id', $districtId)
            ->whereIn('status_id', [315,317])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $pendingAtNodalCount = Application::where('region_id', $districtId)
            ->whereIn('status_id', [314,316])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        // At Nodal Bank
// dd('sdsd');
        $totalAmountOfLoanInvolved = Application::where('region_id', $districtId)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->get()
        ->sum(function ($application) {
            return isset($application->data->loan->term_loan) ? $application->data->loan->term_loan : 0;
        });

        $totalAmountOfSubsidyInvolved = Application::where('region_id', $districtId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->sum(function ($application) {
                if ($application->id <= 25000) {
                    return (isset($application->data->old_40_subsidy->subsidy_25) ? floatval($application->data->old_40_subsidy->subsidy_25) : 0)
                        + (isset($application->data->old_40_subsidy->subsidy_40) ? floatval($application->data->old_40_subsidy->subsidy_40) : 0)
                        + (isset($application->data->old_40_subsidy->subsidy_60) ? floatval($application->data->old_40_subsidy->subsidy_60) : 0);
                } else {
                    return isset($application->data->subsidy->amount) ? floatval($application->data->subsidy->amount) : 0;
                }
            });


        $totalAmountOfSubsidyPending40 = Application::where('region_id', $districtId)
       ->whereIn('status_id', [314])
        ->whereBetween('created_at', [$startDate, $endDate])
        ->get()
        ->sum(function ($application) {
            if ($application->id <= 25000) {
                return (isset($application->data->old_40_subsidy->subsidy_25) ? floatval($application->data->old_40_subsidy->subsidy_25) : 0)
                    + (isset($application->data->old_40_subsidy->subsidy_40) ? floatval($application->data->old_40_subsidy->subsidy_40) : 0);
                //    + (isset($application->data->old_40_subsidy->subsidy_60) ? floatval($application->data->old_40_subsidy->subsidy_60) : 0);
            } else {
                return isset($application->data->subsidy->amount) ? floatval($application->data->subsidy->amount) : 0;
            }
        });


        $totalAmountOfSubsidyPending60 = Application::where('region_id', $districtId)
        ->whereIn('status_id', [316])
        ->whereBetween('created_at', [$startDate, $endDate])
        ->get()
        ->sum(function ($application) {
            if ($application->id <= 25000) {
                return (isset($application->data->old_40_subsidy->subsidy_25) ? floatval($application->data->old_40_subsidy->subsidy_25) : 0)
               //     + (isset($application->data->old_40_subsidy->subsidy_40) ? floatval($application->data->old_40_subsidy->subsidy_40) : 0)
                    + (isset($application->data->old_40_subsidy->subsidy_60) ? floatval($application->data->old_40_subsidy->subsidy_60) : 0);
            } else {
                return isset($application->data->subsidy->amount) ? floatval($application->data->subsidy->amount) : 0;
            }
        });


        $totalAmountOfSubsidyREL = Application::where('region_id', $districtId)
        ->whereIn('status_id', [315,317])
         ->whereBetween('created_at', [$startDate, $endDate])
         ->get()
         ->sum(function ($application) {
             if ($application->id <= 25000) {
                 return
                  (isset($application->data->old_40_subsidy->subsidy_25) ? floatval($application->data->old_40_subsidy->subsidy_25) : 0)
                      +
                      (isset($application->data->old_40_subsidy->subsidy_40) ? floatval($application->data->old_40_subsidy->subsidy_40) : 0)
                     + (isset($application->data->old_40_subsidy->subsidy_60) ? floatval($application->data->old_40_subsidy->subsidy_60) : 0);
             } else {
                 return isset($application->data->subsidy->amount) ? floatval($application->data->subsidy->amount) : 0;
             }
         });


        $applicationRevertedBackByGMCount = Application::where('region_id', $districtId)
            ->whereIn('status_id', [321])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totals['receivedCountDic'] = $receivedCountDic;
        $totals['approvedCountDic'] = $approvedCountDic;
        $totals['returnedCountDic'] = $returnedCountDic;
        $totals['rejectedCountDic'] = $rejectedCountDic;
        $totals['pendingCountDic'] = $pendingCountDic;

        $totals['pendingForBankCommentsCount'] = $pendingForBankCommentsCount;

        $totals['recievedToDlcCount'] = $recievedToDlcCount;
        $totals['approvedByDlcCount'] = $approvedByDlcCount;
        $totals['rejectedByDlcCount'] = $rejectedByDlcCount;
        $totals['pendingCountDlc'] = $pendingCountDlc;

        $totals['pendingAtBankDisbursmentCount'] = $pendingAtBankDisbursmentCount;
        $totals['pendingAtNodalDICCount'] = $pendingAtNodalDICCount;

        $totals['recievedToNodalCount'] = $recievedToNodalCount;
        $totals['sanctionedByNodalCount'] = $sanctionedByNodalCount;
        $totals['pendingAtNodalCount'] = $pendingAtNodalCount;

        $totals['totalAmountOfLoanInvolved'] = $totalAmountOfLoanInvolved;
        $totals['totalAmountOfSubsidyInvolved'] = $totalAmountOfSubsidyInvolved;

        $totals['applicationRevertedBackByGMCount'] = $applicationRevertedBackByGMCount;

        $totals['totalAmountOfSubsidyPending60'] = $totalAmountOfSubsidyPending60;
        $totals['totalAmountOfSubsidyPending40'] = $totalAmountOfSubsidyPending40;
        $totals['totalAmountOfSubsidyREL'] = $totalAmountOfSubsidyREL;


        // Create an array for the current fiscal year's data
        $fiscalYearData = [
            'Year' => $fiscalYear ? $fiscalYear : null,
            'Received By DIC' => $receivedCountDic,
            'Approved By DIC' => $approvedCountDic,
            'Returned By DIC' => $returnedCountDic,
            'Rejected By DIC' => $rejectedCountDic,
            'Pending By DIC' => $pendingCountDic,
            'Pending At Bank For Comments' => $pendingForBankCommentsCount,
            'Forwarded To DLC' => $recievedToDlcCount,
            'Approved By DLC' => $approvedByDlcCount,
            'Rejected By DLC' => $rejectedByDlcCount,
            'Pending By DLC' => $pendingCountDlc,
            'Pending At Bank Disbursment Count' => $pendingAtBankDisbursmentCount,
            'Pending At Nodal DIC Count' => $pendingAtNodalDICCount,
            'Received To Nodal Count' => $recievedToNodalCount,
            'Sanctioned By Nodal Count' => $sanctionedByNodalCount,
            'Pending At Nodal Count' => $pendingAtNodalCount,
            'Total Amount Of Loan Involved' => $totalAmountOfLoanInvolved,
            'Total Amount Of Subsidy Involved' => $totalAmountOfSubsidyInvolved,
            'Application Reverted Back By GM Count' => $applicationRevertedBackByGMCount,
            'Pending40' => $totalAmountOfSubsidyPending40,
            'Pending60' => $totalAmountOfSubsidyPending60,
            'totalAmountOfSubsidyREL' => $totalAmountOfSubsidyREL,

        ];



        // Return only the fiscal year data
        return $fiscalYearData;
    }
    public function exportReports(Request $request)
    {
        // Retrieve the flashed data from the session
        $reportData = $request->session()->get('exportData');
        $totals = $request->session()->get('totals');
        if (!$reportData) {
            abort(404);
        }
        if ($request->type == "allStatus") {
            $statusCodes = $request->session()->get('statusCodes');
            $title = 'Recieved Applications';
            return Excel::download(new NumaricAllStatusExport($reportData, $title, $totals, $statusCodes), 'all_status_numeric_report.xlsx');
        } else {
            $title = 'Recieved Applications';
            return Excel::download(new NumericReportExport($reportData, $title, $totals), 'recieved_applications_report.xlsx');
        }
    }
}
