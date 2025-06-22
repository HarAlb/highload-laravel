<?php

namespace Interfaces\Http\Requests\Post;

use Application\Post\DTO\CreatePostDTO;
use OpenApi\Attributes as OAT;
use Shared\Requests\ApiRequest;

#[OAT\Schema(
    schema: 'CreatePostRequest',
    required: ['title', 'content'],
    type: 'object'
)]
class CreatePostRequest extends ApiRequest
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
            'title' => 'required|string|max:255',
            'content' => 'required|string'
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
