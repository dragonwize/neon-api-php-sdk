<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonConsumption implements NeonModelInterface
{
    public function __construct(
        public string $timeframeStart,
        public string $timeframeEnd,
        public int $activeTimeSeconds,
        public int $computeTimeSeconds,
        public int $writtenDataBytes,
        public int $syntheticStorageSizeBytes,
        public ?int $dataStorageBytesHour = null,
        public ?int $logicalSizeBytes = null,
        public ?int $logicalSizeBytesHour = null,
    ) {}

    /**
     * Create a hydrated instance with API response data.
     *
     * @param array<string, mixed> $data
     */
    public static function create(array $data): self
    {
        return new self(
            timeframeStart: $data['timeframe_start'],
            timeframeEnd: $data['timeframe_end'],
            activeTimeSeconds: $data['active_time_seconds'],
            computeTimeSeconds: $data['compute_time_seconds'],
            writtenDataBytes: $data['written_data_bytes'],
            syntheticStorageSizeBytes: $data['synthetic_storage_size_bytes'],
            dataStorageBytesHour: $data['data_storage_bytes_hour'] ?? null,
            logicalSizeBytes: $data['logical_size_bytes'] ?? null,
            logicalSizeBytesHour: $data['logical_size_bytes_hour'] ?? null,
        );
    }

    /**
     * Translate model to array with API field names and values for JSON encoding.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'timeframe_start'              => $this->timeframeStart,
            'timeframe_end'                => $this->timeframeEnd,
            'active_time_seconds'          => $this->activeTimeSeconds,
            'compute_time_seconds'         => $this->computeTimeSeconds,
            'written_data_bytes'           => $this->writtenDataBytes,
            'synthetic_storage_size_bytes' => $this->syntheticStorageSizeBytes,
            'data_storage_bytes_hour'      => $this->dataStorageBytesHour,
            'logical_size_bytes'           => $this->logicalSizeBytes,
            'logical_size_bytes_hour'      => $this->logicalSizeBytesHour,
        ], fn ($value) => $value !== null);
    }
}
