<?php

declare(strict_types=1);

namespace Dragonwize\NeonApiSdk\Exception;

use Psr\Http\Message\ResponseInterface;

class NeonApiResponseException extends NeonApiException
{
    public readonly ResponseInterface $response;

    /** @var array<mixed>|null */
    public readonly ?array $responseBody;

    /**
     * @param array<mixed>|null $responseBody
     */
    public function __construct(
        ResponseInterface $response,
        ?array $responseBody = null,
        ?\Throwable $previous = null
    ) {
        $this->response     = $response;
        $this->responseBody = $responseBody;

        $message = $responseBody['message'] ?? 'Error message not provided.';
        $code    = $responseBody['code'] ?? $response->getStatusCode();

        parent::__construct($message, $code, $previous);
    }
}
