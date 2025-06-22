<?php

namespace Application\Post\DTO;

class PostResponse {
    public function __construct(
        public int $id,
        public readonly string $title,
        public readonly string $content
    ) {}
}
