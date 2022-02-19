<?php

declare(strict_types=1);

namespace DevRecord\Domain\Common\Validation\Rule;

/**
 * 必須項目内に値が入っているかの判定。下記の場合に未入力と判定する
 * 空文字、null値、　空配列
 */
final class RequiredRule implements Rule
{
    public function isPass($data): bool
    {
        return !in_array($data, ['', null, []], true);
    }

    public function errorMessage(): string
    {
        return '必須項目です。';
    }
}
