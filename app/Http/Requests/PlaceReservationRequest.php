<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceReservationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'restaurant' => 'required|integer|exists:restaurants,id',
            'table' => 'required|integer|exists:tables,id',
            'date' => 'required',
            'contacts' => 'required|array|min:1',
            'start' => 'required|integer|lt:end',
            'end' => 'required|integer',
            'contacts.*.name' => 'required|string|min:3|max:100',
            'contacts.*.email' => 'required|email|min:3|max:100',
            'contacts.*.phone' => 'required|string|min:5|max:100',
            'contacts.*.surname' => 'required|string|min:3|max:100'
        ];
    }
}
