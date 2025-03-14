<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeamRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:200', Rule::unique('teams')->ignore($this->team)],
            'players' => ['required', 'array', 'min:3', 'max:10'],
            'players.*.id' => ['required', 'exists:users,id', 'integer', 'distinct'],
            'players.*.position' => ['required', 'string', 'max:200', 'distinct'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'players.*.id.required' => __('This player must be selected.'),
            'players.*.id.exists' => __('The selected player is invalid.'),
            'players.*.id.distinct' => __('Player cannot be selected twice.'),
            'players.*.position.required' => __('Player position is required.'),
            'players.*.position.distinct' => __('Player positions must be unique.'),
        ];
    }
}
