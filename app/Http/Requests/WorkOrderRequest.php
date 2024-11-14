<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkOrderRequest extends FormRequest
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
    public static function rules($wordOrderId = null): array
    {

        if ($wordOrderId) {
            return [
                'client_id'              => 'exists:clients,id', // Asegúrate de que el client_id exista en la tabla clients
                'city_id'                => 'exists:cities,id', // Asegúrate de que el city_id exista en la tabla cities
                'address'                => 'string|max:255',
                'internal_code'          => 'string|max:255',
                'description_equipment'  => 'string|max:255',
                'brand'                  => 'string|max:255',
                'model'                  => 'string|max:255',
                'magnitude'              => 'string|max:255',
                'series'                 => 'string|max:255',
                'class'                  => 'string|max:255',
                'resolution'             => 'string|max:255',
                'measuring_rangeity'     => 'string|max:255',
                'type_of_request'        => 'string|max:255',
                'person_requesting_id'   => 'exists:users,id', // Asegúrate de que person_requesting_id exista en la tabla users
                'means_of_application'   => 'string|max:255',
                'date_of_request'        => 'date',
                'reception_number'       => 'string|max:255',
                'date_of_reception'      => 'date',
                'receiving_authorizing'  => 'string|max:255',
            ];
        } else {

            return [
                'client_id'              => 'required|exists:clients,id', // Asegúrate de que el client_id exista en la tabla clients
                'city_id'                => 'required|exists:cities,id', // Asegúrate de que el city_id exista en la tabla cities
                'address'                => 'required|string|max:255',
                'internal_code'          => 'required|string|max:255',
                'description_equipment'  => 'required|string|max:255',
                'brand'                  => 'required|string|max:255',
                'model'                  => 'required|string|max:255',
                'magnitude'              => 'required|string|max:255',
                'series'                 => 'required|string|max:255',
                'class'                  => 'required|string|max:255',
                'resolution'             => 'required|string|max:255',
                'measuring_rangeity'     => 'required|string|max:255',
                'type_of_request'        => 'required|string|max:255',
                'person_requesting_id'   => 'required|exists:users,id', // Asegúrate de que person_requesting_id exista en la tabla users
                'means_of_application'   => 'required|string|max:255',
                'date_of_request'        => 'required|date',
                'reception_number'       => 'required|string|max:255',
                'date_of_reception'      => 'required|date',
                'receiving_authorizing'  => 'required|string|max:255',
            ];
        }
    }

    public function messages()
    {
        return [
            'client_id.required'              => 'El cliente es obligatorio.',
            'city_id.required'                => 'La ciudad es obligatoria.',
            'address.required'                => 'La dirección es obligatoria.',
            'internal_code.required'          => 'El código interno es obligatorio.',
            'description_equipment.required'  => 'La descripción del equipo es obligatoria.',
            'brand.required'                  => 'La marca es obligatoria.',
            'magnitude.required'              => 'La magnitud es obligatoria.',
            'series.required'                 => 'La serie es obligatoria.',
            'class.required'                  => 'La clase es obligatoria.',
            'resolution.required'             => 'La resolución es obligatoria.',
            'measuring_rangeity.required'     => 'El rango de medida es obligatorio.',
            'type_of_request.required'        => 'El tipo de solicitud es obligatorio.',
            'person_requesting_id.required'   => 'El ID de la persona solicitante es obligatorio.',
            'means_of_application.required'   => 'El medio de aplicación es obligatorio.',
            'date_of_request.required'        => 'La fecha de la solicitud es obligatoria.',
            'reception_number.required'       => 'El número de recepción es obligatorio.',
            'date_of_reception.required'      => 'La fecha de recepción es obligatoria.',
            'receiving_authorizing.required'  => 'El autorizado para la recepción es obligatorio.',
        ];
    }
}
