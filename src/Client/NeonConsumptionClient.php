<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiRequestException;
use Dragonwize\NeonApiSdk\Exception\NeonApiResponseException;
use Dragonwize\NeonApiSdk\Model\NeonPeriod;
use Dragonwize\NeonApiSdk\NeonApiInterface;

/**
 * View consumption details for your Neon account.
 */
class NeonConsumptionClient
{
    public function __construct(protected NeonApiInterface $api) {}

    /**
     * Retrieves consumption metrics for Scale, Business, and Enterprise plan accounts.
     *
     * History begins at the time of upgrade.
     *
     * @see https://api-docs.neon.tech/reference/getconsumptionhistorypertaccount
     *
     * @param string      $from             Start date-time for the consumption period
     * @param string      $to               End date-time for the consumption period
     * @param string      $granularity      Granularity of consumption metrics (hourly, daily, monthly)
     * @param string|null $orgId            Organization ID for which metrics should be returned
     * @param bool|null   $includeV1Metrics Deprecated. Use $metrics instead
     * @param array|null  $metrics          List of metrics to include in response
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function getAccountConsumption(
        string $from,
        string $to,
        string $granularity,
        ?string $orgId = null,
        ?bool $includeV1Metrics = null,
        ?array $metrics = null
    ): array {
        $params = [
            'from'               => $from,
            'to'                 => $to,
            'granularity'        => $granularity,
            'org_id'             => $orgId,
            'include_v1_metrics' => $includeV1Metrics,
            'metrics'            => $metrics,
        ];

        $response = $this->api->get('consumption_history/account' . $this->api->buildQuery($params));
        $metrics  = [];
        foreach ($project['periods'] as $period) {
            $metrics[] = NeonPeriod::create($period);
        }

        return $metrics;
    }

    /**
     * Retrieves consumption metrics for Scale, Business, and Enterprise plan projects.
     *
     * History begins at the time of upgrade. Issuing a call to this API does not wake a project's compute endpoint.
     *
     * @see https://api-docs.neon.tech/reference/getconsumptionhistoryperproject
     *
     * @param string      $from             Start date-time for the consumption period
     * @param string      $to               End date-time for the consumption period
     * @param string      $granularity      Granularity of consumption metrics (hourly, daily, monthly)
     * @param string|null $cursor           Cursor value from previous response for pagination
     * @param int         $limit            Number of projects to return (1-100)
     * @param array|null  $projectIds       List of project IDs to filter the response
     * @param string|null $orgId            Organization ID for which project metrics should be returned
     * @param bool|null   $includeV1Metrics Deprecated. Use $metrics instead
     * @param array|null  $metrics          List of metrics to include in response
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function getProjectConsumption(
        string $from,
        string $to,
        string $granularity,
        ?string $cursor = null,
        int $limit = 10,
        ?array $projectIds = null,
        ?string $orgId = null,
        ?bool $includeV1Metrics = null,
        ?array $metrics = null
    ): array {
        $params = [
            'cursor'             => $cursor,
            'limit'              => $limit,
            'project_ids'        => $projectIds,
            'from'               => $from,
            'to'                 => $to,
            'granularity'        => $granularity,
            'org_id'             => $orgId,
            'include_v1_metrics' => $includeV1Metrics,
            'metrics'            => $metrics,
        ];

        $response = $this->api->get('consumption_history/projects' . $this->api->buildQuery($params));
        $metrics  = [];
        foreach ($response['projects'] as $project) {
            $periods = [];
            foreach ($project['periods'] as $period) {
                $periods[] = NeonPeriod::create($period);
            }
            $metrics[$project['project_id']] = $periods;
        }

        return $metrics;
    }
}
