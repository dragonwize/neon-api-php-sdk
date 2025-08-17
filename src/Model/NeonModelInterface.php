<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

interface NeonModelInterface extends \JsonSerializable
{
    /**
     * Create a hydrated instance with API response data.
     *
     * @param array<string, string|int|bool|object|array|null> $data
     */
    public static function create(array $data): static;

    /**
     * Translate model to array with API field names and values for JSON encoding.
     *
     * @return array<string, string|int|bool|object|array|null>
     */
    public function jsonSerialize(): array;
}
