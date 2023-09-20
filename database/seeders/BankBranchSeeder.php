<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\BankBranch;
use App\Models\Enum;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankBranchSeeder extends BaseSeeder
{

    private $banks = [];
    private $districts = [];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->walk($this->getFromJson(), [BankBranch::class, 'create']);
    }

    private function getFromJson()
    {
        $this->banks = Bank::select('id', DB::raw('UPPER(`name`) as `name`'))
            ->get()
            ->keyBy('name')
            ->toArray();
        $this->districts = Region::select('id', DB::raw('UPPER(`name`) as `name`'))
            ->where('type_id', Enum::where('type', 'REGION_TYPE')
                    ->where('name', 'District')
                    ->value('id'))
            ->get()
            ->keyBy('name')
            ->toArray();
        return array_map(function ($b) {
            $b->DISTRICT = strtoupper($b->DISTRICT);
            $b->BANK = strtoupper($b->BANK);
            return [
                'name' => $b->BRANCH,
                'address' => $b->ADDRESS,
                'district_id' => isset($this->districts[$b->DISTRICT]) ? $this->districts[$b->DISTRICT]['id'] : $this->findDistrictId($b),
                'bank_id' => isset($this->banks[$b->BANK]) ? $this->banks[$b->BANK]['id'] : $this->findBankId($b->BANK),
                'ifsc' => $b->IFSC,
            ];
        }, json_decode(self::removeBomUtf8(file_get_contents(__DIR__ . '/../json/branches.json')), false, 512, JSON_THROW_ON_ERROR));
    }

    private function findDistrictId($branch)
    {
        $branch = implode(' ', (array)$branch);
        foreach($this->districts as $name => $district) {
            if(count(explode($name, $branch)) > 1) {
                return $district['id'];
            }
        }
        $mappings = [
            'CHAMBA' => ['BHARMOUR'],
            'HAMIRPUR' => ['CHABUTRA', 'DERA PAROL', 'SUJANPUR TIRA'],
            'MANDI' => ['SUNDER NAGAR'],
            'KULLU' => ['MANALI', 'PATLI KUHI', 'JIBHI', '175123'],
            'KANGRA' => ['NAGROTA BAGWAN', 'CHHATTROLI', 'DHARAMSALA', 'DHARAMSHALA', 'KANGARA', 'PALAMPUR', '176215'],
            'SHIMLA' => ['YLIVIBSNTU171108H', '171207', '172031', 'DAYORI', '171203', '171210', 'PUJARLI'],
            'SIRMAUR' => ['PAONTA SAHIB', '173029', '173001', 'BOGHDHAR', '173024', 'BHAGANI', 'KALA AMB', '173027', 'PANOG', 'NAHAN'],
            'KINNAUR' => ['172104', '172106'],
            'UNA' => ['MEHATPUR'],
            'LAHAUL AND SPITI' => ['KEYLONG', 'LAHAULSAPITI'],
            'SOLAN' => ['PIPLUGHAT', '173209', '174103', 'PARWANOO', 'NALAGARH', 'BADDI'],
        ];
        foreach($mappings as $distt => $strs) {
            foreach($strs as $str) {
                if(strpos($branch, $str) !== false) {
                    return $this->districts[$distt]['id'];
                }
            }
        }
        dd('Finding district ...', $branch);
    }

    private function findBankId($bank)
    {
        foreach($this->banks as $name => $bankData) {
            if(count(explode($bank, $name)) > 1 || count(explode(str_replace(' AND ', ' & ', $bank), $name))> 1) {
                return $bankData['id'];
            }
        }
        if($bank == 'CATHOLIC SYRIAN BANK') {
            return $this->banks['CSB BANK']['id'];
        }
        dd($this->banks, array_keys($this->banks), 'Finding bank ...', $bank);
    }

    public static function removeBomUtf8($s)
    {
        if (substr($s, 0, 3) == chr(hexdec('EF')) . chr(hexdec('BB')) . chr(hexdec('BF'))) {
            return substr($s, 3);
        } else {
            return $s;
        }
    }
}
