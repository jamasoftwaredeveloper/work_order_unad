<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditManagement extends Model
{
    use HasFactory;
    protected $table = 'credit_managements';

    protected $fillable = [
        'monthly_points_available',
        'monthly_accumulated_points',
        'annual_points_available',
        'annual_accumulated_points'
    ];
}
