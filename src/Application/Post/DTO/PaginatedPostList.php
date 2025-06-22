<?php

namespace Application\Post\DTO;

class PaginatedPostList
{
    public function __construct(
        public array $items,
        public int $total,
        public int $currentPage,
        public int $perPage
    ) {}
}
