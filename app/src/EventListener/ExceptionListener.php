<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $statusCode = $exception->getCode();

        $response = new JsonResponse([
            'code' => $statusCode,
            'message' => $exception->getMessage(),
        ], $statusCode);

        $event->setResponse($response);
    }
}
