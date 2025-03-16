<?php

namespace App\Http\Requests;

use App\Models\TeamUser;
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
            'players.*.position' => ['required', 'integer', 'max:200', 'distinct', Rule::exists('team_positions', 'id')],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return TeamUser::playersValidationMessages();
    }
}
