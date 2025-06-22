<?php

namespace Interfaces\Http\Requests\Post;

use Application\Post\DTO\CreatePostDTO;
use Shared\Requests\ApiRequest;

class UploadMediaRequest extends ApiRequest
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
            'file' => 'required|string|max:255',
        ];
    }

    public function toDto(): CreatePostDTO
    {
        return new CreatePostDTO(
            $this->input('title'),
            $this->input('content')
        );
    }
}
