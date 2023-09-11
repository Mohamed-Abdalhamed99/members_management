<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function courses()
    {
        $this->belongsToMany(Course::class , 'order_courses' , 'order_id');
    }

    public function products()
    {
        $this->belongsToMany(Product::class , 'order_products' , 'order_id');
    }

    public function transactions()
    {
        $this->belongsToMany(Product::class , 'order_transactions' , 'order_id');
    }
}
