<?php

namespace Shared\Media\DTO;

class MediaResponse {
    public function __construct(
        public readonly int $id,
        public readonly string $url,
        public readonly bool $is_video,
        public readonly ?MediaResponse $child = null,
    ) {}
}
