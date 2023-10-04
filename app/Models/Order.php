<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_status',
        'order_date',
        'order_time',
        'order_id',
        'product_name',
        'product_link',
        'product_asin',
        'sku',
        'quantity',
        'item_price',
        'item_total',
        'amazon_fee',
        'shipping_fee',
        'warehouse_fee',
        'profit',
        'shipping_carrier',
        'cost_per_unit'
    ];
}
