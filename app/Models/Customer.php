<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer'; // tells Laravel to use 'customer' instead of 'customers'

    protected $fillable = [
        'title',
        'fname',
        'lname',
        'addressline',
        'town',
        'zipcode',
        'phone',
        'user_id',
    ];
}