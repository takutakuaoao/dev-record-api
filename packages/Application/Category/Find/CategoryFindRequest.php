<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Find;

use DevRecord\Domain\Common\Id;

final class CategoryFindRequest
{
    public function __construct(
        private string $findId
    ) {
    }

    public function makeId(): Id
    {
        return new Id($this->findId);
    }
}
