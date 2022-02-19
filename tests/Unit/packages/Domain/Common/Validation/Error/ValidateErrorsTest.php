<?php

declare(strict_types=1);

namespace Tests\Unit\packages\Domain\Common\Validation\Error;

use DevRecord\Domain\Common\Validation\Error\ValidateErrors;
use PHPUnit\Framework\TestCase;

class ValidateErrorsTest extends TestCase
{
    public function test_get_first_message(): void
    {
        $errors = new ValidateErrors([
            'errorName' => ['first error', 'seconds error'],
        ]);

        $this->assertEquals('first error', $errors->getFirstMessage('errorName'));
    }

    public function test_return_null_when_not_exists_first_message(): void
    {
        $errors = new ValidateErrors([
            'errorName' => ['first error', 'seconds error'],
        ]);

        $this->assertEquals(null, $errors->getFirstMessage('notExists'));
    }

    public function test_get_first_message_when_message_text(): void
    {
        $errors = new ValidateErrors([
            'errorName' => 'text message',
        ]);

        $this->assertEquals('text message', $errors->getFirstMessage('errorName'));
    }

    public function test_get_all_messages(): void
    {
        $errors = new ValidateErrors([
            'errorName' => ['first message', 'seconds message'],
        ]);

        $this->assertEquals(['first message', 'seconds message'], $errors->allMessages('errorName'));
    }

    public function test_return_empty_array_when_not_exists_get_all_messages(): void
    {
        $errors = new ValidateErrors([
            'errorName' => ['first message', 'seconds message'],
        ]);

        $this->assertEquals([], $errors->allMessages('notError'));
    }

    public function test_get_all_messages_when_target_error_message_is_string(): void
    {
        $errors = new ValidateErrors([
            'errorName' => 'message',
        ]);

        $this->assertEquals(['message'], $errors->allMessages('errorName'));
    }

    // public function test_add_error(): void
    // {
    //     $errors = new ValidateErrors([
    //         'errorName' => ['first error', 'seconds error'],
    //     ]);

    //     $errors = $errors->addError('errorName', 'third error')
    // }
}
