<?php

declare(strict_types=1);

namespace DevRecord\Domain\Common\Validation\Rule;

use InvalidArgumentException;

/**
 * 指定した値より小さいことを判定するルール
 * 配列：配列の要素数
 * 数値：絶対値
 * 文字列：文字数
 *
 * null, 空文字の場合はtrue
 * オブジェクトの場合はfalse
 */
final class MaxRule implements Rule
{
    public function __construct(
        private int $maxLimit,
    ) {
        if ($maxLimit <= 0) {
            throw new InvalidArgumentException('$maxLimit must be over zero.');
        }
    }

    public function isPass($data): bool
    {
        if (is_object($data)) {
            return false;
        }

        if (in_array($data, ['', null])) {
            return true;
        }

        if (is_array($data)) {
            return count($data) <= $this->maxLimit;
        }

        if (is_numeric($data)) {
            return $data <= $this->maxLimit;
        }

        return mb_strlen($data) <= $this->maxLimit;
    }

    public function errorMessage(): string
    {
        return '最大値が' . $this->maxLimit . 'を超えています。';
    }
}
