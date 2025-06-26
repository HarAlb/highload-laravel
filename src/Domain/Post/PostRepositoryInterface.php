<?php

namespace Domain\Post;

interface PostRepositoryInterface
{
    public function save(Post $post): Post;

    public function findById(int $id): ?Post;

    public function findAll(int $limit, int $offset): array;

    public function paginate(int $page, int $perPage): array;

    public function countAll(): int;

    public function delete(Post $post): void;
}
