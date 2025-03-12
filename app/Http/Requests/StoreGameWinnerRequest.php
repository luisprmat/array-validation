<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameWinnerRequest extends FormRequest
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
        $gamePlayersCount = $this->route('game')->users->count();

        return [
            'players' => ['required', 'array', 'min:'.$gamePlayersCount],
            'players.*' => ['required', 'integer', 'distinct', 'min:1', 'max:'.$gamePlayersCount],
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
            'players.*.required' => __('Please select a place for each player.'),
            'players.*.distinct' => __('Please select a different place for each player.'),
        ];
    }
}
