<?php

namespace Shared\Queue;

use Infrastructure\Queue\Jobs\CompressMediaJob;

class QueueDispatcher
{
    public function dispatchCompressMedia(int $mediaId): void
    {
        CompressMediaJob::dispatch($mediaId);
    }
}
