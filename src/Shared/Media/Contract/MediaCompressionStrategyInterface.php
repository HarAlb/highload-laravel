<?php

namespace Shared\Media\Contract;

use Domain\Media\Media;

interface MediaCompressionStrategyInterface
{
    public function supports(Media $media): bool;

    public function compress(Media $media): void;
}
