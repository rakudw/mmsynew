<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatusEnum;
use App\Enums\MeetingApplicationStatusEnum;
use App\Enums\RegionTypeEnum;
use App\Enums\RoleEnum;
use App\Events\ApplicationStatusEvent;
use App\Helpers\ExportHelper;
use App\Models\Application;
use App\Models\ApplicationTimeline;
use App\Models\Meeting;
use App\Models\Region;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index()
    {
        if (!$this->user()->roles()->count()) {
            return redirect()->route('application.newstatus');
        }
        // Get Weekly and Monthly Application counts 
        $monthStartDate = Carbon::now()->startOfMonth();
        $weekStartDate = Carbon::now()->startOfDay();

        $monthlyCounts = [];
        $monthlyLabels = [];
        $senctionedMonthlyCounts = [];
        $senctionedMonthlyLabels = [];
        $weeklyCounts = [];
        $weeklyLabels = [];

        // Calculate the start date for the current month
        for ($i = 0; $i < 12; $i++) {
            // echo $monthStartDate;
            // Calculate the end date for the current month
            $monthEndDate = $monthStartDate->copy()->endOfMonth();
            $monthName = $monthStartDate->format('M'); // Example: "Apr 2023"
            // Count applications for the current month
            $monthlyCount = Application::forCurrentUser()
                ->whereBetween('created_at', [$monthStartDate, $monthEndDate])
                ->count();
            $senctionedMonthlyCount = Application::forCurrentUser()->where('status_id', '>=', ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())
                ->whereBetween('created_at', [$monthStartDate, $monthEndDate])
                ->count();

            // Add monthly count to the monthlyCounts array

            $monthlyLabels[] = $monthName;
            $monthlyCounts[] = $monthlyCount;
            $senctionedMonthlyCouns[] = $senctionedMonthlyCount;

            // Move to the next month
            $monthStartDate->subMonth();
        }

        // Weekly
        // Calculate the start date for the current week
        for ($i = 0; $i < 7; $i++) {
            // Calculate the end date for the current day
            $weekEndDate = $weekStartDate->copy()->endOfDay();
            $dayName = $weekStartDate->format('D'); // Example: "Sun"
            $dayNumber = $weekStartDate->format('d'); // Example: "01"
            // Count applications for the current day
            $dailyCount = Application::forCurrentUser()
                ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
                ->count();

            // Add daily count to the weeklyCounts array
            // Count applications for the current day
            $dailyCount = Application::forCurrentUser()
                ->whereDate('created_at', $weekStartDate->format('Y-m-d'))
                ->count();

            // Add daily data to the weeklyData array
            $weeklyLabels[] = $dayName;
            $weeklyCounts[] = $dailyCount;

            // Move to the next day
            $weekStartDate->subDay();
        }
        $weeklyCounts = array_reverse($weeklyCounts);
        $monthlyCounts = array_reverse($monthlyCounts);
        $monthlyLabels = array_reverse($monthlyLabels);
        $weeklyLabels = array_reverse($weeklyLabels);
        $senctionedMonthlyCouns = array_reverse($senctionedMonthlyCouns);

        $this->addJs('resources/material/js/plugins/chartjs.min.js');
        $this->addJs('resources/ts/dashboard.ts');
        return view('dashboard.index', compact('monthlyCounts', 'monthlyLabels', 'senctionedMonthlyCouns', 'weeklyCounts', 'weeklyLabels'));
    }

    private function getDefaultPendencyStatus(): ?int
    {
        if ($this->user()->isNodalDIC()) {
            return ApplicationStatusEnum::PENDING_AT_DISTRICT_INDUSTRIES_CENTER->id();
        }
        return null;
    }

    public function pendency($statusId = null)
    {
        $userPendencyStatuses = $this->user()->pendency_application_statuses;

        if (!in_array($statusId, $userPendencyStatuses)) {
            $userPendencyStatuses[] = $statusId;
        }
        if (empty($userPendencyStatuses)) {
            return view('errors.403', ['exception' => new Exception('You don\'t have any pendecy!')]);
        }

        $title = "Pending applications";
        if (is_null($statusId)) {
            $statusId = $this->getDefaultPendencyStatus() ?? $userPendencyStatuses[0];
        }

        if (!in_array($statusId, $userPendencyStatuses)) {
            return redirect()->route('dashboard.pendency');
        }

        $userPendencyStatuses = array_filter($userPendencyStatuses);
        $pendencyStatuses = array_map(fn ($s) => ApplicationStatusEnum::fromId($s), $userPendencyStatuses);

        $pendingApplications = Application::forCurrentUser()->where('status_id', $statusId)->orderBy('updated_at', 'DESC')->paginate(15);

        $existingMeeting = null;
        $selectedApplications = $existingMeeting ? $existingMeeting->applications()->select('application_id')->get()->pluck('application_id')->toArray() : [];

        $this->addJs('resources/ts/pendency.ts');
        return view('dashboard.pendency', compact('title', 'pendingApplications', 'existingMeeting', 'selectedApplications', 'pendencyStatuses', 'statusId'));
    }

    public function schedule(Meeting $meeting = null)
    {
        if (!$this->user()->canScheduleMeeting()) {
            return redirect()->route('dashboard.pendency')->with('error', 'You cannot schedule meeting!');
        }

        $title = "Schedule DLC Meeting";

        if (!$meeting) {
            $meeting = Meeting::whereIn('district_id', $this->user()->getDistricts())->where('was_conducted', 0)->first();
        } elseif ($meeting->was_conducted) {
            return redirect()->route('dashboard.meetings.application', ['meeting' => $meeting->id]);
        }

        $pendingApplications = Application::forCurrentUser()->where('status_id', ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id())->with([
            'bankBranch' => fn ($q) => $q->with('bank')
        ])->orderBy('updated_at', 'DESC')->orderBy('status_id')->get();

        $this->addJs('resources/ts/pendency.ts');
        $selectedApplications = $meeting ? $meeting->applications()->select('application_id')->get()->pluck('application_id')->all() : [];
        return view('dashboard.schedule', compact('title', 'pendingApplications', 'meeting', 'selectedApplications'));
    }

    public function approved()
    {
        $title = "Approved applications";
        $applications = Application::approvedApplications()
            ->with([
                'bankBranch' => fn ($q) => $q->with('bank')
            ])->forCurrentUser()->orderBy('updated_at', 'DESC')->paginate(15);
        return view('dashboard.applications', compact('title', 'applications'));
    }

    public function reports()
    {
        $title = "Reports";
        $applicationsQuery = Application::forCurrentUser()->with([
            'bankBranch' => fn ($query) => $query->with('bank')
        ])->orderBy('updated_at', 'DESC');
        $statusId = intval(request()->get('status_id'));
        $sqlQuery = $applicationsQuery->toSql();
        if ($statusId > 0) {
            $applicationsQuery->where('status_id', $statusId);
        }

        $query = trim(request()->get('search'));
        // dd($sqlQuery);

        if ($query) {

            if (is_numeric($query)) {
            //     $applicationsQuery->where('id', $query);
            // } else {
            $applicationsQuery->whereRaw("(`id`) LIKE ?", ['%' . strtolower($query) . '%']);
            }
            else{
                $applicationsQuery->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.name'))) LIKE ?", ['%' . strtolower($query) . '%']);
            }
            // }
            // dd($applicationsQuery->get());
        }

        // dd($applicationsQuery);  

        // dd($query);
        $applications = $applicationsQuery->paginate(10)->withQueryString();
        return view('dashboard.reports', compact('title', 'applications'));
    }

    public function report(Application $application)
    {
        $title = "Report Detail";
        $form = $application->form;
        $formDesigns = $form->formDesigns ?? null;
        return view('dashboard.report', compact('title', 'application', 'form', 'formDesigns'));
    }

    public function pending()
    {
        $title = "Pending Applications";
        return view('dashboard.pending', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'id' => 'nullable|numeric',
            'applications' => 'required',
            'title' => 'required|min:3|max:255',
            'date' => 'required',
            'time' => 'required',
            'chair_person' => 'required',
            'remarks' => 'nullable',
        ]);

        $firstApplication = Application::find($validation['applications'][0]);

        $meeting = null;
        if (isset($validation['id']) && $validation['id'] > 0) {
            $meeting = Meeting::where('id', $validation['id'])->where('district_id', $firstApplication->region_id)->where('was_conducted', false)->firstOrFail();
            $meeting->fill([
                'title' => $validation['title'],
                'datetime' => date('Y-m-d H:i:s', strtotime("{$validation['date']} {$validation['time']}")),
                'district_id' => $firstApplication->region_id,
                'chair_person' => $validation['chair_person'],
                'was_conducted' => false,
                'remarks' => $validation['remarks'] ?? null,
                'updated_by' => Auth::id(),
            ]);
            $meeting->save();
        } else {
            $meeting = Meeting::create([
                'title' => $validation['title'],
                'datetime' => date('Y-m-d H:i:s', strtotime("{$validation['date']} {$validation['time']}")),
                'district_id' => $firstApplication->region_id,
                'chair_person' => $validation['chair_person'] ?? '',
                'was_conducted' => false,
                'remarks' => $validation['remarks'] ?? null,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
        }

        $meeting->applications()->syncWithPivotValues(
            $validation['applications'],
            ['status' => 'PENDING', 'created_by' => Auth::id()]
        );

        return back()->with('success', 'Thank you for updating with applications.');
    }

    /**
     * Read notifications
     */
    public function readNotification($id)
    {
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        return back()->with('success', 'Notification mark as read');
    }

    /**
     * Delete notification
     * @return Response
     */
    public function deleteNotification($id)
    {
        $user = $this->user();
        $user->notifications()->where('id', $id)->delete();

        return back()->with('success', 'Notification has been removed.');
    }

    /**
     * Let's get all applications as Constituency
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function reportApplicationByDistrict($id)
    {
        $title = "Reports";
        $applications = Application::where('data->enterprise->district_id', $id)->paginate(12);
        return view('dashboard.reports', compact('title', 'applications'));
    }

    /**
     * Let's get all applications as Constituency
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function reportApplicationByConstituency($id)
    {
        $title = "Reports";
        $applications = Application::where('data->enterprise->constituency_id', $id)->paginate(12);
        return view('dashboard.reports', compact('title', 'applications'));
    }

    /**
     * Let's get all applications as Constituency
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function reportApplicationByBlock($id)
    {
        $title = "Reports";
        $applications = Application::where('data->enterprise->block_id', $id)->paginate(12);
        return view('dashboard.reports', compact('title', 'applications'));
    }

    /**
     * Let's get all applications as Constituency
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function meetingApplications()
    {
        $districts = Region::userBasedDistricts()->select('id')->get()->map(fn ($r) => $r->id)->toArray();
        $title = "Scheduled Meetings";
        $meetings = Meeting::withCount('applications')->with('district')->whereIn('district_id', $districts)->orderByDesc('created_at')->paginate(12);
        return view('dashboard.meetings', compact('title', 'meetings'));
    }

    /**
     * Let's get all applications as Constituency
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function meetingApplication(Meeting $meeting)
    {

        $query = trim(request()->get('search'));
        $applications = $meeting->applications();
        if ($query) {
            $applications->whereRaw("LOWER(`name`) LIKE ?", ['%' . strtolower($query) . '%'])
                ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.name'))) LIKE ?", ['%' . strtolower($query) . '%'])
                ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.address'))) LIKE ?", ['%' . strtolower($query) . '%'])
                ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.enterprise.pincode'))) LIKE ?", ['%' . strtolower($query) . '%'])
                ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.pan'))) LIKE ?", ['%' . strtolower($query) . '%'])
                ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.email'))) LIKE ?", ['%' . strtolower($query) . '%'])
                ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(`data`, '$.owner.name'))) LIKE ?", ['%' . strtolower($query) . '%']);
        }
        $applications = $applications->get();
        $title = "Applications listed for Meeting";
        $this->addJs('resources/ts/pendency.ts');
        return view('dashboard.meeting', compact('title', 'meeting', 'applications'));
    }

    public function agenda(Meeting $meeting, $download = 1)
    {
        $pdf = PDF::loadView('pdf.agenda', ['applications' => $meeting->applications, 'meeting' => $meeting], [], 'UTF-8')->setPaper('legal', 'landscape');
        return call_user_func_array([$pdf, $download ? 'download' : 'stream'], ["meeting-agenda-{$meeting->id}.pdf"]);
    }

    public function exportAgenda(Meeting $meeting)
    {
        try {
            $writer = ExportHelper::agenda($meeting);

            // Set response headers
            header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="meeting-agenda-' . $meeting->unique_id . '.xlsx"');

            // Save the spreadsheet to the output
            $writer->save('php://output');
        } catch (PhpSpreadsheetException $e) {
            // Handle PhpSpreadsheet-related exceptions (e.g., invalid data)
            // Log or display an error message
            return response()->json(['error' => 'An error occurred while exporting the Excel file.'], 500);
        } catch (WriterException $e) {
            // Handle Writer-related exceptions (e.g., file I/O issues)
            // Log or display an error message
            return response()->json(['error' => 'An error occurred while saving the Excel file.'], 500);
        } catch (\Exception $e) {
            // Handle any other unexpected exceptions
            // Log or display an error message
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function minutes(Meeting $meeting, $download = 1)
    {
        $pdf = PDF::loadView('pdf.minutes', ['applications' => $meeting->applications()->with([
            'bankBranch' => fn ($q) => $q->with('bank'),
            'meetingApplications' => fn ($q) => $q->orderByDesc('updated_at')
        ])->get(), 'meeting' => $meeting], [], 'UTF-8')->setPaper('legal', 'landscape');
        return call_user_func_array([$pdf, $download ? 'download' : 'stream'], ["meeting-minutes-{$meeting->id}.pdf"]);
    }

    public function updateStatus(Request $request)
    {
        if (!$this->user()->canScheduleMeeting()) {
            return redirect()->route('dashboard.pendency')->with('error', 'You cannot schedule meeting!');
        }
        $validation = $request->validate([
            'applications' => 'required',
            'status' => 'required',
            'comment' => 'required',
        ]);

        $meetingsToCheck = [];
        foreach ($validation['applications'] as $applicationId) {
            $application = Application::find($applicationId);

            if ($application && $application->application_status == ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE) {
                $meetingApplication = $application->meetingApplications()->where('status', MeetingApplicationStatusEnum::PENDING->value)->orderBy('updated_at', 'desc')->first();
                if ($meetingApplication) {
                    $meetingApplication->status = $validation['status'] == ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id() ? MeetingApplicationStatusEnum::APPROVED : ($validation['status'] == ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id() ? MeetingApplicationStatusEnum::REJECTED : MeetingApplicationStatusEnum::DEFERRED);
                    $meetingApplication->remarks = $validation['comment'];
                    $meetingApplication->save();

                    ApplicationTimeline::create([
                        'application_id' => $application->id,
                        'remarks' => $validation['comment'],
                        'old_status_id' => $application->status_id,
                        'new_status_id' => $validation['status'],
                    ]);

                    if ($validation['status'] != ApplicationStatusEnum::PENDING_FOR_DISTRICT_LEVEL_COMMITTEE->id()) {
                        $application->status_id = $validation['status'];
                        $application->save();
                        ApplicationStatusEvent::dispatch($application);
                    }

                    if (!isset($meetingsToCheck[$meetingApplication->meeting_id])) {
                        $meetingsToCheck[$meetingApplication->meeting_id] = $meetingApplication->meeting;
                    }
                }
            }
        }

        foreach ($meetingsToCheck as $meeting) {
            if ($meeting->meetingApplications()->where('status', MeetingApplicationStatusEnum::PENDING->value)->count() == 0) {
                $meeting->was_conducted = true;
                $meeting->save();
            }
        }

        return back()->with('success', 'Thank you! Application status changed');
    }
}
