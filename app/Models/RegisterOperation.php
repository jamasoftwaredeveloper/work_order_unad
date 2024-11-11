<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegisterOperation extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'observation', 'result', 'status', 'user_id'];

        /**
     * Get the user that owns the registeroperation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
