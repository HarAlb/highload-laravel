<?php

namespace Interfaces\Http\Handlers\Post;

use Application\Post\GetPostListService;
use Domain\Post\Post;
use Illuminate\Http\Request;
use Interfaces\Http\Requests\Post\CreatePostRequest;
use Shared\Responses\PaginatedJsonResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetPostListHandler
{
    public function __construct(private GetPostListService $service) {}

    public function handle(Request $request): JsonResponse
    {
        $page = max((int)$request->query('page', 1), 1);
        $perPage = max((int)$request->query('perPage', 10), 1);

        $posts = $this->service->execute($page, $perPage);

        return PaginatedJsonResponse::from(
            $posts->items,
            $posts->total,
            $posts->currentPage,
            $posts->perPage,
            fn(Post $post) => [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $post->getUpdatedAt()?->format('Y-m-d H:i:s'),
            ]
        );
    }
}
