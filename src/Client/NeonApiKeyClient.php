<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Client;

use Dragonwize\NeonApiSdk\Exception\NeonApiRequestException;
use Dragonwize\NeonApiSdk\Exception\NeonApiResponseException;
use Dragonwize\NeonApiSdk\Model\NeonApiKey;
use Dragonwize\NeonApiSdk\NeonApiInterface;

/**
 * Create and manage API keys for your Neon account.
 */
class NeonApiKeyClient
{
    public function __construct(protected NeonApiInterface $api) {}

    /**
     * Retrieves the API keys for your Neon account.
     *
     * The response does not include API key tokens. A token is only provided when creating an API key.
     * API keys can also be managed in the Neon Console.
     *
     * @see https://api-docs.neon.tech/reference/listapikeys
     *
     * @return array<NeonApiKey>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function list(): array
    {
        $response = $this->api->get('api_keys');
        $apiKeys  = [];
        foreach ($response as $apiKey) {
            $apiKeys[] = NeonApiKey::create($apiKey);
        }

        return $apiKeys;
    }

    /**
     * Creates an API key.
     *
     * The key_name is a user-specified name for the key.
     * This method returns an id and key. The key is a randomly generated, 64-bit token required to access the Neon API.
     * API keys can also be managed in the Neon Console.
     *
     * @see https://api-docs.neon.tech/reference/createapikey
     *
     * @param string $keyName The user-specified name for the API key
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function create(string $keyName): NeonApiKey
    {
        $response = $this->api->post('api_keys', ['key_name' => $keyName]);

        return NeonApiKey::create($response);
    }

    /**
     * Revokes the specified API key.
     *
     * An API key that is no longer needed can be revoked.
     * This action cannot be reversed.
     * You can obtain key_id values by listing the API keys for your Neon account.
     * API keys can also be managed in the Neon Console.
     *
     * @see https://api-docs.neon.tech/reference/revokeapikey
     *
     * @param int $keyId The API key ID
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function revoke(int $keyId): NeonApiKey
    {
        $response = $this->api->delete("api_keys/{$keyId}");

        return NeonApiKey::create($response);
    }
}
