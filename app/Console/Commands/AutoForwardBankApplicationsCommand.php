<?php

namespace App\Console\Commands;

use App\Enums\ApplicationStatusEnum;
use App\Events\ApplicationStatusEvent;
use App\Models\Application;
use App\Models\ApplicationTimeline;
use App\Models\Event;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;

class AutoForwardBankApplicationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'applications:forward';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Forwards the applications to GM for DLC if bank did not entertain within 7 days.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bankDate = new Carbon('-7 days'); // $this->getLastSevenWorkingDate();
        $applicationsToUpdate = Application::where('status_id', ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS->id())->where('updated_at', '<', $bankDate->format('Y-m-d'))->get();

        foreach($applicationsToUpdate as $application) {

            ApplicationTimeline::create([
                'application_id' => $application->id,
                'remarks' => 'The application is automatically forwarded for DLC since no action is taken by the bank official within the time limit.',
                'old_status_id' => ApplicationStatusEnum::PENDING_FOR_BANK_CIBIL_COMMENTS->id(),
                'new_status_id' => ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id(),
            ]);

            $application->status_id = ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id();
            $application->save();

            ApplicationStatusEvent::dispatch($application);
        }

        return 0;
    }

    public function getLastSevenWorkingDate()
    {
        $dayToCheck = date('Y-m-d', strtotime('-1 day'));
        $workingDays = 0;

        $holidays = array_merge(
            // Holidays from the database
            Event::holidays()->whereBetween('date', [date('Y-m-d', strtotime('-30 days')), date('Y-m-d')])->select('date')->get()->map(fn($d) => $d['date']->format('Y-m-d'))->all(),
            // 2nd and 4th Saturdays of this month
            $this->getSecondAndFourthSaturdays(date('Y'), date('m')),
            // 2nd and 4th Saturdays of previous month
            $this->getSecondAndFourthSaturdays(date('Y', strtotime('-1 month')), date('m', strtotime('-1 month'))),
            // Sundyas of this month
            $this->getSundays(date('Y'), date('m')),
            // Sundyas of previous month
            $this->getSundays(date('Y', strtotime('-1 month')), date('m', strtotime('-1 month'))),
        );

        while ($workingDays < 7) {
            if(!in_array($dayToCheck, $holidays)) {
                $workingDays++;
            } else {
                $this->info("$dayToCheck is a holiday.");
            }
            $this->info($dayToCheck);
            $dayToCheck = date('Y-m-d', strtotime('-1 day', strtotime($dayToCheck)));
        }

        return $dayToCheck;
    }

    public function getSecondAndFourthSaturdays(int $year = null, int $month = null)
    {
        $year = $year ?? intval(date('Y'));
        $month = $month ?? intval(date('m'));

        $firstDay = new DateTime();
        $firstDay->setDate($year, $month, 1);

        $firstWeekDay = $firstDay->format('w');

        $secondSaturdayDateDiff = 13 - $firstWeekDay;
        $fourthSaturdayDateDiff = 27 - $firstWeekDay;

        $firstDayTimestamp = strtotime($firstDay->format('Y-m-d'));

        return [date('Y-m-d', strtotime("+$secondSaturdayDateDiff days", $firstDayTimestamp)), date('Y-m-d', strtotime("+$fourthSaturdayDateDiff days", $firstDayTimestamp))];
    }

    public function getSundays(int $year = null, int $month = null)
    {
        $monthStart = new DateTime();
        $monthStart->setDate($year, $month, 1);
        $date = $monthStart->format('Y-m-d');
        $firstDay = date('N', strtotime($date));
        $firstDay = 7 - $firstDay + 1;
        $lastDay = date('t', strtotime($date));
        $days = [];
        for ($i = $firstDay; $i <= $lastDay; $i = $i + 7) {
            $d = new DateTime();
            $d->setDate($year, $month, $i);
            $days[] = $d->format('Y-m-d');
        }
        return $days;
    }
}
