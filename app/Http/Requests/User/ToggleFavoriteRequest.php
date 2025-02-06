<?php

namespace App\Http\Requests\User;

use App\Enums\MediaType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ToggleFavoriteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'media_id' => ['required', 'integer'],
            'media_type' => ['required', 'string', new Enum(MediaType::class)]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}