<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class WhoisChange
{
    public function __construct(
        public readonly string $id,
        public readonly int $domain_id,
        public readonly string $field_changed,
        public readonly string $old_value,
        public readonly string $new_value,
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
            old_value: $data['old_value'],
            new_value: $data['new_value'],
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
            'old_value' => $this->old_value,
            'new_value' => $this->new_value,
            'identifier' => $this->identifier,
            'created_at' => $this->created_at,
            'created_at_human' => $this->created_at_human,
        ];
    }
}
