<?php

namespace Shared\Media;

class MediaPathGenerator
{
    public function forPost(int $postId): string
    {
        return "posts/{$postId}";
    }
    // Add more context-based generators as needed for avatars
}
