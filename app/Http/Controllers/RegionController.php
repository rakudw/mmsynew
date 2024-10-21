<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatusEnum;
use App\Enums\MeetingApplicationStatusEnum;
use App\Enums\RegionTypeEnum;
use App\Enums\RoleEnum;
use App\Events\ApplicationStatusEvent;
use App\Helpers\ExportHelper;
use App\Http\Requests\RegionCreateRequest;
use App\Models\Application;
use App\Models\ApplicationTimeline;
use App\Models\Meeting;
use App\Models\Region;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    private RegionTypeEnum $type = RegionTypeEnum::PANCHAYAT_WARD;

    public function index(string $type)
    {

        $districtIds = $this->init($type);
        if(empty($districtIds)) {
            return redirect()->route('dashboard')->with('error', 'You cannot manage regions!');
        }

        $this->setTitle($this->type->value . ' Regions');

        $regionQuery = Region::orderBy('name')->where('type_id', $this->type->id());
        if($this->type == RegionTypeEnum::PANCHAYAT_WARD) {
            $blockIds = Region::where('type_id', RegionTypeEnum::BLOCK_TOWN->id())
                            ->whereIn('parent_id', $districtIds)
                            ->select('id')->get()
                            ->pluck('id')->toArray();
            $regionQuery->whereIn('parent_id', $blockIds);
        } else {
            $regionQuery->whereIn('parent_id', $districtIds);
        }

        return view('region.list', ['regions' => $regionQuery->paginate(), 'type' => $this->type]);
    }

    public function create(string $type)
    {

        $districtIds = $this->init($type);
        if(empty($districtIds)) {
            return redirect()->route('dashboard')->with('error', 'You cannot manage regions!');
        }

        $this->setTitle('Create New ' . $this->type->value);

        return view('region.create', ['type' => $this->type, 'parents' => ($this->type == RegionTypeEnum::PANCHAYAT_WARD ? Region::where('type_id', RegionTypeEnum::BLOCK_TOWN->id())->whereIn('parent_id', $districtIds) : Region::whereIn('id', $districtIds))->select(['id', 'name'])->orderBy('name')->get() ]);
    }

    public function store(string $type, RegionCreateRequest $request)
    {
        $this->init($type);
        $data = $request->validated();
        $data['type_id'] = $this->type->id();

        try {
            Region::create($data);
            return redirect()->route('regions.list', ['type' => $type])->with('success', 'Record added successfuly.');
        } catch(Exception $ex) {
            return redirect()->route('regions.create', ['type' => $type])->withInput()->withErrors(['Unable to add record. [ERROR] : ' . $ex->getMessage()]);
        }
    }

    private function init(string $type)
    {

        if($type == 'tehsil') {
            $this->type = RegionTypeEnum::TEHSIL;
        } else if($type == 'block-town') {
            $this->type = RegionTypeEnum::BLOCK_TOWN;
        } else if($type == 'constituency') {
            $this->type = RegionTypeEnum::CONSTITUENCY;
        }

        return $this->user()->getDistricts();
    }
}
