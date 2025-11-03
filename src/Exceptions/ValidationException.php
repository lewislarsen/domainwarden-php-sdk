<?php

namespace Domainwarden\Sdk\Exceptions;

class ValidationException extends DomainwardenException
{
    public function __construct(
        string $message = 'Validation failed.',
        public readonly array $errors = []
    ) {
        parent::__construct($message, 422);
    }

    /**
     * Get all validation errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get validation errors for a specific field.
     *
     * @param string $field
     * @return array
     */
    public function getErrorsForField(string $field): array
    {
        return $this->errors[$field] ?? [];
    }

    /**
     * Check if a specific field has errors.
     *
     * @param string $field
     * @return bool
     */
    public function hasErrorForField(string $field): bool
    {
        return isset($this->errors[$field]);
    }
}