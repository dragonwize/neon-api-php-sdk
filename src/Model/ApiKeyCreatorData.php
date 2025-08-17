<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class ApiKeyCreatorData implements NeonModelInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $image,
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
            id: $data['id'],
            name: $data['name'],
            image: $data['image'],
        );
    }

    /**
     * Translate model to array with API field names and values for JSON encoding.
     *
     * @return array<string, string|int|bool|object|array|null>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
        ];
    }
}