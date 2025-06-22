<?php

namespace Interfaces\Http\Handlers\Post;

use Application\Post\CreatePostService;
use Application\Post\DTO\PostResponse;
use Interfaces\Http\Requests\Post\CreatePostRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreatePostHandler
{
    public function __construct(private CreatePostService $service) {}

    public function handle(CreatePostRequest $request): JsonResponse
    {
        $post = $this->service->execute($request->toDto());

        return new JsonResponse(new PostResponse($post->getId(), $post->getTitle(), $post->getContent()), 201);
    }
}
