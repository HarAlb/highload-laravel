<?php

namespace Application\Post\DTO;

use Illuminate\Http\UploadedFile;

class UploadMediaToPostDTO {
    public function __construct(
        public readonly int $postId,
        public readonly UploadedFile $media
    ) {}
}
