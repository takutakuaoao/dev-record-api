<?php

namespace DevRecord\Infrastructure\Storage;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

final class LocalStorage implements StorageInterface
{
    private Filesystem $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('upload');
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

        return config('app.url') . '/' . 'storage/upload' . '/' . $fileName;
    }
}
