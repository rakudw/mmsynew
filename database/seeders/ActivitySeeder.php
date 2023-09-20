<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Enum;

class ActivitySeeder extends BaseSeeder
{

    public function run()
    {
        $this->walk($this->getFromJson(), [Activity::class, 'create']);
    }

    private function getFromJson() {
        $activityTypes = Enum::select('id', 'name')->where('type', 'ACTIVITY_TYPE')->get()->keyBy('name')->toArray();
        return array_map(function ($activity) use($activityTypes) {
            return [
                'name' => $activity[0],
                'type_id' => $activityTypes[$activity[1]]['id'],
            ];
        }, json_decode(BankBranchSeeder::removeBomUtf8(file_get_contents(__DIR__ . '/../json/activities.json')), false, 512, JSON_THROW_ON_ERROR));
    }
}