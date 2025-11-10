<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class NotificationHistoryItem
{
    public function __construct(
        public readonly string $id,
        public readonly string $method,
        public readonly string $method_human,
        public readonly string $type,
        public readonly string $sent_at,
        public readonly string $sent_at_human,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            method: $data['method'],
            method_human: $data['method_human'],
            type: $data['type'],
            sent_at: $data['sent_at'],
            sent_at_human: $data['sent_at_human'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'method' => $this->method,
            'method_human' => $this->method_human,
            'type' => $this->type,
            'sent_at' => $this->sent_at,
            'sent_at_human' => $this->sent_at_human,
        ];
    }
}
