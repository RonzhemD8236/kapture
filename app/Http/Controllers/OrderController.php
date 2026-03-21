<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOrderStatus;

class OrderController extends Controller
{
    public function processOrder($id)
{
    $customer = DB::table('customer as c')
        ->join('orders as o', 'o.customer_id', '=', 'c.id') // ✅ c.id
        ->where('o.order_id', $id)
        ->select('c.lname', 'c.fname', 'c.addressline', 'c.phone',
                 'o.order_id as orderinfo_id', 'o.order_date as date_placed', 'o.status')
        ->first();

    $orders = DB::table('orders as o')
        ->join('order_items as ol', 'o.order_id', '=', 'ol.order_id')
        ->join('item as i', 'ol.item_id', '=', 'i.item_id')
        ->where('o.order_id', $id)
        ->select('i.description', 'ol.quantity', 'i.img_path', 'i.sell_price')
        ->get();

    $total = $orders->map(function ($item) {
        return $item->sell_price * $item->quantity;
    })->sum();

    return view('order.processOrder', compact('customer', 'orders', 'total'));
}

    public function orderUpdate(Request $request, $id)
    {
        $updated = Order::where('order_id', $id)
            ->update(['status' => $request->status]);

        if ($updated > 0) {
            // Single Eloquent model — has ->status, ->order_id, ->order_date
            $order = Order::where('order_id', $id)->first();

            // Items collection
            $orderItems = DB::table('order_items as ol')
                ->join('item as i', 'ol.item_id', '=', 'i.item_id')
                ->where('ol.order_id', $id)
                ->select('i.description', 'ol.quantity', 'i.sell_price')
                ->get();

            $orderTotal = $orderItems->sum(fn($item) => $item->sell_price * $item->quantity);

            // Customer + email
            $customer = DB::table('users as u')
                ->join('customer as c', 'u.id', '=', 'c.user_id')
                ->join('orders as o', 'o.customer_id', '=', 'c.id')
                ->where('o.order_id', $id)
                ->select('u.email', 'c.fname', 'c.lname')
                ->first();

            Mail::to($customer->email)->send(
                new SendOrderStatus($order, $orderItems, $orderTotal, $customer)
            );

            return redirect()->route('admin.orders')->with('success', 'Order updated');
        }

        return redirect()->route('admin.orders')->with('error', 'Update failed');
    }
}
