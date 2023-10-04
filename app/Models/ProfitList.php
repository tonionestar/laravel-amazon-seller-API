<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitList extends Model
{
    use HasFactory;

    public $table = 'profit_list_by_month';

    protected $fillable = [
        'user_id',
        'month',
        'position',
        'total_value_adjusted',
        'per_user_profit'
    ];
}
