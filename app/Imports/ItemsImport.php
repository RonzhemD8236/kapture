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
        if (!is_numeric($row['cost_price'] ?? null) || !is_numeric($row['sell_price'] ?? null)) {
            return null;
        }

        $item = Item::create([
            'title'       => $row['title'] ?? $row['product_name'] ?? 'Untitled',
            'description' => $row['description'] ?? $row['product_name'] ?? '',
            'category'    => $row['category'] ?? 'Uncategorized',
            'cost_price'  => $row['cost_price'],
            'sell_price'  => $row['sell_price'],
            'img_path'    => $row['image'] ?? $row['img_path'] ?? 'default.jpg',
        ]);

        $stock = new Stock();
        $stock->item_id  = $item->item_id;
        $stock->quantity = $row['quantity'] ?? $row['stock'] ?? 0;
        $stock->save();

        return $item;
    }
}