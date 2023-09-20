<?php

namespace Database\Seeders;

use App\Enums\TypeEnum;
use App\Models\Enum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnumSeeder extends BaseSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->insertEnums();
    }

    public function insertEnums()
    {
        $enumTypes = TypeEnum::cases();
        foreach ($enumTypes as $i => $type) {
            $enums = $this->buildEnums(array_map(function ($e) {
                return $e->value;
            }, call_user_func(['\\App\Enums\\' . str_replace(' ', '', ucwords(strtolower(str_replace('_', ' ', $type->name)))) . 'Enum', 'cases'])), $type->name, ($i + 1) * 100);
            $this->walk($enums, [Enum::class, 'create']);
        }
    }

    private function buildEnums(array $values, string $type, int $idStarts): array
    {
        return array_map(function ($name) use ($type, &$idStarts) {
            return [
                'id' => ++$idStarts,
                'name' => $name,
                'type' => $type,
            ];
        }, $values);
    }
}
