<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiRequestException;
use Dragonwize\NeonApiSdk\Exception\NeonApiResponseException;
use Dragonwize\NeonApiSdk\Model\NeonOperation;
use Dragonwize\NeonApiSdk\Model\NeonRole;
use Dragonwize\NeonApiSdk\NeonApiInterface;

/**
 * Manage Neon roles (users).
 */
class NeonRoleClient
{
    public function __construct(protected NeonApiInterface $api) {}

    /**
     * Retrieves a list of Postgres roles from the specified branch.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain the branch_id by listing the project's branches.
     * In Neon, the terms "role" and "user" are synonymous.
     *
     * @see https://api-docs.neon.tech/reference/listprojectbranchroles
     *
     * @return array<NeonRole>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function list(string $projectId, string $branchId): array
    {
        $response = $this->api->get("projects/{$projectId}/branches/{$branchId}/roles");
        $roles    = [];
        foreach ($response['roles'] as $role) {
            $roles[] = NeonRole::create($role);
        }

        return $roles;
    }

    /**
     * Retrieves details about the specified role.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain the branch_id by listing the project's branches.
     * You can obtain the role_name by listing the roles for a branch.
     * In Neon, the terms "role" and "user" are synonymous.
     *
     * @see https://api-docs.neon.tech/reference/getprojectbranchrole
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function get(string $projectId, string $branchId, string $roleName): NeonRole
    {
        $response = $this->api->get("projects/{$projectId}/branches/{$branchId}/roles/{$roleName}");

        return NeonRole::create($response['role']);
    }

    /**
     * Creates a Postgres role in the specified branch.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain the branch_id by listing the project's branches.
     * In Neon, the terms "role" and "user" are synonymous.
     *
     * Connections established to the active compute endpoint will be dropped.
     * If the compute endpoint is idle, the endpoint becomes active for a short period of time and is suspended afterward.
     *
     * @see https://api-docs.neon.tech/reference/createprojectbranchrole
     *
     * @param array $data Role creation data (name)
     *
     * @return array{role: NeonRole, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function create(string $projectId, string $branchId, array $data): array
    {
        $response = $this->api->post("projects/{$projectId}/branches/{$branchId}/roles", ['role' => $data]);

        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }

        return [
            'role'       => NeonRole::create($response['role']),
            'operations' => $operations,
        ];
    }

    /**
     * Deletes the specified Postgres role from the branch.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain the branch_id by listing the project's branches.
     * You can obtain the role_name by listing the roles for a branch.
     * In Neon, the terms "role" and "user" are synonymous.
     *
     * @see https://api-docs.neon.tech/reference/deleteprojectbranchrole
     *
     * @return array{role: NeonRole, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function delete(string $projectId, string $branchId, string $roleName): array
    {
        $response = $this->api->sendRequest('DELETE', "projects/{$projectId}/branches/{$branchId}/roles/{$roleName}");

        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }

        return [
            'role'       => NeonRole::create($response['role']),
            'operations' => $operations,
        ];
    }

    /**
     * Retrieves the password for the specified Postgres role, if possible.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain the branch_id by listing the project's branches.
     * You can obtain the role_name by listing the roles for a branch.
     * In Neon, the terms "role" and "user" are synonymous.
     *
     * @see https://api-docs.neon.tech/reference/getprojectbranchrolepassword
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function revealPassword(string $projectId, string $branchId, string $roleName): NeonRole
    {
        $response = $this->api->get("projects/{$projectId}/branches/{$branchId}/roles/{$roleName}/reveal_password");

        return NeonRole::create($response['role']);
    }

    /**
     * Resets the password for the specified Postgres role.
     *
     * Returns a new password and operations. The new password is ready to use when the last operation finishes.
     * The old password remains valid until last operation finishes.
     * Connections to the compute endpoint are dropped. If idle, the compute endpoint becomes active for a short period of time.
     *
     * You can obtain a project_id by listing the projects for your Neon account.
     * You can obtain the branch_id by listing the project's branches.
     * You can obtain the role_name by listing the roles for a branch.
     * In Neon, the terms "role" and "user" are synonymous.
     *
     * @see https://api-docs.neon.tech/reference/resetprojectbranchrolepassword
     *
     * @return array{role: NeonRole, operations: array<NeonOperation>}
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function resetPassword(string $projectId, string $branchId, string $roleName): array
    {
        $response = $this->api->post("projects/{$projectId}/branches/{$branchId}/roles/{$roleName}/reset_password");

        $operations = [];
        foreach ($response['operations'] as $operation) {
            $operations[] = NeonOperation::create($operation);
        }

        return [
            'role'       => NeonRole::create($response['role']),
            'operations' => $operations,
        ];
    }
}
