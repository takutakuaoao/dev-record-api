<?php

declare(strict_types=1);

namespace App\Http\Response;

final class ErrorResponse extends Response
{
    public function __construct(
        private int $status,
        private array $errorMessages,
    ) {
    }

    protected function addingDataResponse(): array
    {
        return [
            'status' => $this->status,
            'errors' => $this->errorMessages,
        ];
    }

    protected function isSuccess(): bool
    {
        return false;
    }
}
