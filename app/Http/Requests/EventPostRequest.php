<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'site' => 'required',
            'date' => 'required|date',
            'available_places' => 'nullable|integer',
            'event_type_id' => 'required|exists:event_types,id',
        ];
    }
}
