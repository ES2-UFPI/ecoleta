<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollectPoints extends FormRequest
{
    public function response(array $errors)
    {
        return response()->json($errors, 422);
    }

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
            'region_id' => ['required', 'exists:regions,id'],
            'title' => ['required', 'min:1', 'max:255'],
            'latitude' => ['required', 'min:1', 'max:255'],
            'longitude' => ['required', 'min:1', 'max:255'],
        ];
    }
}
