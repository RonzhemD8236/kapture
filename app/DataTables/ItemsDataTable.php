<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ItemsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()->of($query)
            ->addColumn('image', function ($row) {
                $src = ($row->img_path === 'default.jpg' || !$row->img_path)
                    ? asset('images/default.jpg')
                    : asset('storage/' . $row->img_path);
                return '<img src="' . $src . '" style="width:70px;height:70px;object-fit:cover;border:1px solid rgba(168,155,194,0.12);">';
            })
            ->editColumn('sell_price', fn($row) => '₱ ' . number_format($row->sell_price, 2))
            ->editColumn('cost_price', fn($row) => '₱ ' . number_format($row->cost_price, 2))
            ->editColumn('quantity', function ($row) {
                $qty   = $row->quantity ?? 0;
                $color = $qty <= 5 ? '#c06060' : '#d4cfe0';
                return '<span style="font-size:1rem;color:' . $color . ';">' . $qty . '</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="action-wrap">
                        <a href="' . route('items.edit', $row->item_id) . '" class="btn-action-edit" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="' . route('items.destroy', $row->item_id) . '" method="POST" class="d-inline"
                              onsubmit="return confirm(\'Remove this item?\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn-action-delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['image', 'quantity', 'action']);
    }

    public function query()
    {
        return DB::table('item as i')
            ->leftJoin('stock as s', 'i.item_id', '=', 's.item_id')
            ->whereNull('i.deleted_at')
            ->select(
                'i.item_id', 'i.title', 'i.img_path',
                'i.sell_price', 'i.cost_price',
                DB::raw('COALESCE(s.quantity, 0) as quantity')
            )
            ->orderBy('i.item_id', 'asc');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('items-table')
            ->columns($this->getColumns())
            ->ajax(route('items.index'))
            ->orderBy(0, 'asc')
            ->parameters([
                'dom'        => 'tip',
                'processing' => false,
                'serverSide' => false,
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('item_id')->title('ID'),
            Column::computed('image')->title('Image')->orderable(false)->searchable(false),
            Column::make('title')->title('Item Name'),
            Column::make('sell_price')->title('Sell Price'),
            Column::make('cost_price')->title('Cost Price'),
            Column::make('quantity')->title('Qty'),
            Column::computed('action')->title('Actions')
                ->exportable(false)->printable(false)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Items_' . date('YmdHis');
    }
}