<?php

namespace Database\Seeders;

use App\Enums\RegionTypeEnum;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends BaseSeeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        try {
            $this->walk(array_merge($this->getCountries(), $this->getStates(), $this->getDistricts()), [Region::class, 'create']);
            $this->walk(array_merge($this->getConstituencies(), $this->getTehsils(), $this->getBlocks()), [Region::class, 'create']);
            $this->walk(array_merge($this->getPanchayats()), [Region::class, 'create']);
        } catch (\Exception $ex) {
            dd($ex->getMessage(), $ex->getTraceAsString());
        }
    }

    private function getCountries(): array
    {
        return $this->buildRegion(['India'], RegionTypeEnum::COUNTRY);
    }

    private function getStates(): array
    {
        return $this->buildRegion(['Himachal Pradesh'], RegionTypeEnum::STATE, 1);
    }

    private function getDistricts(): array
    {
        return $this->buildRegion(['Bilaspur', 'Chamba', 'Hamirpur', 'Kangra', 'Kinnaur', 'Kullu', 'Lahaul and Spiti', 'Mandi', 'Shimla', 'Sirmaur', 'Solan', 'Una'], RegionTypeEnum::DISTRICT, 2);
    }

    private function getConstituencies(): array
    {
        $constituencyList = [
            'Chamba' => ['Churah', 'Bharmour', 'Chamba', 'Dalhousie', 'Bhattiyat'],
            'Kangra' => ['Nurpur', 'Indora', 'Fatehpur', 'Jawali', 'Dehra', 'Jaswan-Pragpur', 'Jawalamukhi', 'Jaisinghpur', 'Sullah', 'Nagrota', 'Kangra', 'Shahpur', 'Dharamshala', 'Palampur', 'Baijnath'],
            'Lahaul and Spiti' => ['Lahaul and Spiti'],
            'Kullu' => ['Manali', 'Kullu', 'Banjar', 'Anni'],
            'Mandi' => ['Karsog', 'Sundernagar', 'Nachan', 'Seraj', 'Darang', 'Jogindernagar', 'Dharampur', 'Mandi', 'Balh', 'Sarkaghat'],
            'Hamirpur' => ['Bhoranj', 'Sujanpur', 'Hamirpur', 'Barsar', 'Nadaun'],
            'Una' => ['Chintpurni', 'Gagret', 'Haroli', 'Una', 'Kutlehar'],
            'Bilaspur' => ['Jhanduta', 'Ghumarwin', 'Bilaspur', 'Sri Naina Deviji'],
            'Solan' => ['Arki', 'Nalagarh', 'Doon', 'Solan', 'Kasauli'],
            'Sirmaur' => ['Pachhad', 'Nahan', 'Sri Renukaji', 'Paonta Sahib', 'Shillai'],
            'Shimla' => ['Chaupal', 'Theog', 'Kasumpti', 'Shimla', 'Shimla Rural', 'Jubbal-Kotkhai', 'Rampur', 'Rohru'],
            'Kinnaur' => ['Kinnaur'],
        ];
        $result = [];
        foreach ($constituencyList as $district => $constituencies) {
            $districtId = Region::where('name', $district)
                ->where('type_id', RegionTypeEnum::DISTRICT->id())
                ->value('id');
            $result = array_merge($result, $this->buildRegion($constituencies, RegionTypeEnum::CONSTITUENCY, $districtId));
        }

        return $result;
    }

    private function getTehsils(): array
    {
        $tehsilList = [
            'Bilaspur' => ['Bharari', 'Bilaspur Sadar', 'Ghumarwin', 'Jhanduta', 'Naina Devi', 'Namhol'],
            'Chamba' => ['Bhalai', 'Bhattiyat', 'Brahmaur', 'Chamba', 'Chaurah', 'Dalhousie', 'Holi', 'Pangi', 'Saluni', 'Sihunta'],
            'Hamirpur' => ['Barsar', 'Bhoranj', 'Dhatwal', 'Galore', 'Hamirpur', 'Nadaun', 'Tira Sujanpur'],
            'Kangra' => ['Baijnath', 'Baroh', 'Dera Gopipur', 'Dharamsala', 'Dhira', 'Fatehpur', 'Harchakian', 'Indora', 'Jai Singhpur', 'Jaswan', 'Jawalamukhi', 'Jawali', 'Kangra', 'Khundian', 'Multhan', 'Nagrota Bagwan', 'Nurpur', 'Palampur', 'Rakkar', 'Shahpur', 'Thural'],
            'Kinnaur' => ['Hangrang', 'Kalpa', 'Morang', 'Nichar', 'Poo', 'Sangla'],
            'Kullu' => ['Ani', 'Banjar', 'Kullu', 'Manali', 'Nirmand', 'Sainj'],
            'Lahaul and Spiti' => ['Lahul', 'Spiti', 'Udaipur'],
            'Mandi' => ['Aut', 'Baldwara', 'Bali Chowki', 'Bhadrota', 'Chachyot', 'Dharmpur', 'Jogindarnagar', 'Karsog', 'Kotli', 'Lad Bharol', 'Mandi', 'Nihri', 'Padhar', 'Sandhol', 'Sarkaghat', 'Sundarnagar', 'Thunag'],
            'Shimla' => ['Chaupal', 'Cheta', 'Chirgaon', 'Dodra Kwar', 'Jubbal (Deorha)', 'Junga', 'Kotkhai', 'Kumharsain', 'Nankhari', 'Nerua', 'Rampur', 'Rohru', 'Seoni', 'Shimla Rural', 'Shimla Urban', 'Theog', 'Tikar'],
            'Sirmaur' => ['Dadahu', 'Kamrau', 'Nahan', 'Nohra', 'Pachhad', 'Paonta Sahib', 'Rajgarh', 'Renuka', 'Ronhat (Sabgarh)', 'Shalai'],
            'Solan' => ['Arki', 'Baddi', 'Darlaghat', 'Kasauli', 'Kandaghat', 'Nalagarh', 'Ramshahr', 'Solan'],
            'Una' => ['Amb', 'Bangana', 'Bharwain', 'Haroli', 'Una'],
        ];
        $result = [];
        foreach ($tehsilList as $district => $tehsils) {
            $districtId = Region::where('name', $district)
                ->where('type_id', RegionTypeEnum::DISTRICT->id())
                ->valueOrFail('id');
            $result = array_merge($result, $this->buildRegion($tehsils, RegionTypeEnum::TEHSIL, $districtId));
        }

        return $result;
    }

    private function getBlocks(): array
    {
        $blockList = [
            'Bilaspur' => ['Ghumarwin-I', 'Ghumarwin-II', 'Jhandutta', 'Bilaspur Sadar', 'Swarghat'],
            'Chamba' => ['Bhattiyat', 'Banikhet', 'Bharmour', 'Chamba', 'Chowari', 'Garola', 'Gehra', 'Hardaspura', 'Kalhel', 'Kiani', 'Mehla', 'Pangi', 'Salooni', 'Sihunta', 'Sundla', 'Tissa'],
            'Hamirpur' => ['Bamson', 'Bhoranj', 'Bijhari', 'Galore', 'Hamirpur', 'Nadaun', 'Sujanpur'],
            'Kangra' => ['Baijnath', 'Bhawarna', 'Chadhiar', 'Dadasiba', 'Dehra', 'Dharamshala', 'Fatehpur', 'Indora', 'Jawali', 'Kangra', 'Lambagaon', 'Nagrota Bagwan', 'Nagrota Surian', 'Nurpur', 'Palampur', 'Panchrukhi', 'Pragpur', 'Rait', 'Raja Ka Talab', 'Rakkar', 'Sulah'],
            'Kinnaur' => ['Kalpa', 'Nichar', 'Pooh'],
            'Kullu' => ['Anni', 'Banjar', 'Kullu-I', 'Kullu-II', 'Naggar', 'Nirmand'],
            'Lahaul and Spiti' => ['Kaza', 'Keylong-I', 'Keylong-II', 'Udaipur'],
            'Mandi' => ['Aut', 'Balh', 'Balichowki', 'Chachiot-I', 'Chachiot-II', 'Chauntra-I', 'Chauntra-II', 'Dharampur-I', 'Dharampur-II', 'Drang-I', 'Drang-II', 'Gohar', 'Gopalpur-I', 'Gopalpur-II', 'Karsog-I', 'Karsog-II', 'Sadar-I', 'Sadar-II', 'Saigaloo', 'Seraj-I', 'Seraj-II', 'Sundernagar-I', 'Sundernagar-II'],
            'Shimla' => ['Basantpur', 'Chauhara', 'Chaupal', 'Deha', 'Dodrakawar', 'Jubbal Kotkhai', 'Kasumpati', 'Kumarsain', 'Kupvi', 'Mashobra', 'Matiana', 'Nankhari', 'Narkanda', 'Nerwa', 'Rampur', 'Rampur-II At Sarahan', 'Ransar (Jangla)', 'Rohru', 'Shimla-IV', 'Suni', 'Theog', 'Tikkar', 'Totu'],
            'Sirmaur' => ['Bakras', 'Dadahu', 'Kaffotta', 'Majra', 'Nahan', 'Narag', 'Nohradhar', 'Pachhad', 'Paonta Sahib', 'Rajgarh', 'Sangrah', 'Sarahan', 'Sataun', 'Shillai', 'Surla'],
            'Solan' => ['Arki', 'Dharampur', 'Dhundan', 'Kandaghat', 'Kunihar', 'Kuthar', 'Patta Nehlog', 'Nalagarh', 'Ramshahar', 'Solan'],
            'Una' => ['Amb', 'Bangana', 'Gagret-I', 'Gagret-II', 'Haroli', 'Una'],
        ];
        $result = [];
        foreach ($blockList as $district => $blocks) {
            $districtId = Region::where('name', $district)
                ->where('type_id', RegionTypeEnum::DISTRICT->id())
                ->valueOrFail('id');
            $result = array_merge($result, $this->buildRegion($blocks, RegionTypeEnum::BLOCK_TOWN, $districtId));
        }

        return $result;
    }

    private function getPanchayats()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/../json/panchayats.json'), true);
        $districtTypeEnumId = RegionTypeEnum::DISTRICT->id();
        $blockTypeEnumId = RegionTypeEnum::BLOCK_TOWN->id();
        $panchayatTypeEnumId = RegionTypeEnum::PANCHAYAT_WARD->id();
        $blockMappings = [
            'Ghumarwin' => 'Ghumarwin-I',
            'Shri Naina Devi Ji' => 'Swarghat',
            'Bijhri' => 'Bijhari',
            'Tihra Sujanpur' => 'Sujanpur',
            'Dehra Gopipur' => 'Dehra',
            'Lambagraon' => 'Lambagaon',
            'Kullu' => 'Kullu-I',
            'Nagar' => 'Naggar',
            'Lahaul' => 'Keylong-I',
            'Spiti' => 'Kaza',
            'Chauntra' => 'Chauntra-I',
            'Drang' => 'Drang-I',
            'Gopalpur' => 'Gopalpur-I',
            'Karsog' => 'Karsog-I',
            'Mandi Sadar' => 'Sadar-I',
            'Seraj' => 'Seraj-I',
            'Sundernagar' => 'Sundernagar-I',
            'Chopal' => 'Chaupal',
            'Tutu' => 'Totu',
            'Shilai' => 'Shillai',
            'Gagret' => 'Gagret-I',
            'Dharampur' => 'Dharampur-I',
        ];
        $result = [];
        foreach ($data as $district => $blockPanchayats) {
            $district = $district == 'Sirmour' ? 'Sirmaur' : $district;
            $districtId = Region::where([
                'name' => $district,
                'type_id' => $districtTypeEnumId,
            ])->value('id');
            foreach ($blockPanchayats as $block => $panchayats) {
                $blockId = Region::where([
                    'name' => $block,
                    'type_id' => $blockTypeEnumId,
                    'parent_id' => $districtId,
                ])->value('id');
                if (!$blockId && isset($blockMappings[$block])) {
                    $blockId = Region::where([
                        'name' => $blockMappings[$block],
                        'type_id' => $blockTypeEnumId,
                        'parent_id' => $districtId,
                    ])->value('id');
                }
                if (!$blockId) {
                    dd("Unknown block '$district($districtId) -> $block'!");
                }
                $result = array_merge($result, array_map(function ($name) use ($panchayatTypeEnumId, $blockId) {
                    return [
                        'name' => $name,
                        'type_id' => $panchayatTypeEnumId,
                        'parent_id' => $blockId,
                    ];
                }, $panchayats));
            }
        }
        return $result;
    }

    private function buildRegion(array $values, RegionTypeEnum $type, int $parentId = null): array
    {
        $typeId = $type->id();
        return array_map(function ($name) use ($typeId, $parentId) {
            return [
                'name' => $name,
                'type_id' => $typeId,
                'parent_id' => $parentId,
            ];
        }, $values);
    }
}
