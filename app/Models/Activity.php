<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    // Tabla asociada al modelo
    protected $table = 'activities';

    // Asignación en masa
    protected $fillable = [
        'work_order_id',
        'description_activities',
        'user_responsible_activities',
        'date_realization_activities'
    ];

    // Relación con el modelo WorkOrder
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
