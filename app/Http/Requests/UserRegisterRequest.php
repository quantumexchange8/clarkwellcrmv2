<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

//    public function messages()
//    {
//        return [
//
//        ];
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'string', 'max:15', 'confirmed',
                Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
            'phone' => 'required|string|unique:users,contact_number',
            'address' => 'string|required|max:255',
            'country' => 'required|string',
            'referral' => 'nullable|exists:users,referral_id'
        ];
    }
}
