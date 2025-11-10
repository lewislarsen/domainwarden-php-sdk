<?php

namespace Domainwarden\Sdk\DataTransferObjects;

readonly class UpdateNotificationChannelRequest
{
    public function __construct(
        public ?string $label = null,
        public ?string $type = null,
        public ?string $value = null,
        public ?string $secondary_value = null,
        public ?bool $whois_notifications_enabled = null,
        public ?bool $ssl_notifications_enabled = null,
        public ?bool $dns_notifications_enabled = null,
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->label !== null) {
            $data['label'] = $this->label;
        }

        if ($this->type !== null) {
            $data['type'] = $this->type;
        }

        if ($this->value !== null) {
            $data['value'] = $this->value;
        }

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