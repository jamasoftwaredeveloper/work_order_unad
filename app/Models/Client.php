<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Tabla asociada al modelo
    protected $table = 'clients';

    // Asignación en masa
    protected $fillable = [
        'nit',
        'name',
        'address',
        'business_name',
    ];
}
