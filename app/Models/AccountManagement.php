<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountManagement extends Model
{
    use HasFactory;
    protected $table = 'account_managements';
    protected $fillable = [
        'account',
        'mac',
        'buyer_name',
        'phone',
        'initial_creation_date',
        'in_used',
        'expired',
        'email',
        'final_expiration_date',
        'password',
        'days_remaining_credits',
        'user_id',
        'status',
        'document_type_id',
        'document_number',
        'city_id',
        'address',
        'phone_code_id',
        'state_id',
        'mac',
        'control_income_date'

    ];

    /**
     * Get the user that owns the registeroperation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the city that owns the user.
    */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the document_type that owns the user.
     */
    public function document_type(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    /**
     * Get the phone_code that owns the user.
     */
    public function phone_code(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'phone_code_id');
    }

}
