<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Stock;
use Illuminate\Support\Facades\Log;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $cameras = [
            ['name' => 'Canon EOS R50',            'cost' => 479.99,  'sell' => 599.99],
            ['name' => 'Sony Alpha A7 III',         'cost' => 1799.99, 'sell' => 2199.99],
            ['name' => 'Nikon Z50',                 'cost' => 699.99,  'sell' => 859.99],
            ['name' => 'Fujifilm X-T5',             'cost' => 1299.99, 'sell' => 1599.99],
            ['name' => 'Sony ZV-E10',               'cost' => 549.99,  'sell' => 749.99],
            ['name' => 'GoPro Hero 11 Black',       'cost' => 299.99,  'sell' => 399.99],
            ['name' => 'Canon PowerShot G7 X III',  'cost' => 649.99,  'sell' => 829.99],
            ['name' => 'Sony RX100 VII',             'cost' => 1149.99, 'sell' => 1299.99],
            ['name' => 'Panasonic Lumix GH6',       'cost' => 1699.99, 'sell' => 1999.99],
            ['name' => 'Nikon Z30',                 'cost' => 599.99,  'sell' => 799.99],
        ];

        foreach ($cameras as $camera) {
            $item = new Item();
            $item->description = $camera['name'];
            $item->cost_price   = $camera['cost'];
            $item->sell_price   = $camera['sell'];
            $item->img_path     = 'default.jpg';
            $item->save();

            Log::info("item id", ["item id" => $item->item_id]);

            $stock = new Stock();
            $stock->item_id       = $item->item_id;
            $stock->quantity      = 20;
            $stock->reorder_level = 10;
            $stock->save();
        }
    }
}