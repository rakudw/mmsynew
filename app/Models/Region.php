<?php

namespace App\Models;

use App\Enums\CacheKeyEnum;
use App\Enums\RegionTypeEnum;
use App\Helpers\CacheHelper;
use App\Interfaces\CrudInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @property string $name
 * @property int $type_id
 * @property int $parent_id
 * $property Enum
 * @property Region $parent
 * @property Enum $type
 */
class Region extends Base implements CrudInterface
{
 public $preventsLazyLoading = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type_id',
        'parent_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Region::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Enum::class, 'type_id');
    }

    public static function throughCache($id):?Region
    {
        $region = collect(CacheHelper::cached(CacheKeyEnum::ALL_REGIONS))->where('id', $id)->first();
        return $region ? new Region([
            'name' => $region['name'],
            'type_id' => $region['type_id'],
            'parent_id' => $region['parent_id'],
        ]) : Region::find($id);
    }

    /**
     * Scope a query to only include Authenticated users' region_ids on metadata Column of table user_roles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserBasedDistricts($query){
        $regions = $this->userDistricts();
        return $query->whereIn('id', $regions);
    }

    /**
     * Scope a query to only include Authenticated users' region_ids on metadata Column of table user_roles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUserBasedChildOfDistrict($query){
        $regions = $this->userDistricts();
        return $query->whereIn('parent_id', $regions);
    }

    public function scopeGetConstituency($query,$data){
        $regions = $this->userDistricts();
        return $query->whereIn('parent_id', $data ? $data :  $regions)->where('type_id',405);
    }

    public function scopeGetTehsil($query,$data){
        $regions = $this->userDistricts();
        return $query->whereIn('parent_id', $data ? $data :  $regions)->where('type_id',406);
    }

    public function scopeGetBlock($query,$data){
        $regions = $this->userDistricts();
        return $query->whereIn('parent_id', $data ? $data : $regions)->where('type_id',407);
    }
    public function scopeGetPanchayatWard($query,$data){
        $regions = $this->userDistricts();
        return $query->whereIn('parent_id', $data ? $data : $regions)->where('type_id',408);
    }
    
    /**
     * Scope a query to only include regions of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type_id', $type);
    }

    private function userDistricts() {
        $regions = array();
        if($this->user()->isSuperAdmin() || $this->user()->isNodalBank()) {
            $regions = Region::ofType(RegionTypeEnum::DISTRICT->id())->select('id')->get()->map(fn($d) => $d->id)->toArray();
        } else {
            $records = DB::table('user_roles')->where('user_id', Auth::id())->get();
            foreach($records as $record) {
                if($record->metadata) {
                    $metadata = json_decode($record->metadata);
                    $regions += $metadata->district_ids ?? [];
                }
            }
        }
        return array_unique($regions);
    }

    public function getFormDesign():object {
        return (object)[(object)[
            'type' => 'input',
            'label' => 'Name',
            'width' => '12',
            'helpText' => 'The name of the region.',
            'attributes' => (object)[
                'name' => 'name',
                'required' => 'required',
                'autofocus' => 'autofocus',
            ],
        ], (object)[
            'type' => 'select',
            'label' => 'Type of Region',
            'width' => '12',
            'helpText' => 'Type of the region.',
            'attributes' => (object)[
                'data-options' => 'dbase:enum(id,name)[type:REGION_TYPE]',
                'name' => 'type_id',
                'required' => 'required',
            ],
        ], (object)[
            'type' => 'select',
            'label' => 'Parent Region',
            'width' => '12',
            'helpText' => 'Parent of the region.',
            'attributes' => (object)[
                'data-options' => 'dbase:region(id,name)[type_id:.App\\Models\\Region::parentType($model->type)]',
                'name' => 'parent_id',
            ],
        ]];
    }
  
    public function getRequestValidator():array {
        return [
            'name' => 'required|max:255',
            'type_id' => "required|numeric|exists:App\\Models\\Enum,id",
            'parent_id' => "nullable|numeric|exists:App\\Models\\Region,id",
        ];
    }

    public static function parentType(?RegionTypeEnum $regionType) {
        if(is_null($regionType)) {
            return null;
        }
        dd($regionType);
    }
}
