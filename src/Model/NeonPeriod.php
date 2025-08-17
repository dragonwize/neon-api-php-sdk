<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonPeriod implements NeonModelInterface
{
    public function __construct(
        public ?string $periodId,
        public ?string $periodPlan,
        public ?string $periodStart,
        public ?string $periodEnd = null,
        /** @var array<ConsumptionHistoryPerTimeframe> */
        public array $consumption,
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
        $consumption = [];
        foreach ($data['consumption'] as $consumptionData) {
            $consumption[] = NeonConsumption::create($consumptionData);
        }

        return new static(
            periodId: $data['period_id'],
            periodPlan: $data['period_plan'],
            periodStart: $data['period_start'],
            periodEnd: $data['period_end'] ?? null,
            consumption: $consumption,
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
            'period_id' => $this->periodId,
            'period_plan' => $this->periodPlan,
            'period_start' => $this->periodStart,
            'period_end' => $this->periodEnd,
            'consumption' => $this->consumption,
        ], fn ($value) => $value !== null);
    }
}
