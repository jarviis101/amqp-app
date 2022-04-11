<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidStatusException extends Exception implements HttpExceptionInterface
{
    /**
     * @var string
     */
    protected $message = "Invalid status of task.";

    public function getStatusCode(): int
    {
        return Response::HTTP_CONFLICT;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
