<?php

namespace  Shared\Media\DTO;

class UploadedMediaData {
    public function __construct(
        public readonly string $disk,
        public readonly string $filename,
        public readonly string $path,
        public readonly string $extension,
        public readonly string $size,
    ) {}
}
