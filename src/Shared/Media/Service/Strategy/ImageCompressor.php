<?php

namespace Shared\Media\Service\Strategy;

use Domain\Media\Media;
use Domain\Media\MediaRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Shared\Media\Contract\MediaCompressionStrategyInterface;
use Shared\Media\Service\MediaService;

class ImageCompressor implements MediaCompressionStrategyInterface
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepo,
        private MediaService $mediaService
    ) {}

    public function supports(Media $media): bool
    {
        return $media->isImage();
    }

    public function compress(Media $media): void
    {
        $originalPath = "{$media->getPath()}/{$media->getFilename()}.{$media->getExtension()}";
        $contents = Storage::disk($media->getDisk())->get($originalPath);

        $encoded = Image::make($contents)->encode('webp', 1);

        $newFilename = $media->getFilename() . '_blurred';
        $newExtension = 'webp';

        $this->mediaService->storeRaw(
            contents: $encoded,
            disk: $media->getDisk(),
            path: $media->getPath(),
            filename: "$newFilename.$newExtension"
        );

        $child = $media->createChild(
            filename: $newFilename,
            extension: $newExtension,
            size: strlen($encoded),
            isComplied: true
        );

        $this->mediaRepo->save($child);
        $media->markAsComplied();
        $this->mediaRepo->save($media);
    }
}
