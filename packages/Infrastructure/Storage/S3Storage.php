<?php

declare(strict_types=1);

namespace DevRecord\Infrastructure\Storage;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

final class S3Storage implements StorageInterface
{
    private Filesystem $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('s3');
    }

    public function upload(string $fileName, string $content): void
    {
        $this->storage->put($fileName, $content, 'public');
    }

    public function exists(string $fileName): bool
    {
        return $this->storage->exists($fileName);
    }

    public function url(string $fileName): ?string
    {
        if (!$this->exists($fileName)) {
            return null;
        }

        return $this->storage->url($fileName);
    }
}
