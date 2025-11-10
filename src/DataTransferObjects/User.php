<?php

namespace Domainwarden\Sdk\DataTransferObjects;

class User
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $avatar,
        public readonly bool $subscribed,
        public readonly string $created_at,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            avatar: $data['avatar'],
            subscribed: $data['subscribed'],
            created_at: $data['created_at'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'subscribed' => $this->subscribed,
            'created_at' => $this->created_at,
        ];
    }
}
