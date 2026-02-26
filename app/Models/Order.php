<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'customer_id',
        'total_amount',
        'status',
        'order_date',
    ];
}