<?php

namespace Domainwarden\Sdk\DataTransferObjects;

readonly class CreateNotificationChannelRequest
{
    public function __construct(
        public string $label,
        public string $type,
        public string $value,
        public ?string $secondary_value = null,
        public ?bool $whois_notifications_enabled = null,
        public ?bool $ssl_notifications_enabled = null,
        public ?bool $dns_notifications_enabled = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'label' => $this->label,
            'type' => $this->type,
            'value' => $this->value,
        ];

        if ($this->secondary_value !== null) {
            $data['secondary_value'] = $this->secondary_value;
        }

        if ($this->whois_notifications_enabled !== null) {
            $data['whois_notifications_enabled'] = $this->whois_notifications_enabled;
        }

        if ($this->ssl_notifications_enabled !== null) {
            $data['ssl_notifications_enabled'] = $this->ssl_notifications_enabled;
        }

        if ($this->dns_notifications_enabled !== null) {
            $data['dns_notifications_enabled'] = $this->dns_notifications_enabled;
        }

        return $data;
    }
}