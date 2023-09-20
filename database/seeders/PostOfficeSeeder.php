<?php

namespace Database\Seeders;

use App\Models\Enum;
use App\Models\PostOffice;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostOfficeSeeder extends BaseSeeder
{

    private $blocks = [];
    private $districts = [];
    private $tehsils = [];

    public function run()
    {
        $this->walk($this->getFromJson(), [PostOffice::class, 'create']);
    }

    private function findTehsilOrBlock($pincode)
    {
        $isTehsil = substr($pincode->Block, -3) == '(T)';
        $tehsil = substr($pincode->Block, 0, -3);
        if ($isTehsil && isset($this->tehsils[$tehsil])) {
            return [
                'region' => $this->tehsils[$tehsil],
                'type' => 'tehsil'
            ];
        } elseif (isset($this->blocks[$pincode->Block])) {
            return [
                'region' => $this->blocks[$pincode->Block],
                'type' => 'block'
            ];
        } else {
            return [
                'region' => null,
                'type' => $isTehsil ? 'tehsil' : 'block'
            ];
        }
    }

    private function getFromJson()
    {
        $this->districts = Region::select('id', DB::raw('UPPER(`name`) as `name`'))
            ->where('type_id', Enum::where('type', 'REGION_TYPE')
                ->where('name', 'District')
                ->value('id'))
            ->get()
            ->keyBy('name')
            ->toArray();
        $this->blocks = Region::select('id', DB::raw('UPPER(`name`) as `name`'), 'parent_id')
            ->where('type_id', Enum::where('type', 'REGION_TYPE')
                ->where('name', 'Block')
                ->value('id'))
            ->get()
            ->keyBy('name')
            ->toArray();
        $this->tehsils = Region::select('id', DB::raw('UPPER(`name`) as `name`'), 'parent_id')
            ->where('type_id', Enum::where('type', 'REGION_TYPE')
                ->where('name', 'Tehsil')
                ->value('id'))
            ->get()
            ->keyBy('name')
            ->toArray();
        return array_map(function ($pincode) {
            $pincode->District = strtoupper(trim($pincode->District));
            $pincode->Block = strtoupper(trim($pincode->Block));
            $districtId = null;
            $blockId = null;
            $tehsilId = null;
            if (!isset($this->districts[$pincode->District])) {
                $region = $this->findTehsilOrBlock($pincode);
                if (is_null($region['region'])) {
                    $districtId = $this->findDistrictId($pincode);
                    if ($region['type'] == 'tehsil') {
                        $tehsilId = $this->findTehsilId($pincode, collect($this->tehsils)
                            ->where('parent_id', $districtId)
                            ->toArray());
                    } else {
                        $blockId = $this->findBlockId($pincode, collect($this->blocks)
                            ->where('parent_id', $districtId)
                            ->toArray());
                    }
                } else {
                    if ($region['type'] == 'tehsil') {
                        $tehsilId = $region['region']['id'];
                        $districtId = $region['region']['parent_id'];
                    } else {
                        $blockId = $region['region']['id'];
                        $districtId = $region['region']['parent_id'];
                    }
                }
            } else {
                $districtId = $this->districts[$pincode->District]['id'];
                $region = $this->findTehsilOrBlock($pincode);
                if (is_null($region['region'])) {
                    if ($region['type'] == 'tehsil') {
                        $tehsilId = $this->findTehsilId($pincode, collect($this->tehsils)
                            ->where('parent_id', $districtId)
                            ->toArray());
                    } else {
                        $blockId = $this->findBlockId($pincode, collect($this->blocks)
                            ->where('parent_id', $districtId)
                            ->toArray());
                    }
                } else {
                    if ($region['type'] == 'tehsil') {
                        $tehsilId = $region['region']['id'];
                    } else {
                        $blockId = $region['region']['id'];
                    }
                }
            }

            return [
                'name' => trim($pincode->Name),
                'pincode' => trim($pincode->Pincode),
                'district_id' => $districtId,
                'tehsil_id' => $tehsilId,
                'block_id' => $blockId,
            ];
        }, json_decode(BankBranchSeeder::removeBomUtf8(file_get_contents(__DIR__ . '/../json/pincodes.json')), false, 512, JSON_THROW_ON_ERROR));
    }

    private function findDistrictId($pincode)
    {
        foreach ($this->districts as $name => $district) {
            if (count(explode($name, $pincode->District)) > 1) {
                return $district['id'];
            }
        }
        dd('Finding district', $pincode);
    }

    private function findBlockId($pincode, $blocks = [])
    {
        return null;
        /* $mappings = [
            'KASUMPATI' => ['Bhont'],
            'SHIMLA-IV' => ['SHIMLA'],
            'ARKI' => ['Sewra Chandi'],

        ];
        $p = implode(' ', (array) $pincode);
        foreach ($mappings as $key => $strs) {
            foreach ($strs as $str) {
                if (strpos($p, $str) !== false) {
                    return $blocks[$key]['id'];
                }
            }
        }
        dd(implode(', ', array_keys($blocks)), 'Finding block', $pincode); */
    }

    private function findTehsilId($pincode, $tehsils = [])
    {
        return null;
        // dd(implode(', ', array_keys($tehsils)), 'Finding tehsil', $pincode);
    }
}
