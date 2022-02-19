<?php

declare(strict_types=1);

namespace Tests\Feature\Rule;

use App\Rules\NotArrayRule;
use Tests\TestCase;

class NotArrayRuleTest extends TestCase
{
    public function test_配列の場合にfalseを返す(): void
    {
        $rule = new NotArrayRule();
        $this->assertFalse($rule->passes('attribute', ['test']));
    }

    /**
     * @dataProvider notArrayValueDataProvider
     */
    public function test_配列以外の場合にtrueを返す($value): void
    {
        $rule = new NotArrayRule();

        $this->assertTrue($rule->passes('attribute', $value));
    }

    public function notArrayValueDataProvider(): array
    {
        return [
            ['string'], [10], [''], [0], [true], [false],
        ];
    }
}
