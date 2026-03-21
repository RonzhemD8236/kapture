<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('getCart')->with('error', 'Your cart is empty.');
        }

        $total    = collect($cart)->sum(fn($i) => $i['sell_price'] * $i['quantity']);
        $customer = DB::table('customer')->where('user_id', Auth::id())->first();
        $user     = Auth::user();

        return view('shop.checkout', compact('cart', 'total', 'customer', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname'       => 'required|string|max:100',
            'lname'       => 'required|string|max:100',
            'title'       => 'required|string|max:10',
            'addressline' => 'required|string|max:255',
            'town'        => 'required|string|max:100',
            'zipcode'     => 'required|string|max:20',
            'phone'       => 'required|string|max:20',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('getCart')->with('error', 'Your cart is empty.');
        }

        $total    = collect($cart)->sum(fn($i) => $i['sell_price'] * $i['quantity']);
        $customer = DB::table('customer')->where('user_id', Auth::id())->first();

        if ($customer) {
            DB::table('customer')->where('user_id', Auth::id())->update([
                'title'       => $request->title,
                'fname'       => $request->fname,
                'lname'       => $request->lname,
                'addressline' => $request->addressline,
                'town'        => $request->town,
                'zipcode'     => $request->zipcode,
                'phone'       => $request->phone,
                'updated_at'  => now(),
            ]);
            $customerId = $customer->id;
        } else {
            $customerId = DB::table('customer')->insertGetId([
                'title'       => $request->title,
                'fname'       => $request->fname,
                'lname'       => $request->lname,
                'addressline' => $request->addressline,
                'town'        => $request->town,
                'zipcode'     => $request->zipcode,
                'phone'       => $request->phone,
                'user_id'     => Auth::id(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $orderId = DB::table('orders')->insertGetId([
            'customer_id'  => $customerId,
            'total_amount' => $total,
            'status'       => 'pending',
            'order_date'   => now(),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        foreach ($cart as $item) {
            DB::table('order_items')->insert([
                'order_id'   => $orderId,
                'item_id'    => $item['item_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['sell_price'],
                'subtotal'   => $item['sell_price'] * $item['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('stock')
                ->where('item_id', $item['item_id'])
                ->decrement('quantity', $item['quantity']);
        }

        $customer = DB::table('customer')->where('id', $customerId)->first();

        $order = (object)[
            'order_id'       => $orderId,
            'status'         => 'pending',
            'payment_method' => 'Cash on Delivery',
            'created_at'     => now(),
            'address'        => $request->addressline . ', ' . $request->town . ', ' . $request->zipcode,
        ];

        // Send confirmation email
        Mail::to(Auth::user()->email)
            ->send(new OrderConfirmation(
                $order,
                $cart,
                $total,
                $customer
            ));

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Order #' . $orderId . ' placed successfully!');
    }

        public function downloadReceipt($id)
    {
        // Make sure the order belongs to this customer
        $customer = DB::table('customer')->where('user_id', Auth::id())->first();
        
        $order = DB::table('orders')
            ->where('order_id', $id)
            ->where('customer_id', $customer->id)
            ->first();

        abort_if(!$order, 403);

        $cart = DB::table('order_items')
            ->join('item', 'order_items.item_id', '=', 'item.item_id')
            ->where('order_items.order_id', $id)
            ->select(
                'item.title',
                'order_items.quantity',
                'order_items.price as sell_price',
                'order_items.subtotal'
            )
            ->get()
            ->map(fn($i) => (array) $i)
            ->toArray();

        $total = collect($cart)->sum('subtotal');

        $orderObj = (object)[
            'order_id'       => $order->order_id,
            'status'         => $order->status,
            'payment_method' => 'Cash on Delivery',
            'created_at'     => $order->created_at,
        ];

        $pdf = Pdf::loadView('email.receipt-pdf', [
            'order'    => $orderObj,
            'cart'     => $cart,
            'total'    => $total,
            'customer' => $customer,
        ]);

        return $pdf->download('receipt-' . $id . '.pdf');
    }
}