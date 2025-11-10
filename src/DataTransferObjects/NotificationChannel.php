<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class NotificationChannel
{
    public function __construct(
        public readonly string $id,
        public readonly string $label,
        public readonly string $type,
        public readonly string $type_human,
        public readonly bool $whois_notifications_enabled,
        public readonly bool $dns_notifications_enabled,
        public readonly bool $ssl_notifications_enabled,
        public readonly bool $is_protected,
        public readonly bool $is_disabled,
        public readonly ?string $disabled_reason,
        public readonly ?string $last_notification_sent_at,
        public readonly ?string $last_notification_sent_at_human,
        public readonly string $created_at,
        public readonly string $created_at_human,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            label: $data['label'],
            type: $data['type'],
            type_human: $data['type_human'],
            whois_notifications_enabled: $data['whois_notifications_enabled'],
            dns_notifications_enabled: $data['dns_notifications_enabled'],
            ssl_notifications_enabled: $data['ssl_notifications_enabled'],
            is_protected: $data['is_protected'],
            is_disabled: $data['is_disabled'],
            disabled_reason: $data['disabled_reason'] ?? null,
            last_notification_sent_at: $data['last_notification_sent_at'] ?? null,
            last_notification_sent_at_human: $data['last_notification_sent_at_human'] ?? null,
            created_at: $data['created_at'],
            created_at_human: $data['created_at_human'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'type' => $this->type,
            'type_human' => $this->type_human,
            'whois_notifications_enabled' => $this->whois_notifications_enabled,
            'dns_notifications_enabled' => $this->dns_notifications_enabled,
            'ssl_notifications_enabled' => $this->ssl_notifications_enabled,
            'is_protected' => $this->is_protected,
            'is_disabled' => $this->is_disabled,
            'disabled_reason' => $this->disabled_reason,
            'last_notification_sent_at' => $this->last_notification_sent_at,
            'last_notification_sent_at_human' => $this->last_notification_sent_at_human,
            'created_at' => $this->created_at,
            'created_at_human' => $this->created_at_human,
        ];
    }
}