<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class ProjectOwnerData
{
    public function __construct(
        public string $email,
        public string $name,
        public int $branchesLimit,
        public string $subscriptionType,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            name: $data['name'],
            branchesLimit: $data['branches_limit'],
            subscriptionType: $data['subscription_type'],
        );
    }

    public function toArray(): array
    {
        return [
            'email'             => $this->email,
            'name'              => $this->name,
            'branches_limit'    => $this->branchesLimit,
            'subscription_type' => $this->subscriptionType,
        ];
    }
}
