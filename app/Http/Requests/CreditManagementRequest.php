<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditManagementRequest extends FormRequest
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
    public static function rules(): array
    {
        return [
            'status_credit' => 'required',
            'monthly_points' => 'nullable|numeric|required_without:annual_points',
            'annual_points' => 'nullable|numeric|required_without:monthly_points',
        ];
    }
}
