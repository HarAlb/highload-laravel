<?php

namespace Infrastructure\Queue\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Shared\Media\Contract\MediaCompressorInterface;

class CompressMediaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private int $mediaId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(MediaCompressorInterface $compressor): void
    {
        $compressor->compress($this->mediaId);
    }
}
