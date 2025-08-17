<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonProjectOwnerData implements NeonModelInterface
{
    public function __construct(
        public string $email,
        public string $name,
        public int $branchesLimit,
        public string $subscriptionType,
    ) {}

    /**
     * Create a hydrated instance with API response data.
     *
     * @param array<string, mixed> $data
     */
    public static function create(array $data): self
    {
        return new self(
            email: $data['email'],
            name: $data['name'],
            branchesLimit: $data['branches_limit'],
            subscriptionType: $data['subscription_type'],
        );
    }

    /**
     * Translate model to array with API field names and values for JSON encoding.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'email'             => $this->email,
            'name'              => $this->name,
            'branches_limit'    => $this->branchesLimit,
            'subscription_type' => $this->subscriptionType,
        ];
    }
}
