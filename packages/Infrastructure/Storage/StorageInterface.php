<?php

declare(strict_types=1);

namespace DevRecord\Infrastructure\Storage;

interface StorageInterface
{
    public function upload(string $fileName, string $content): void;
    public function url(string $fileName): ?string;
    public function exists(string $fileName): bool;
}
