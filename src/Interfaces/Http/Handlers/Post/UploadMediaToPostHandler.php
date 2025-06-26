<?php

namespace Interfaces\Http\Handlers\Post;

use Application\Post\DTO\UploadMediaToPostDTO;
use Application\Post\UploadMediaToPostService;
use Interfaces\Http\Requests\Post\UploadMediaRequest;
use Shared\Media\DTO\MediaResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadMediaToPostHandler
{
    public function __construct(
        private UploadMediaToPostService $service
    ) {
    }

    public function handle(UploadMediaRequest $request, int $postId): JsonResponse
    {
        $dto = new UploadMediaToPostDTO(
            postId: $postId,
            media: $request->file('media')
        );

        $media = $this->service->handle($dto);

        return new JsonResponse(
            new MediaResponse(
                $media->getId(),
                $media->getFilePath(),
                $media->isVideo()
            ), 201
        );
    }
}
