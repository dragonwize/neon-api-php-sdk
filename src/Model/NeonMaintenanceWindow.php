<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonMaintenanceWindow implements NeonModelInterface
{
    public function __construct(
        /** @var int[] */
        public array $weekdays,
        public string $startTime,
        public string $endTime,
    ) {}

    /**
     * Create a hydrated instance with API response data.
     *
     * @param array<string, mixed> $data
     */
    public static function create(array $data): self
    {
        return new self(
            weekdays: $data['weekdays'],
            startTime: $data['start_time'],
            endTime: $data['end_time'],
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
            'weekdays'   => $this->weekdays,
            'start_time' => $this->startTime,
            'end_time'   => $this->endTime,
        ];
    }
}
