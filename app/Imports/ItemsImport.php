<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!is_numeric($row['cost_price']) || !is_numeric($row['sell_price'])) {
            return null;
        }

        $item = Item::create([
            'description' => $row['product_name'],
            'cost_price'  => $row['cost_price'],
            'sell_price'  => $row['sell_price'],
            'img_path'    => $row['image'] ?? 'default.jpg',
        ]);

        $stock = new Stock();
        $stock->item_id  = $item->item_id;
        $stock->quantity = $row[4] ?? 0;
        $stock->save();

        return $item;
    }
}