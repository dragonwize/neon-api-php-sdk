<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonMaintenanceWindow implements \JsonSerializable
{
    public function __construct(
        /** @var int[] */
        public array $weekdays,
        public string $startTime,
        public string $endTime,
    ) {}

    public static function create(array $data): self
    {
        return new self(
            weekdays: $data['weekdays'],
            startTime: $data['start_time'],
            endTime: $data['end_time'],
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'weekdays'   => $this->weekdays,
            'start_time' => $this->startTime,
            'end_time'   => $this->endTime,
        ];
    }
}
