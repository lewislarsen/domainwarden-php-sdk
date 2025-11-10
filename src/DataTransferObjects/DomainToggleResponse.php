<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class DomainToggleResponse
{
    public function __construct(
        public readonly string $message,
        public readonly array $domain,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            message: $data['message'],
            domain: $data['domain'],
        );
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'domain' => $this->domain,
        ];
    }
}
