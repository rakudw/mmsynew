<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Region;
use App\Enums\ApplicationStatusEnum;
use App\Models\Views\ApplicationView;
use Exception;

class MasterReportController extends Controller
{
    public function index(Request $request)
    {
        // dd(request()->get('tehsil_id'),request()->get('constituency_id'));
        // Get Data from Filters
            $district_ids = request()->get('district_id') ? request()->get('district_id') : 'All';
            $tehsil_ids = request()->get('tehsil_id') ? request()->get('tehsil_id') : 'All';
            $constituency_ids = request()->get('constituency_id') ? request()->get('constituency_id') : 'All';
            $block_ids = request()->get('block_id') ? request()->get('block_id') : 'All';
            $panchayat_ids = request()->get('panchayat_id') ? request()->get('panchayat_id') : 'All';
        // Get Data from Filters
        $result = $this->query(Application::forCurrentUser());
        $statusId = $result['statusId'];
        $title = $result['title'];
        $districts = Region::userBasedDistricts(null)->select('name','id')->get();
        $districtsIds = $district_ids == 'All' ? Region::userBasedDistricts(null)->pluck('id')->values() : $district_ids;
        $query = $result['query']->whereIn('region_id',$districtsIds );
        $constituencies = Region::getConstituency(null)->select('name','id')->get();
        $constituenciesIds = $constituency_ids == 'All' ? Region::getConstituency(null)->pluck('id')->values() : $constituency_ids;
        $tehsils = Region::getTehsil(null)->select('name','id')->get();
        $tehsilsIds = $tehsil_ids == 'All' ? Region::getTehsil(null)->pluck('id')->values() : $tehsil_ids;
        $blocks = Region::getBlock(null)->select('name','id')->get();
        $blockIds = $block_ids == 'All' ? Region::getBlock(null)->pluck('id')->values() : $block_ids;
        $panchayatWards = Region::getPanchayatWard($blockIds)->select('name','id')->get();
        $panchayatWardsIds =  $panchayat_ids == 'All' ? Region::getPanchayatWard($blockIds)->pluck('id')->values() : $panchayat_ids;
      
        // tehsilsIds
        if($tehsil_ids != 'All'){
            $query->where(function ($query) use ($tehsilsIds) {
                $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.tehsil_id'))) LIKE ?", ['%' . strtolower('null') . '%']);
                foreach ($tehsilsIds as $tehsilId) {
                    $tehsilIdAsString = strval($tehsilId); 
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.tehsil_id'))) LIKE ?", ['%' . strtolower($tehsilIdAsString) . '%']);
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.tehsil_id'))) LIKE ?", ['%' . strtolower($tehsilIdAsString) . '%']);
                }
            })->get();
        }
        // dd($tehsilsIds);
        // constituenciesIds
        if($constituency_ids != 'All'){
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
        if($block_ids != 'All'){
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
        if($panchayat_ids != 'All'){
            $query->where(function ($query) use ($panchayatWardsIds) {
                foreach ($panchayatWardsIds as $panchayatWardsId) {
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.panchayat_id'))) LIKE ?", ['%' . strtolower('null') . '%']);
                    $panchayatWardsIdAsString = strval($panchayatWardsId); 
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.panchayat_id'))) LIKE ?", ['%' . strtolower($panchayatWardsIdAsString) . '%']);
                    $query->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.panchayat_id'))) LIKE ?", ['%' . strtolower($panchayatWardsIdAsString) . '%']);
                }
            })->get();
        }

        $applications = $query->paginate(50);
        // dd($applications->count());
        return view('master_report.index', compact('applications', 'statusId','districts','constituencies','tehsils','blocks','panchayatWards','title'));
    }
    
    public function query($query)
    {
        $statusId = null;
        $title = '';
        $selectedFY = request()->get('fy'); // Get the selected fiscal year from the request
        if($selectedFY && $selectedFY != 'All'){
            // dd($selectedFY);
            // Split the fiscal year into two years
            list($startYear, $endYear) = explode('-', $selectedFY);
    
            // Calculate the start and end dates of the fiscal year
            $startDate = "{$startYear}-04-01";
            $endDate = "{$endYear}-03-31";
    
            // Add a condition to filter by fiscal year
            $query->whereBetween('created_at', [$startDate, $endDate]);
            
        }
        switch (request()->route()->parameter('type')) {
            case 'pending':
                // dd(request()->get('status_id'));
                $statusId =  [
                    ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER->id(),
                    ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS->id(),
                    ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id()
                ];
                $query->whereIn('status_id', request()->get('status_id') ? [request()->get('status_id')] : $statusId)->orderBy('updated_at', 'DESC');
                $title = "Pending Applications at DIC or Before";
                break;
            case 'sponsored':
                $statusId = [
                    ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id(),
                    ApplicationStatusEnum::LOAN_DISBURSED->id()
                ];
                $query->whereIn('status_id', $statusId)->orderBy('updated_at', 'DESC');
                $title = "Sponsored Applications to Bank";
                break;
            case 'sanctioned':
                if (request()->route()->parameter('step') == '60') {
                    $statusId = [
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
                $query->whereIn('status_id', $statusId)->orderBy('updated_at', 'DESC');
                break;
            case 'rejected':
                // dd(intval(request()->get('status_id')));
                $statusId = intval(request()->get('status_id')) ? [intval(request()->get('status_id'))] :  [
                    ApplicationStatusEnum::LOAN_REJECTED->id(),
                    ApplicationStatusEnum::REJECTED_AT_DISTRICT_INDUSTRIES_CENTER->id(),
                    ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id()
                ];
                $query->whereIn('status_id', $statusId)->orderBy('updated_at', 'DESC');
                $title = "Rejeted Application at all level";
                break;
            default:
                $query->where('status_id', ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id());
                break;
        }
    
        return ['query' => $query, 'statusId' => $statusId, 'title' => $title];
    }
    public function getDataFromDistricts(Request $request){
        $type = $request->get('type');
        $dataIds = $request->get('data');
        // print_r($dataIds);
        $districts = [];
        $constituencies = [];
        $tehsils = [];
        $blocks = [];
        $blockIds = [];
        $panchayatWards = [];
        if($type == "district"){
            $constituencies = Region::getConstituency($dataIds)->select('name','id')->get();
            $tehsils = Region::getTehsil($dataIds)->select('name','id')->get();
            $blocks = Region::getBlock($dataIds)->select('name','id')->get();
            $blockIds = Region::getBlock($dataIds)->pluck('id')->values();
            $panchayatWards = Region::getPanchayatWard($blockIds)->select('name','id')->get();
        }elseif($type == "block"){
            $panchayatWards = Region::getPanchayatWard($dataIds)->select('name','id')->get();
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
    public function recievedApplication(Request $request){
        dd('asd');
    }
}