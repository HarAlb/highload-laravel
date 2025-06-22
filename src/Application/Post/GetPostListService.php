<?php

namespace Application\Post;

use Domain\Post\PostRepositoryInterface;
use Application\Post\DTO\PaginatedPostList;

class GetPostListService
{
    public function __construct(private PostRepositoryInterface $repository) {}

    public function execute(int $page = 1, int $perPage = 10): PaginatedPostList
    {
        $items = $this->repository->paginate($page, $perPage);
        $total = $this->repository->countAll();

        return new PaginatedPostList($items, $total, $page, $perPage);
    }
}
