<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class PaginationLinks
{
    public function __construct(
        public readonly ?string $first,
        public readonly ?string $last,
        public readonly ?string $prev,
        public readonly ?string $next,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            first: $data['first'] ?? null,
            last: $data['last'] ?? null,
            prev: $data['prev'] ?? null,
            next: $data['next'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'first' => $this->first,
            'last' => $this->last,
            'prev' => $this->prev,
            'next' => $this->next,
        ];
    }
}