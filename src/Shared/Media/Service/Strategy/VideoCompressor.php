<?php
namespace Shared\Media\Service\Strategy;

use Shared\Media\Contract\MediaCompressionStrategyInterface;
use Domain\Media\Media;
use Illuminate\Support\Facades\Storage;
use Domain\Media\MediaRepositoryInterface;

class VideoCompressor implements MediaCompressionStrategyInterface
{
    public function __construct() {}

    public function supports(Media $media): bool
    {
        return $media->isVideo();
    }

    public function compress(Media $media): void
    {
        // Will be use FFMPEG
    }
}
