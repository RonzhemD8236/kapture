<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Item;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            [
                'customer_id' => 1,
                'status'      => 'completed',
                'items'       => [
                    ['item_id' => 1, 'quantity' => 2],
                    ['item_id' => 3, 'quantity' => 1],
                ],
            ],
            [
                'customer_id' => 2,
                'status'      => 'pending',
                'items'       => [
                    ['item_id' => 2, 'quantity' => 1],
                ],
            ],
            [
                'customer_id' => 3,
                'status'      => 'processing',
                'items'       => [
                    ['item_id' => 4, 'quantity' => 3],
                    ['item_id' => 5, 'quantity' => 1],
                ],
            ],
            [
                'customer_id' => 4,
                'status'      => 'cancelled',
                'items'       => [
                    ['item_id' => 6, 'quantity' => 1],
                    ['item_id' => 7, 'quantity' => 2],
                ],
            ],
            [
                'customer_id' => 5,
                'status'      => 'completed',
                'items'       => [
                    ['item_id' => 8,  'quantity' => 1],
                    ['item_id' => 9,  'quantity' => 1],
                    ['item_id' => 10, 'quantity' => 2],
                ],
            ],
        ];

        foreach ($orders as $orderData) {
            $total = 0;

            foreach ($orderData['items'] as $orderItem) {
                $item  = Item::find($orderItem['item_id']);
                $total += $item->sell_price * $orderItem['quantity'];
            }

            $order               = new Order();
            $order->customer_id  = $orderData['customer_id'];
            $order->total_amount = $total;
            $order->status       = $orderData['status'];
            $order->save();

            foreach ($orderData['items'] as $orderItem) {
                $item     = Item::find($orderItem['item_id']);
                $subtotal = $item->sell_price * $orderItem['quantity'];

                DB::table('order_item')->insert([
                    'order_id'   => $order->order_id,
                    'item_id'    => $item->item_id,
                    'quantity'   => $orderItem['quantity'],
                    'price'      => $item->sell_price,
                    'subtotal'   => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}