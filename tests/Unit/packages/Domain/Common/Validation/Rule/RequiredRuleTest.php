<?php

declare(strict_types=1);

namespace Tests\Unit\packages\Domain\Common\Validation\Rule;

use DevRecord\Domain\Common\Validation\Rule\RequiredRule;
use PHPUnit\Framework\TestCase;
use stdClass;

class RequiredRuleTest extends TestCase
{
    /**
     * @dataProvider validateDataProvider
     * @param  mixed $data
     * @param  bool  $expect
     * @return void
     */
    public function test_is_pass($data, bool $expect): void
    {
        $rule = new RequiredRule;

        $this->assertEquals($rule->isPass($data), $expect);
    }

    public function validateDataProvider(): array
    {
        return [
            ['', false],
            [null, false],
            [0, true],
            [[], false],
            [[1], true],
            ['t', true],
            [new stdClass, true],
        ];
    }
}
