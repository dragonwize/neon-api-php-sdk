<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class ProjectQuota
{
    public function __construct(
        public ?int $activeTimeSeconds = null,
        public ?int $computeTimeSeconds = null,
        public ?int $writtenDataBytes = null,
        public ?int $dataTransferBytes = null,
        public ?int $logicalSizeBytes = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            activeTimeSeconds: $data['active_time_seconds'] ?? null,
            computeTimeSeconds: $data['compute_time_seconds'] ?? null,
            writtenDataBytes: $data['written_data_bytes'] ?? null,
            dataTransferBytes: $data['data_transfer_bytes'] ?? null,
            logicalSizeBytes: $data['logical_size_bytes'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'active_time_seconds'  => $this->activeTimeSeconds,
            'compute_time_seconds' => $this->computeTimeSeconds,
            'written_data_bytes'   => $this->writtenDataBytes,
            'data_transfer_bytes'  => $this->dataTransferBytes,
            'logical_size_bytes'   => $this->logicalSizeBytes,
        ], fn ($value) => $value !== null);
    }
}
