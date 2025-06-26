<?php

namespace Shared\Media\Contract;

interface MediaCompressorInterface
{
    public function compress(int $mediaId): void;
}
