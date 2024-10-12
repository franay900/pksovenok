<?php


namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'name' => 'required|string',
            'surname' => 'required|string',
            'patronymic' => 'required|string',
            'username' => 'required',
            'roles' => '',

        ];
    }
}
