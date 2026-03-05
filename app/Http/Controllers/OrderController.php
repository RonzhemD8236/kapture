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
    $order = Order::where('order_id', $id)
        ->update(['status' => $request->status]);

    if ($order > 0) {
        $myOrder = DB::table('orders as o')
            ->join('order_items as ol', 'o.order_id', '=', 'ol.order_id')
            ->join('item as i', 'ol.item_id', '=', 'i.item_id')
            ->where('o.order_id', $id)
            ->select('i.description', 'ol.quantity', 'i.img_path', 'i.sell_price')
            ->get();

        $user = DB::table('users as u')
            ->join('customer as c', 'u.id', '=', 'c.user_id') // c.user_id is correct
            ->join('orders as o', 'o.customer_id', '=', 'c.id') // ✅ c.id
            ->where('o.order_id', $id)
            ->select('u.id', 'u.email')
            ->first();

        Mail::to($user->email)->send(new SendOrderStatus($myOrder));

        return redirect()->route('admin.orders')->with('success', 'order updated');
    }

    return redirect()->route('admin.orders')->with('error', 'email not sent');
}
}
