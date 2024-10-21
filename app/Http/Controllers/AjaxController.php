<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatusEnum;
use App\Models\Application;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\ComponentAttributeBag;
use stdClass;
use Illuminate\Support\Facades\DB;
use \NumberFormatter;

class AjaxController extends Controller
{
    public function get(string $table, int $id)
    {
        $table = ucfirst($table);
        try {
            return class_exists("\\App\\Models\\$table")
            ? response()->json(call_user_func_array(["\\App\\Models\\$table", 'find'], [$id]))
            : response()->json('Not found!', 404);
        } catch (Exception $ex) {
            Log::error($ex->getMessage(), ['exception' => $ex]);
            return response()->json(['error' => $ex->getMessage()], 503);
        }
    }

    public function search(string $table)
    {
        $table = ucfirst($table);
        $filters = request('filter');
        try {
            $columns = request('columns') ? explode(',', request('columns')) : ['id', 'name'];
            return class_exists("\\App\\Models\\$table") && !empty($filters)
            ? response()->json(call_user_func_array(["\\App\\Models\\$table", 'where'], [$filters])->select($columns)->get())
            : response()->json('Not found!', 404);
        } catch (Exception $ex) {
            Log::error($ex->getMessage(), ['exception' => $ex]);
            return response()->json('Error', 503);
        }
    }

    public function load()
    {
        $attributes = new stdClass();
        $attributes->{'data-options'} = request('options');
        return response()->json((new ComponentAttributeBag())->buildOptions((object) [
            'attributes' => $attributes,
        ]));
    }

    public function count()
    {
        $rejectionStatuses = [];
        if ($this->user()->isBankManager() || $this->user()->isBankRO()) {
            $rejectionStatuses[] = ApplicationStatusEnum::LOAN_REJECTED->id();
        } else {
            $rejectionStatuses = [ApplicationStatusEnum::REJECTED_AT_DISTRICT_INDUSTRIES_CENTER->id(), ApplicationStatusEnum::REJECTED_AT_DISTRICT_LEVEL_COMMITTEE->id(), ApplicationStatusEnum::LOAN_REJECTED->id()];
        }
        $totalReleasedAmount = Application::forCurrentUser()
        ->select(DB::raw('SUM(CASE WHEN JSON_CONTAINS_PATH(data, "one", "$.subsidy.amount60") THEN JSON_UNQUOTE(JSON_EXTRACT(data, "$.subsidy.amount60")) ELSE 0 END + CASE WHEN JSON_CONTAINS_PATH(data, "one", "$.subsidy.amount40") THEN JSON_UNQUOTE(JSON_EXTRACT(data, "$.subsidy.amount40")) ELSE 0 END) AS total_released_amount'))
        ->value('total_released_amount');
        // Create a NumberFormatter with the Indian locale
        $formatter = new NumberFormatter('en_IN', NumberFormatter::CURRENCY);
        $NewPortalReleasedAmount = $formatter->formatCurrency($totalReleasedAmount, 'INR');

        $counts = [
            'sanctioned' => Application::forCurrentUser()->where('status_id', '>=', ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())->count(),
            'rejected' => Application::forCurrentUser()->whereIn('status_id', $rejectionStatuses)->count(),
            'pendency' => $this->user()->isBankRO() ? Application::forCurrentUser()->where('status_id', ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())->count() : Application::pendingApplications()->forCurrentUser()->count(),
            'total' => Application::forCurrentUser()->count(),
            'newPortalReleased' => $NewPortalReleasedAmount,
        ];

        return response()->json($counts);
    }
}
