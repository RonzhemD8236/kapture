<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $cameras = [
            ['title' => 'Canon EOS R50',           'category' => 'Mirrorless',    'cost' => 479.99,  'sell' => 599.99],
            ['title' => 'Sony Alpha A7 III',        'category' => 'Mirrorless',    'cost' => 1799.99, 'sell' => 2199.99],
            ['title' => 'Nikon Z50',                'category' => 'Mirrorless',    'cost' => 699.99,  'sell' => 859.99],
            ['title' => 'Fujifilm X-T5',            'category' => 'Mirrorless',    'cost' => 1299.99, 'sell' => 1599.99],
            ['title' => 'Sony ZV-E10',              'category' => 'Mirrorless',    'cost' => 549.99,  'sell' => 749.99],
            ['title' => 'GoPro Hero 11 Black',      'category' => 'Action Camera', 'cost' => 299.99,  'sell' => 399.99],
            ['title' => 'Canon PowerShot G7 X III', 'category' => 'Point & Shoot', 'cost' => 649.99,  'sell' => 829.99],
            ['title' => 'Sony RX100 VII',            'category' => 'Point & Shoot', 'cost' => 1149.99, 'sell' => 1299.99],
            ['title' => 'Panasonic Lumix GH6',      'category' => 'Mirrorless',    'cost' => 1699.99, 'sell' => 1999.99],
            ['title' => 'Nikon Z30',                'category' => 'Mirrorless',    'cost' => 599.99,  'sell' => 799.99],
        ];

        foreach ($cameras as $camera) {
            $existing = DB::table('item')->where('title', $camera['title'])->first();

            if ($existing) {
                DB::table('item')->where('item_id', $existing->item_id)->update([
                    'category'   => $camera['category'],
                    'cost_price' => $camera['cost'],
                    'sell_price' => $camera['sell'],
                    'updated_at' => now(),
                ]);
                $itemId = $existing->item_id;
            } else {
                $itemId = DB::table('item')->insertGetId([
                    'title'       => $camera['title'],
                    'category'    => $camera['category'],
                    'description' => $camera['title'], // placeholder, edit via admin
                    'cost_price'  => $camera['cost'],
                    'sell_price'  => $camera['sell'],
                    'img_path'    => 'default.jpg',
                    'images'      => null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            $stock = DB::table('stock')->where('item_id', $itemId)->first();

            if ($stock) {
                DB::table('stock')->where('item_id', $itemId)->update(['updated_at' => now()]);
            } else {
                DB::table('stock')->insert([
                    'item_id'       => $itemId,
                    'quantity'      => 20,
                    'reorder_level' => 10,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }
    }
}