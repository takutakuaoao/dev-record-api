<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Delete;

use DevRecord\Domain\Common\Id;
use PhpParser\Node\Name\FullyQualified;

final class CategoryDeleteRequest
{
    public function __construct(
        private string $deleteId,
    ) {
    }

    public function makeDeleteId(): Id
    {
        return new Id($this->deleteId);
    }
}
