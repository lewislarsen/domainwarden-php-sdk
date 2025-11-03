<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class DnsComponent
{
    public function __construct(
        public readonly bool $is_enabled,
        public readonly string $check_interval,
        public readonly string $check_status,
        public readonly string $latest_check_details,
        public readonly ?string $last_checked_at,
        public readonly ?string $next_check_at,
        public readonly ?string $last_manual_check_at,
        public readonly ?string $changes_detected_at,
        public readonly bool $has_changed_recently,
        public readonly bool $was_manually_checked_recently,
        public readonly array $enabled_records,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            is_enabled: $data['is_enabled'],
            check_interval: $data['check_interval'],
            check_status: $data['check_status'],
            latest_check_details: $data['latest_check_details'],
            last_checked_at: $data['last_checked_at'] ?? null,
            next_check_at: $data['next_check_at'] ?? null,
            last_manual_check_at: $data['last_manual_check_at'] ?? null,
            changes_detected_at: $data['changes_detected_at'] ?? null,
            has_changed_recently: $data['has_changed_recently'],
            was_manually_checked_recently: $data['was_manually_checked_recently'],
            enabled_records: $data['enabled_records'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'is_enabled' => $this->is_enabled,
            'check_interval' => $this->check_interval,
            'check_status' => $this->check_status,
            'latest_check_details' => $this->latest_check_details,
            'last_checked_at' => $this->last_checked_at,
            'next_check_at' => $this->next_check_at,
            'last_manual_check_at' => $this->last_manual_check_at,
            'changes_detected_at' => $this->changes_detected_at,
            'has_changed_recently' => $this->has_changed_recently,
            'was_manually_checked_recently' => $this->was_manually_checked_recently,
            'enabled_records' => $this->enabled_records,
        ];
    }
}