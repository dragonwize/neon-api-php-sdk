<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonRegion implements NeonModelInterface
{
    public function __construct(
        public string $regionId,
        public string $name,
        public bool $default,
        public string $geoLat,
        public string $geoLong,
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
            regionId: $data['region_id'],
            name: $data['name'],
            default: $data['default'],
            geoLat: $data['geo_lat'],
            geoLong: $data['geo_long'],
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
            'region_id' => $this->regionId,
            'name' => $this->name,
            'default' => $this->default,
            'geo_lat' => $this->geoLat,
            'geo_long' => $this->geoLong,
        ];
    }
}