<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsServices extends Model
{
    //
    protected $table = 'ProductsServices';
    protected $fillable = [
        'Name',
        'Description',
        'Price',
        'Stock',
        'EntryDate'
    ];
}
