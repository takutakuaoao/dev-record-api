<?php

declare(strict_types=1);

namespace App\Http\Response;

final class SuccessResponse extends Response
{
    public function __construct(
        private array $returnData,
    ) {
    }

    protected function addingDataResponse(): array
    {
        return [
            'data' => $this->returnData,
        ];
    }

    protected function isSuccess(): bool
    {
        return true;
    }
}
