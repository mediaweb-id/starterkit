<?php

namespace MediaWebId\Starterkit\Http\Requests\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdministratorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            // 'bod' => 'required',
            'password' => ['required', 'confirmed',
                            Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:admins'
            ],
        ];
    }
}
