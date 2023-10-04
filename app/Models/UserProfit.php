<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfit extends Model
{
    use HasFactory;

    public $table = 'user_profits';

    protected $fillable = [
        // 'user_id',
        'date_range',
        'position',
        'profit_per_position',
        'total_profit',
        'cost_per_unit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
