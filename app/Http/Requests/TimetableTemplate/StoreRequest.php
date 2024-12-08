<?php

namespace App\Http\Requests\TimetableTemplate;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'load_id' => 'required|exists:loads,id',
            'day' => 'required',
            'number' => 'required',
            'timetable_id' => 'required',
            'group_id' => 'required|exists:groups,id',
        ];
    }
}
