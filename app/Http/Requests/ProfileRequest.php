<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'id' => 'nullable|exists:user_infos,id',
            'name' => 'required',
            'gender' => 'required|in:male,female',
            'hobbies' => 'nullable|array',
            'hobbies.*' => 'nullable|string',
            'education' => 'nullable|array',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => isset($this->id) && ($this->id !== null && $this->id !== 'null') ? $this->id : null,
            'hobbies' => $this->hobbies ? json_decode($this->hobbies, true) : [],
            'education' => $this->education ? json_decode($this->education, true) : []
        ]);
    }

    /**
     * Throw a validation exception
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }
}
