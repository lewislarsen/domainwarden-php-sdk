<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class ActivityLogItem
{
    public function __construct(
        public readonly string $id,
        public readonly int $domain_id,
        public readonly string $domain_label,
        public readonly string $domain_url,
        public readonly string $domain_favicon_url,
        public readonly int $user_id,
        public readonly string $user_name,
        public readonly string $message,
        public readonly string $type,
        public readonly string $type_human,
        public readonly string $created_at,
        public readonly string $created_at_human,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            domain_id: $data['domain_id'],
            domain_label: $data['domain_label'],
            domain_url: $data['domain_url'],
            domain_favicon_url: $data['domain_favicon_url'],
            user_id: $data['user_id'],
            user_name: $data['user_name'],
            message: $data['message'],
            type: $data['type'],
            type_human: $data['type_human'],
            created_at: $data['created_at'],
            created_at_human: $data['created_at_human'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'domain_id' => $this->domain_id,
            'domain_label' => $this->domain_label,
            'domain_url' => $this->domain_url,
            'domain_favicon_url' => $this->domain_favicon_url,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'message' => $this->message,
            'type' => $this->type,
            'type_human' => $this->type_human,
            'created_at' => $this->created_at,
            'created_at_human' => $this->created_at_human,
        ];
    }
}
