<?php

namespace App\Exception;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class TaskNotFoundException extends EntityNotFoundException implements HttpExceptionInterface
{
    /**
     * @var string
     */
    protected $message = "Task not found.";

    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    public function getHeaders(): array
    {
        return [];
    }
}
