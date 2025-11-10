<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class SslComponent
{
    public function __construct(
        public readonly bool $is_enabled,
        public readonly ?string $issuer,
        public readonly ?string $organization,
        public readonly ?string $expires_at,
        public readonly ?string $last_checked_at,
        public readonly ?string $last_found_invalid_at,
        public readonly ?string $last_considered_valid_at,
        public readonly bool $has_changed_recently,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            is_enabled: $data['is_enabled'],
            issuer: $data['issuer'] ?? null,
            organization: $data['organization'] ?? null,
            expires_at: $data['expires_at'] ?? null,
            last_checked_at: $data['last_checked_at'] ?? null,
            last_found_invalid_at: $data['last_found_invalid_at'] ?? null,
            last_considered_valid_at: $data['last_considered_valid_at'] ?? null,
            has_changed_recently: $data['has_changed_recently'],
        );
    }

    public function toArray(): array
    {
        return [
            'is_enabled' => $this->is_enabled,
            'issuer' => $this->issuer,
            'organization' => $this->organization,
            'expires_at' => $this->expires_at,
            'last_checked_at' => $this->last_checked_at,
            'last_found_invalid_at' => $this->last_found_invalid_at,
            'last_considered_valid_at' => $this->last_considered_valid_at,
            'has_changed_recently' => $this->has_changed_recently,
        ];
    }
}
