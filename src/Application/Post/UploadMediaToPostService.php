<?php

namespace Application\Post;

use Application\Post\DTO\UploadMediaToPostDTO;
use Domain\Media\Media;
use Domain\Media\MediaRepositoryInterface;
use Domain\Post\PostRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Shared\Enums\MediableType;
use Shared\Media\MediaPathGenerator;
use Shared\Media\Service\MediaService;
use Shared\Queue\QueueDispatcher;

class UploadMediaToPostService
{
    public function __construct(
        private PostRepositoryInterface $postRepo,
        private MediaRepositoryInterface $mediaRepo,
        private MediaPathGenerator $mediaPathGenerator,
        private MediaService $mediaService,
        private QueueDispatcher $dispatcher,
    ) {}

    public function handle(UploadMediaToPostDTO $dto): Media
    {
        DB::beginTransaction();
        $post = $this->postRepo->findById($dto->postId, 2);

        $path = $this->mediaPathGenerator->forPost($dto->postId);

        $mediasData = $this->mediaRepo->findByMediable(
            MediableType::Post->value,
            $post->getId()
        );

        foreach ($mediasData as $media){
            $post->addMedia($media);
        }

        $lastIndex = $post->getLastMediaPosition();

        $uploadMediaData = $this->mediaService->upload($dto->media, $path);

        $media = new Media(
            mediableType: MediableType::Post->value,
            mediableId: $post->getId(),
            parentId: null,
            disk: $uploadMediaData->disk,
            filename: $uploadMediaData->filename,
            path: $path,
            extension: $uploadMediaData->extension,
            size: $uploadMediaData->size,
            position: $lastIndex,
        );

        $newMedia = $this->mediaRepo->save(
            $media
        );

        $this->dispatcher->dispatchCompressMedia($media->getId());

        return $newMedia;
    }
}
