<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

interface NeonModelInterface extends \JsonSerializable
{
    /**
     * Create a hydrated instance with API response data.
     *
     * @param array<string, mixed> $data
     */
    public static function create(array $data): self;

    /**
     * Translate model to array with API field names and values for JSON encoding.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array;
}
