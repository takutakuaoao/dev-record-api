<?php

declare(strict_types=1);

namespace App\Http\Response;

abstract class Response
{
    abstract protected function isSuccess(): bool;
    abstract protected function addingDataResponse(): array;

    public function toArray(): array
    {
        return array_merge(
            ['result' => $this->isSuccess()],
            $this->addingDataResponse(),
        );
    }
}
