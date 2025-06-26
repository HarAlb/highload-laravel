<?php

namespace Application\Post;

use Domain\Media\Media;
use Domain\Media\MediaRepositoryInterface;
use Domain\Post\Post;
use Domain\Post\PostRepositoryInterface;
use Application\Post\DTO\PaginatedPostList;
use Shared\Enums\MediableType;

class GetPostListService
{
    public function __construct(private PostRepositoryInterface $repository, private MediaRepositoryInterface $mediaRepository) {}

    public function execute(int $page = 1, int $perPage = 10): PaginatedPostList
    {
        $items = $this->repository->paginate($page, $perPage);
        $total = $this->repository->countAll();

        $postIds = array_map(fn(Post $post) => $post->getId(), $items);

        $medias = $this->mediaRepository->findByMediables(MediableType::Post->value, $postIds);

        $mediaIds = array_map(fn(Media $media) => $media->getId(), $medias);

        $children = $this->mediaRepository->findChildrenByParentIds($mediaIds);

        $groupedChildren = [];
        foreach ($children as $child) {
            $groupedChildren[$child->getParentId()][] = $child;
        }
        $groupedMedias = [];
        foreach ($medias as $media) {
            foreach ($groupedChildren[$media->getId()] ?? [] as $child){
                $media->addChild($child);
            }

            $groupedMedias[$media->getMediableId()][] = $media;
        }

        foreach ($items as $post) {
            foreach ($groupedMedias[$post->getId()] ?? [] as $media){
                $post->addMedia($media);
            }
        }

        return new PaginatedPostList($items, $total, $page, $perPage);
    }
}
