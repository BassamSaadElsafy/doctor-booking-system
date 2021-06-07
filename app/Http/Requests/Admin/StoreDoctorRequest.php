<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'name_en'  => 'required',
            'name_ar'  => 'required',
            'email'    => ['required', 'email', 'unique:doctors'],
            'password' => ['required', 'min:8'],
            'deg_id'   => 'required',
            'spec_id'  => 'required',
            'image'    => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }
}