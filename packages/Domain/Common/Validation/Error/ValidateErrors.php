<?php

declare(strict_types=1);

namespace DevRecord\Domain\Common\Validation\Error;

final class ValidateErrors
{
    /**
     * @param array $messages
     */
    public function __construct(
        private array $messages
    ) {
    }

    public function getFirstMessage(string $errorItemName): ?string
    {
        if (!$this->existsError($errorItemName)) {
            return null;
        }

        if (is_array($this->messages[$errorItemName])) {
            return $this->messages[$errorItemName][0];
        }

        return $this->messages[$errorItemName];
    }

    public function allMessages(string $errorItemName): array
    {
        if (!$this->existsError($errorItemName)) {
            return [];
        }

        if (is_string($this->messages[$errorItemName])) {
            return [$this->messages[$errorItemName]];
        }

        return $this->messages[$errorItemName];
    }

    public function addError(string $key, string $message): self
    {
        $errors         = $this->messages;
        $errors[$key][] = $message;

        return new self($errors);
    }

    public function failed(): bool
    {
        return $this->messages !== [];
    }

    private function existsError(string $errorItemName): bool
    {
        return array_key_exists($errorItemName, $this->messages);
    }
}
