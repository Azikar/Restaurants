<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckIfCanAddMoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'restaurant' => 'required|integer|exists:restaurants,id',
            'table' => 'required|integer|exists:tables,id',
            'date' => 'required',
            'contact' => 'required|array',
            'start' => 'required|integer|lt:end',
            'end' => 'required|integer',
            'contact.name' => 'required|string|min:3|max:100',
            'contact.email' => 'required|email|min:3|max:100',
            'contact.phone' => 'required|string|min:5|max:100',
            'contact.surname' => 'required|string|min:3|max:100',
            'contactsCount' => 'required|integer|min:0'
        ];
    }
}
