<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonAuthDetails implements NeonModelInterface
{
    public function __construct(
        public string $accountId,
        public string $authMethod,
        public ?string $authData = null,
    ) {}

    /**
     * Create a hydrated instance with API response data.
     *
     * @param array<string, string|int|bool|object|array|null> $data
     *
     * @return static
     */
    public static function create(array $data): static
    {
        return new static(
            accountId: $data['account_id'],
            authMethod: $data['auth_method'],
            authData: $data['auth_data'] ?? null,
        );
    }

    /**
     * Translate model to array with API field names and values for JSON encoding.
     *
     * @return array<string, string|int|bool|object|array|null>
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'account_id' => $this->accountId,
            'auth_method' => $this->authMethod,
            'auth_data' => $this->authData,
        ], fn ($value) => $value !== null);
    }
}