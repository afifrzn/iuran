<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
    'name',
    'with_meal',
    'amount',
    'payment_method',
    'paid'
];
}
