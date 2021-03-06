<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class PriorityAlreadyExist extends Exception implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return Response::HTTP_CONFLICT;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
