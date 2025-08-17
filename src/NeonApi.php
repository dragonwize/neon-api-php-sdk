<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk;

use Dragonwize\NeonApiSdk\Exception\NeonApiRequestException;
use Dragonwize\NeonApiSdk\Exception\NeonApiResponseException;
use Dragonwize\NeonApiSdk\Model\NeonModelInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Neon API configuration and utility methods.
 */
class NeonApi implements NeonApiInterface
{
    /** Neon API base URL. */
    protected const string BASE_URL = 'https://console.neon.tech/api/v2/';

    /**
     * Neon API key.
     *
     * This can be a personal, organizational, or project-specific key.
     */
    protected string $apiKey;

    /**
     * HTTP client object to be used for sending requests.
     *
     * This can be any PSR-18 compliant HTTP client.
     * Examples: Symfony HttpClient, Guzzle, etc.
     */
    protected ClientInterface $httpClient;

    /**
     * Request factory object to be used for creating HTTP requests.
     *
     * This can be any PSR-17 compliant request factory.
     * Examples: Symfony RequestFactory, GuzzleHttp\Psr7\RequestFactory, etc.
     */
    protected RequestFactoryInterface $httpMessageFactory;

    /**
     * Optional Error Logger.
     *
     * This can be any PSR-3 compatible logger.
     */
    protected ?LoggerInterface $logger = null;

    /**
     * Neon API base URL.
     *
     * Can be overridden to support testing or custom API endpoints.
     */
    protected string $baseUrl = self::BASE_URL;

    public function __construct(
        string $apiKey,
        ClientInterface $httpClient,
        RequestFactoryInterface $httpMessageFactory,
        ?LoggerInterface $logger = null,
        string $baseUrl = self::BASE_URL
    ) {
        $this->apiKey             = $apiKey;
        $this->httpClient         = $httpClient;
        $this->httpMessageFactory = $httpMessageFactory;
        $this->baseUrl            = $baseUrl;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    public function getHttpMessageFactory(): RequestFactoryInterface
    {
        return $this->httpMessageFactory;
    }

    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    public function setLogger(?LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * Convient method to make a GET request to the Neon API.
     *
     * @return array<mixed>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function get(string $uri): array
    {
        $request = $this->createRequest('GET', $uri);

        return $this->parseResponse($this->sendRequest($request));
    }

    /**
     * Convient method to make a POST request to the Neon API.
     *
     * @return array<mixed>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function post(string $uri, NeonModelInterface|array|null $body = null): array
    {
        $request = $this->createRequest('POST', $uri);
        if ($body) {
            $request = $request->withBody($this->httpMessageFactory->createStream(json_encode($body)));
        }

        return $this->parseResponse($this->sendRequest($request));
    }

    /**
     * Convient method to make a PATCH request to the Neon API.
     *
     * @return array<mixed>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function patch(string $uri, NeonModelInterface|array|null $body = null): array
    {
        $request = $this->createRequest('PATCH', $uri);
        if ($body) {
            $request = $request->withBody($this->httpMessageFactory->createStream(json_encode($body)));
        }

        return $this->parseResponse($this->sendRequest($request));
    }

    /**
     * Convient method to make a PUT request to the Neon API.
     *
     * @return array<mixed>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function put(string $uri, NeonModelInterface|array|null $body = null): array
    {
        $request = $this->createRequest('PUT', $uri);
        if ($body) {
            $request = $request->withBody($this->httpMessageFactory->createStream(json_encode($body)));
        }

        return $this->parseResponse($this->sendRequest($request));
    }

    /**
     * Convient method to make a DELETE request to the Neon API.
     *
     * @return array<mixed>
     *
     * @throws NeonApiRequestException
     * @throws NeonApiResponseException
     */
    public function delete(string $uri): array
    {
        $request = $this->createRequest('DELETE', $uri);

        return $this->parseResponse($this->sendRequest($request));
    }

    /**
     * Creates a new PSR-7 request with some default configuration.
     */
    public function createRequest(string $method, string $uri): RequestInterface
    {
        $request = $this->httpMessageFactory
            ->createRequest($method, $this->baseUrl . $uri)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', 'Bearer ' . $this->apiKey)
            ->withHeader('User-Agent', 'DragonwizeNeonApiPhpSdk/1');

        return $request;
    }

    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @throws NeonApiRequestException
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->getHttpClient()->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new NeonApiRequestException($request, $e);
        }
    }

    /**
     * Decodes a PSR-7 response body into a PHP array.
     *
     * @return array<string, mixed>|null
     *                                   Decoded response body as an array, or null if the response is invalid
     *
     * @throws NeonApiResponseException
     */
    public function parseResponse(ResponseInterface $response): ?array
    {
        if ($response->getStatusCode() >= 400) {
            // Request failed.
            $this->logResponseError($response);
            throw new NeonApiResponseException($response);
        }

        $data = json_decode((string) $response->getBody(), true);

        if (json_last_error() !== \JSON_ERROR_NONE) {
            $errorMsg = 'Neon response has invalid JSON: ' . json_last_error_msg();
            $this->logger?->error($errorMsg, ['response' => $response]);

            throw new NeonApiResponseException($response, ['message' => $errorMsg]);
        }

        return $data;
    }

    /**
     * Create a HTTP query string from an array of parameters.
     *
     * @param array<string, string|int|bool> $params
     */
    public function buildQuery(array $params): string
    {
        $query = http_build_query($params);

        return $query ? '?' . $query : '';
    }

    public function logResponseError(ResponseInterface $response, string $msgPrefix = 'Neon API request failed: '): void
    {
        if ($response->getStatusCode() < 400) {
            // This is not an error response.
            return;
        }

        $error   = json_decode((string) $response->getBody(), true);
        $message = $msgPrefix . "[{$response->getStatusCode()}:{$response->getReasonPhrase()}] ";
        $message .= $error['message'] ?? 'No error message provided.';

        $context = [
            'error'         => $error,
            'status_code'   => $response->getStatusCode(),
            'reason_phrase' => $response->getReasonPhrase(),
            'headers'       => $response->getHeaders(),
        ];

        $this->logger?->error($message, $context);
    }
}
