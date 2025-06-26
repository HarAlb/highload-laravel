<?php

namespace Shared\Media\Service;

use Illuminate\Support\Facades\Log;
use Shared\Media\Contract\MediaCompressorInterface;
use Domain\Media\MediaRepositoryInterface;

class MediaCompressor implements MediaCompressorInterface
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepo,
        private iterable $strategies
    ) {}

    public function compress(int $mediaId): void
    {
        $media = $this->mediaRepo->find($mediaId);

        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($media)) {
                $strategy->compress($media);
                return;
            }
        }

        // Можно залогировать или выбросить исключение
        throw new \RuntimeException("No suitable compression strategy found.");
    }
}
