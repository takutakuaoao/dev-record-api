<?php

declare(strict_types=1);

namespace Tests\Unit\packages\Domain\Common\Validation;

use DevRecord\Domain\Common\Validation\Error\ValidateException;
use DevRecord\Domain\Common\Validation\Rule\MaxRule;
use DevRecord\Domain\Common\Validation\Rule\RequiredRule;
use DevRecord\Domain\Common\Validation\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function test_passes(): void
    {
        $originals = ['name' => 'テスト', 'slug' => ''];
        $rules     = ['name' => [new MaxRule(2)], 'slug' => [new RequiredRule]];

        $validator = new Validator($originals, $rules);
        $result    = $validator->passes();
        $errors    = $validator->getErrors();

        $this->assertFalse($result);
        $this->assertEquals('最大値が2を超えています。', $errors->getFirstMessage('name'));
        $this->assertEquals('必須項目です。', $errors->getFirstMessage('slug'));
    }

    public function test_validate(): void
    {
        $originals = ['name' => 'テスト', 'slug' => ''];
        $rules     = ['name' => [new MaxRule(2)], 'slug' => [new RequiredRule]];

        $validator = new Validator($originals, $rules);

        try {
            $validator->validate();
        } catch (ValidateException $e) {
            $errors = $e->errors();

            $this->assertEquals('最大値が2を超えています。', $errors->getFirstMessage('name'));
            $this->assertEquals('必須項目です。', $errors->getFirstMessage('slug'));

            return;
        }

        $this->assertTrue(false, 'not throw exception.');
    }
}
