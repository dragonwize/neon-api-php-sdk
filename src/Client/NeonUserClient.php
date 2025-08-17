<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiRequestException;
use Dragonwize\NeonApiSdk\Exception\NeonApiResponseException;
use Dragonwize\NeonApiSdk\Model\NeonAuthDetails;
use Dragonwize\NeonApiSdk\Model\NeonUser;
use Dragonwize\NeonApiSdk\NeonApiInterface;

/**
 * Manage your Neon user account.
 */
class NeonUserClient
{
    public function __construct(protected NeonApiInterface $api) {}

    /**
     * Retrieves information about the current Neon user account.
     *
     * @see https://api-docs.neon.tech/reference/getcurrentuserinfo
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function getCurrentUser(): NeonUser
    {
        $response = $this->api->get('users/me');

        return NeonUser::create($response);
    }

    /**
     * Retrieves information about the current Neon user's organizations.
     *
     * @see https://api-docs.neon.tech/reference/getcurrentuserorganizations
     *
     * @return array<string, mixed>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function getCurrentUserOrganizations(): array
    {
        $response = $this->api->get('users/me/organizations');

        return $response['organizations'];
    }

    /**
     * Transfers selected projects, identified by their IDs, from your personal account to a specified organization.
     *
     * @see https://api-docs.neon.tech/reference/transferprojectsfromusertoorg
     *
     * @param string        $destinationOrgId The destination organization identifier
     * @param array<string> $projectIds       The list of project IDs to transfer (max 400)
     *
     * @return array<string, mixed>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function transferProjectsToOrganization(string $destinationOrgId, array $projectIds): array
    {
        $data = [
            'destination_org_id' => $destinationOrgId,
            'project_ids'        => $projectIds,
        ];

        $response = $this->api->post('users/me/projects/transfer', $data);

        return $response;
    }

    /**
     * Returns auth information about the passed credentials.
     *
     * It can refer to an API key, Bearer token or OAuth session.
     *
     * @see https://api-docs.neon.tech/reference/getauthdetails
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function getAuthDetails(): NeonAuthDetails
    {
        $response = $this->api->get('auth');

        return NeonAuthDetails::create($response);
    }
}
