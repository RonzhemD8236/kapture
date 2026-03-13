<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return '
                    <div class="action-wrap">
                        <a href="' . route('users.edit', $row->id) . '" class="btn-action-edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="#" class="btn-action-delete"
                            onclick="event.preventDefault(); if(confirm(\'Delete this user?\')) { document.getElementById(\'delete-' . $row->id . '\').submit(); }">
                            <i class="bi bi-trash"></i>
                        </a>
                        <form id="delete-' . $row->id . '" action="' . route('users.destroy', $row->id) . '" method="POST" style="display:none;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                        </form>
                    </div>
                ';
            })
            ->addColumn('status', function ($row) {
                return $row->is_active
                    ? '<span class="kap-badge kap-badge-active">Active</span>'
                    : '<span class="kap-badge kap-badge-inactive">Inactive</span>';
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->ajax(route('admin.users'))
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'dom'        => 'tip',
                'processing' => false,
                'serverSide' => true,
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('role'),
            Column::computed('status')
                ->exportable(false)
                ->printable(false),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}