<?php

namespace Shared\Media\Service;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Shared\Media\DTO\UploadedMediaData;
use function config;

class MediaService
{
    public function upload(UploadedFile $file, string $path): UploadedMediaData
    {
        $disk = config('filesystems.default', 'public'); // например, s3 или public

        $fileName = $file->getFilename();

        $fileName .= Str::random(4);

        $storedPath = Storage::disk($disk)->putFileAs($path, $file, $fileName . '.' . $file->getClientOriginalExtension());

        return new UploadedMediaData(
            disk: $disk,
            filename: $fileName,
            path: $storedPath,
            extension: $file->getClientOriginalExtension(),
            size: $file->getSize()
        );
    }

    public function storeRaw(string $contents, string $disk, string $path, string $filename): void
    {
        Storage::disk($disk)->put("{$path}/{$filename}", $contents, 'public');
    }
}
