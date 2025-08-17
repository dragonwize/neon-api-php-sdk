<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiRequestException;
use Dragonwize\NeonApiSdk\Exception\NeonApiResponseException;
use Dragonwize\NeonApiSdk\Model\NeonRegion;
use Dragonwize\NeonApiSdk\NeonApiInterface;

/**
 * Inspect Neon regions.
 */
class NeonRegionClient
{
    public function __construct(protected NeonApiInterface $api) {}

    /**
     * Lists supported Neon regions.
     *
     * @see https://api-docs.neon.tech/reference/getactiveregions
     *
     * @return array<NeonRegion>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function list(): array
    {
        $response = $this->api->get('regions');
        $regions  = [];
        foreach ($response['regions'] as $region) {
            $regions[] = NeonRegion::create($region);
        }

        return $regions;
    }
}
