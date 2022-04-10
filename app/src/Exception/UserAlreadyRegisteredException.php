<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class UserAlreadyRegisteredException extends Exception implements HttpExceptionInterface
{
    /**
     * @var string
     */
    protected $message = "User already registered.";

    public function getStatusCode(): int
    {
        return Response::HTTP_CONFLICT;
    }

    public function getHeaders(): array
    {
        return [];
    }
}