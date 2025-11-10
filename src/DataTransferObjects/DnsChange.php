<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class DnsChange
{
    public function __construct(
        public readonly string $id,
        public readonly int $domain_id,
        public readonly string $field_changed,
        public readonly string $field_changed_human,
        public readonly string $old_value,
        public readonly string $new_value,
        public readonly string $old_value_formatted,
        public readonly string $new_value_formatted,
        public readonly string $change_summary,
        public readonly string $diff,
        public readonly string $identifier,
        public readonly string $created_at,
        public readonly string $created_at_human,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            domain_id: $data['domain_id'],
            field_changed: $data['field_changed'],
            field_changed_human: $data['field_changed_human'],
            old_value: $data['old_value'],
            new_value: $data['new_value'],
            old_value_formatted: $data['old_value_formatted'],
            new_value_formatted: $data['new_value_formatted'],
            change_summary: $data['change_summary'],
            diff: $data['diff'],
            identifier: $data['identifier'],
            created_at: $data['created_at'],
            created_at_human: $data['created_at_human'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'domain_id' => $this->domain_id,
            'field_changed' => $this->field_changed,
            'field_changed_human' => $this->field_changed_human,
            'old_value' => $this->old_value,
            'new_value' => $this->new_value,
            'old_value_formatted' => $this->old_value_formatted,
            'new_value_formatted' => $this->new_value_formatted,
            'change_summary' => $this->change_summary,
            'diff' => $this->diff,
            'identifier' => $this->identifier,
            'created_at' => $this->created_at,
            'created_at_human' => $this->created_at_human,
        ];
    }
}