<?php

namespace Application\Post;

use Application\Post\DTO\CreatePostDTO;
use Domain\Post\Post;
use Domain\Post\PostRepositoryInterface;

class CreatePostService
{
    public function __construct(private PostRepositoryInterface $repo) {}

    public function execute(CreatePostDTO $createPostDTO): Post
    {
        $post = new Post($createPostDTO->title, $createPostDTO->content);
        return $this->repo->save($post);
    }
}
