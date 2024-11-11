<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountManagementRequest extends FormRequest
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
     * @return array<string',' \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public static function rules($account_management_id = null): array
    {
        if ($account_management_id) {
            return  [
                'buyer_name' => ['string', 'max:150'],
                'phone' => ['string','max:50'],
                'email' => ['string','email', 'max:150'],
                'observation' => ['string'],
            ];
        }
        return  [
            'credit_package_value'     => ['required', 'string'],
            'amount_of_allocated_credits' => ['required', 'integer', 'min:1'],
            'number_of_accounts' => ['required', 'integer', 'min:1'],
        ];
    }
}
