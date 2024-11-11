<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    // Tabla asociada al modelo
    protected $table = 'work_orders';

    // Asignación en masa
    protected $fillable = [
        'order_number',
        'client_id',
        'city_id',
        'address',
        'internal_code',
        'description_equipment',
        'brand',
        'model',
        'magnitude',
        'series',
        'class',
        'resolution',
        'measuring_rangeity',
        'type_of_request',
        'person_requesting_id',
        'means_of_application',
        'date_of_request',
        'reception_number',
        'date_of_reception'
    ];

    // Relaciones

    /**
     * Relación con el modelo Client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relación con el modelo City.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relación con el modelo User para la persona que realiza la solicitud.
     */
    public function personRequesting()
    {
        return $this->belongsTo(User::class, 'person_requesting_id');
    }
    public function actividades()
    {
        return $this->hasMany(Activity::class);
    }
}
