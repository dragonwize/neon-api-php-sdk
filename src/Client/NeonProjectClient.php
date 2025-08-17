<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiRequestException;
use Dragonwize\NeonApiSdk\Exception\NeonApiResponseException;
use Dragonwize\NeonApiSdk\Model\NeonProject;
use Dragonwize\NeonApiSdk\NeonApiInterface;

/**
 * Manage Neon projects.
 */
class NeonProjectClient
{
    public function __construct(protected NeonApiInterface $api) {}

    /**
     * Retrieves a list of projects for an organization.
     *
     * You may need to specify an org_id parameter depending on your API key type.
     *
     * @see https://api-docs.neon.tech/reference/listprojects
     *
     * @return array<NeonProject>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function list(
        int $limit = 10,
        ?string $cursor = null,
        ?string $search = null,
        ?string $orgId = null,
        ?int $timeout = null
    ): ?array {
        $params = [
            'cursor'  => $cursor,
            'limit'   => $limit,
            'search'  => $search,
            'org_id'  => $orgId,
            'timeout' => $timeout,
        ];

        $response = $this->api->get('projects' . $this->api->buildQuery($params));
        $projects = [];
        foreach ($response['projects'] as $project) {
            $projects[] = NeonProject::create($project);
        }

        return $projects;
    }

    /**
     * Retrieves a list of projects shared with your Neon account.
     *
     * @see https://api-docs.neon.tech/reference/listsharedprojects
     *
     * @return array<NeonProject>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function listShared(
        int $limit = 10,
        ?string $cursor = null,
        ?string $search = null,
        ?int $timeout = null
    ): array {
        $params  = [
            'cursor'  => $cursor,
            'limit'   => $limit,
            'search'  => $search,
            'timeout' => $timeout,
        ];

        $response = $this->api->get('projects/shared' . $this->api->buildQuery($params));
        $projects = [];
        foreach ($response['projects'] as $project) {
            $projects[] = NeonProject::create($project);
        }

        return $projects;
    }

    /**
     * Retrieves information about the specified project or null if not found.
     *
     * You can obtain a project_id by listing the projects for an organization.
     *
     * @see https://api-docs.neon.tech/reference/getproject
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function get(string $projectId): NeonProject
    {
        $response = $this->api->get('projects/' . $projectId);

        return NeonProject::create($response['project']);
    }

    /**
     * Creates a Neon project within an organization.
     *
     * You may need to specify an org_id parameter depending on your API key type.
     * Plan limits define how many projects you can create.
     * You can specify a region and Postgres version in the request body.
     *
     * @see https://api-docs.neon.tech/reference/createproject
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function create(NeonProject $project): NeonProject
    {
        $response = $this->api->post('projects', $project);

        return NeonProject::create($response['project']);
    }

    /**
     * Updates the specified project.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     *
     * @see https://api-docs.neon.tech/reference/updateproject
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function update(NeonProject $project): NeonProject
    {
        $response = $this->api->patch("projects/{$project->id}", $project);

        return NeonProject::create($response['project']);
    }

    /**
     * Deletes the specified project.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * Deleting a project is a permanent action.
     * Deleting a project also deletes endpoints, branches, databases, and users
     * that belong to the project.
     *
     * @see https://api-docs.neon.tech/reference/deleteproject
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function delete(string $projectId): NeonProject
    {
        $response = $this->api->delete("projects/{$projectId}");

        return NeonProject::create($response['project']);
    }
}
