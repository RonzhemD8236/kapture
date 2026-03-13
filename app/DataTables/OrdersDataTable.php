<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class OrdersDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()->query($query)
            ->addColumn('action', function ($row) {
                return '
                    <a href="' . route('admin.orderDetails', $row->orderinfo_id) . '"
                       class="btn-kap-details">
                        Details
                    </a>
                ';
            })
            ->addColumn('status', function ($row) {
                $cls = 'status-' . strtolower($row->status);
                return '<span class="status-badge ' . $cls . '">' . ucfirst($row->status) . '</span>';
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    public function query()
    {
        return DB::table('customer as c')
            ->join('orders as o', 'o.customer_id', '=', 'c.id')
            ->join('order_items as ol', 'o.order_id', '=', 'ol.order_id')
            ->join('item as i', 'ol.item_id', '=', 'i.item_id')
            ->select(
                'o.order_id as orderinfo_id',
                'c.fname',
                'c.lname',
                'c.addressline',
                'o.order_date as date_placed',
                'o.status',
                DB::raw('SUM(ol.quantity * i.sell_price) as total')
            )
            ->groupBy(
                'o.order_id',
                'c.fname',
                'c.lname',
                'c.addressline',
                'o.order_date',
                'o.status'
            );
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('orders-table')
            ->columns($this->getColumns())
            ->ajax(route('admin.orders'))
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'dom'        => 'tip',
                'processing' => false,
                'serverSide' => false,
            ]);
    }

    public function getColumns(): array
    {
        return [
            ['data' => 'orderinfo_id', 'name' => 'o.order_id',    'title' => 'Order ID'],
            ['data' => 'lname',        'name' => 'c.lname',        'title' => 'Last Name'],
            ['data' => 'fname',        'name' => 'c.fname',        'title' => 'First Name'],
            ['data' => 'addressline',  'name' => 'c.addressline',  'title' => 'Address'],
            ['data' => 'date_placed',  'name' => 'o.order_date',   'title' => 'Date Ordered'],
            ['data' => 'status',       'name' => 'o.status',       'title' => 'Status'],
            Column::make('total')->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Orders_' . date('YmdHis');
    }
}