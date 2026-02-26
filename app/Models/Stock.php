<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
    protected $primaryKey = 'stock_id';

    protected $fillable = [
        'item_id',
        'quantity',
        'reorder_level',
    ];
}