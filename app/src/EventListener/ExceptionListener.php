<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof HttpExceptionInterface) {
            $code = $exception->getStatusCode();
        }
        $code = $code ?? Response::HTTP_INTERNAL_SERVER_ERROR;
        $event->setResponse(new JsonResponse($exception->getMessage(),$code));
    }
}
