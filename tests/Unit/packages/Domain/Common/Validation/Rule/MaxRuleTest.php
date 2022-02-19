<?php

declare(strict_types=1);

namespace Tests\Unit\packages\Domain\Common\Validation\Rule;

use DevRecord\Domain\Common\Validation\Rule\MaxRule;
use PHPUnit\Framework\TestCase;
use stdClass;

class MaxRuleTest extends TestCase
{
    /**
     * @dataProvider validateDataProvider
     * @param  mixed $data
     * @param  bool  $expect
     * @return void
     */
    public function test_is_pass($data, bool $expect): void
    {
        $rule = new MaxRule(2);

        $this->assertEquals($rule->isPass($data), $expect);
    }

    public function validateDataProvider(): array
    {
        return [
            ['あああ', false],
            ['aaa', false],
            ['ああ', true],
            ['aa', true],
            [3, false],
            [2, true],
            ['', true],
            [null, true],
            [['1', '2', '3'], false],
            [['1', '2'], true],
            [new stdClass(), false],
        ];
    }

    public function test_error_message(): void
    {
        $rule = new MaxRule(3);

        $this->assertEquals('最大値が3を超えています。', $rule->errorMessage());
    }
}
