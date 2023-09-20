<?php

namespace Database\Seeders;

use App\Enums\BankTypeEnum;
use App\Models\Bank;
use App\Models\Enum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends BaseSeeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->walk(array_merge($this->getCooperativeSectorBanks(), $this->getPrivateSectorBanks(), $this->getPublicSectorBanks(), $this->getRegionalRuralBanks(), $this->getSmallFinanceBanks(), $this->getUrbanCooperativeSectorBanks()), [Bank::class, 'create']);
    }

    private function getCooperativeSectorBanks()
    {
        return $this->buildBanks(['Jogindra Central Co-operative Bank', 'The Himachal Pradesh State Co-operative Bank', 'Kangra Central Co-operative Bank'], BankTypeEnum::COOPERATIVE_SECTOR_BANK);

    }

    private function getPrivateSectorBanks()
    {
        return $this->buildBanks(['IndusInd Bank', 'Axis Bank', 'Jammu & Kashmir Bank', 'South Indian Bank', 'ICICI Bank', 'IDBI Bank', 'HDFC Bank', 'Bandhan Bank', 'Yes Bank', 'Kotak Mahindra Bank', 'CSB Bank'], BankTypeEnum::PRIVATE_SECTOR_BANK);
    }

    private function getPublicSectorBanks()
    {
        return $this->buildBanks(['Punjab National Bank', 'Bank of Baroda', 'Canara Bank', 'Indian Bank', 'Bank of India', 'Central Bank of India', 'Punjab & Sind Bank', 'Indian Overseas Bank', 'State Bank of India', 'Bank Of Maharashtra', 'Union Bank of India', 'UCO Bank'], BankTypeEnum::PUBLIC_SECTOR_BANK);
    }

    private function getRegionalRuralBanks()
    {
        return $this->buildBanks(['Himachal Pradesh Gramin Bank'], BankTypeEnum::REGIONAL_RURAL_BANK);
    }

    private function getSmallFinanceBanks()
    {
        return $this->buildBanks(['Ujjivan Small Finance Bank', 'AU Small Finance Bank'], BankTypeEnum::SMALL_FINANCE_BANK);
    }

    private function getUrbanCooperativeSectorBanks()
    {
        return $this->buildBanks(['The Parwanoo Urban Co-Operative Bank', 'The Baghat Urban Co-operative Bank'], BankTypeEnum::URBAN_COOPERATIVE_SECTOR_BANK);
    }

    private function buildBanks(array $values, BankTypeEnum $type): array
    {
        $typeId = $type->id();
        return array_map(function ($name) use ($typeId) {
            return [
                'name' => $name,
                'type_id' => $typeId,
            ];
        }, $values);
    }
}
