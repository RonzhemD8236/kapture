<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

        // Send confirmation email
        Mail::to(Auth::user()->email)
            ->send(new OrderConfirmation(
                (object)['order_id' => $orderId],
                $cart,
                $total
            ));

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Order #' . $orderId . ' placed successfully!');
    }
}