<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class ResellerManagementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public static function rules($userId): array
    {
        $baseRules = [
            'email'            => ['required', 'email', 'string', 'max:255'],
            'password'         => ['required', 'min:8'],
            'status_value'           => ['required'],
            'observation'           => ['nullable']
        ];

        if ($userId) {
            $baseRules['email'][] = 'unique:users,email,' . $userId;
            $baseRules['status_value'][] = ['required'];
        } else {
            $baseRules['email'][] = 'unique:users,email';
        }

        return $baseRules;
    }
}
