<?php

namespace Application\Post\DTO;

class CreatePostDTO {
    public function __construct(
        public readonly string $title,
        public readonly string $content
    ) {}
}
