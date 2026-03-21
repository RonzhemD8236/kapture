<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class UsersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('status', function ($row) {
                $active = $row->is_active ?? true;
                $label  = $active ? 'Active' : 'Inactive';
                $class  = $active ? 'status-active' : 'status-inactive';
                return '<span class="user-status ' . $class . '">' . $label . '</span>';
            })
            ->addColumn('action', function ($row) {
                if ((int)$row->id === (int)Auth::id()) {
                    return '<div class="action-wrap">—</div>';
                }

                return '
                    <div class="action-wrap">
                        <a href="' . route('users.edit', $row->id) . '" class="btn-action-edit" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="#" class="btn-action-delete" title="Delete"
                            onclick="event.preventDefault(); if(confirm(\'Delete this user?\')) { document.getElementById(\'delete-' . $row->id . '\').submit(); }">
                            <i class="bi bi-trash"></i>
                        </a>
                        <form id="delete-' . $row->id . '" action="' . route('users.destroy', $row->id) . '" method="POST" style="display:none;">
                            ' . csrf_field() . method_field('DELETE') . '
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['status', 'action'])
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
            Column::make('status')->title('Status'),
            Column::make('created_at')->title('Created At'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}