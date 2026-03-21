<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $primaryKey = 'review_id';
    protected $fillable = ['item_id', 'customer_id', 'order_id', 'rating', 'comment'];
}