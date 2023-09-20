<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

abstract class BaseDataTable extends DataTable
{

    abstract public function getTableId():string;
    abstract public function getAdditionalColumns():array;
    abstract public function getComputedColumns():array;

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $computedColumns = $this->getComputedColumns();
        $dataTable = (new EloquentDataTable($query))
            ->addColumn('action', $this->getTableId() . '.actions');
        foreach ($computedColumns as $column => $view) {
            $dataTable->addColumn($column, $view);
        }
        $dataTable->addColumn('updated_at', 'shared.datatables.columns.updated_at')
            ->addColumn('created_at', 'shared.datatables.columns.created_at')
            ->setRowId('id')
            ->rawColumns(['action', 'icon', 'updated_at', 'created_at', ...array_keys($computedColumns)]);
        return $dataTable;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId($this->getTableId() . '-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->orderBy(count($this->getColumns()) - 1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('Sr. No.')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->orderable(false)
                ->printable(false),
            Column::computed('actions')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
            Column::make('id'),
            ...$this->getAdditionalColumns(),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return $this->getTableId() . '_' . date('YmdHis');
    }
}