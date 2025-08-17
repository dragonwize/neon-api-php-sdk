<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Model;

readonly class NeonUser implements NeonModelInterface
{
    public function __construct(
        public int $activeSecondsLimit,
        public string $id,
        public string $email,
        public string $login,
        public string $name,
        public string $lastName,
        public string $image,
        public int $projectsLimit,
        public int $branchesLimit,
        public int $maxAutoscalingLimit,
        public array $authAccounts,
        public string $plan,
        public ?array $billingAccount = null,
        public ?int $computeSecondsLimit = null,
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
        return new static(
            activeSecondsLimit: $data['active_seconds_limit'],
            id: $data['id'],
            email: $data['email'],
            login: $data['login'],
            name: $data['name'],
            lastName: $data['last_name'],
            image: $data['image'],
            projectsLimit: $data['projects_limit'],
            branchesLimit: $data['branches_limit'],
            maxAutoscalingLimit: $data['max_autoscaling_limit'],
            authAccounts: $data['auth_accounts'],
            plan: $data['plan'],
            billingAccount: $data['billing_account'] ?? null,
            computeSecondsLimit: $data['compute_seconds_limit'] ?? null,
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
            'active_seconds_limit' => $this->activeSecondsLimit,
            'id' => $this->id,
            'email' => $this->email,
            'login' => $this->login,
            'name' => $this->name,
            'last_name' => $this->lastName,
            'image' => $this->image,
            'projects_limit' => $this->projectsLimit,
            'branches_limit' => $this->branchesLimit,
            'max_autoscaling_limit' => $this->maxAutoscalingLimit,
            'auth_accounts' => $this->authAccounts,
            'plan' => $this->plan,
            'billing_account' => $this->billingAccount,
            'compute_seconds_limit' => $this->computeSecondsLimit,
        ], fn ($value) => $value !== null);
    }
}