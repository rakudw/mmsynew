<?php

namespace App\DataTables;

use App\Enums\ApplicationStatusEnum;
use App\Models\Views\ApplicationView;
use App\Models\Application;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Log;
class ReportApplicationsDataTable extends BaseDataTable
{
    /**
     * Get table id of the datatable.
     *
     * @return string
     */
    public function getTableId():string
    {
        return 'applications';
    }

    /**
     * List of columns that will be calculated through the view file, (name of column as key and name of the view as value)
     *
     * @return array<string,string>
     */
    public function getComputedColumns():array
    {
        return [
            'actions' => 'report.application_actions',
            'owner' => 'report.application_owner',
            'address' => 'report.application_address',
            'activity' => 'report.application_activity',
            'branch' => 'report.application_branch',
        ];
    }

    /**
     * List of columns in addition to the default columns.
     *
     * @return array
     */
    public function getAdditionalColumns(): array
    {
        $columns = [
            Column::make('name'),
            Column::make('constitution_type')->title('Type'),
            Column::make('owner'),
            Column::make('gender'),
            Column::make('social_category')->title('Category'),
            Column::make('address')->title('Address'),
            Column::make('activity')->title('Activity'),
            Column::make('land_cost')->title('Land Cost'),
            Column::make('building_cost')->title('Building Cost'),
            Column::make('assets_cost')->title('Assets Cost'),
            Column::make('machinery_cost')->title('Plant & Machinery'),
            Column::make('working_capital')->title('Working Capital'),
            Column::make('bank'),
            Column::make('branch')
        ];
        if (!in_array(request()->route()->parameter('type'), ['pending', 'rejected'])) {
            $columns[] = Column::make('status');
        }
        return $columns;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ReportApplication $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ApplicationView $model): QueryBuilder
    {
        $query = $model->forCurrentUser();
        switch (request()->route()->parameter('type')) {
            case 'sponsored':
                $query->where(fn($q) => $q->where('status_id', '>', ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id())->orWhere('status_id', ApplicationStatusEnum::LOAN_REJECTED->id()));
                Log::debug('This is a debug message', ['variable' => $query->toSql()]);
                break;
            case 'sanctioned':
                $query->where('status_id', '>', ApplicationStatusEnum::PENDING_60_SUBSIDY_REQUEST->id());
              
                break;
                case 'rejected':
                $query->where('status_id', ApplicationStatusEnum::LOAN_REJECTED->id());
                break;
            default:
                $query->where('status_id', ApplicationStatusEnum::PENDING_FOR_LOAN_DISBURSEMENT->id());
                break;
        }
        return $query;
    }
}
