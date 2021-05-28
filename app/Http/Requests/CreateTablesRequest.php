<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTablesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'table_size' => 'required|integer|min:1',
            'restaurant_id' => 'required|integer|exists:restaurants,id',
        ];
    }
}
