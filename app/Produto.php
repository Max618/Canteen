<?php

namespace Canteen;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'name', 'amount', 'price', 'type',
    ];
}
