<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class BulkNotificationChannelResponse
{
    public function __construct(
        public readonly string $message,
        public readonly int $copied_count,
        public readonly int $skipped_count,
        public readonly string $target_domain_id,
        public readonly string $source_domain_id,
    ) {}

    public static function fromArray(array $response): self
    {
        $data = $response['data'];

        return new self(
            message: $response['message'],
            copied_count: $data['copied_count'],
            skipped_count: $data['skipped_count'],
            target_domain_id: $data['target_domain_id'],
            source_domain_id: $data['source_domain_id'],
        );
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'data' => [
                'copied_count' => $this->copied_count,
                'skipped_count' => $this->skipped_count,
                'target_domain_id' => $this->target_domain_id,
                'source_domain_id' => $this->source_domain_id,
            ],
        ];
    }
}