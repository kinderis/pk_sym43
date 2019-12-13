<?php

namespace App\EventListener;

use App\Exception\ApiExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ApiExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        if (!$event->getException() instanceof ApiExceptionInterface) {
            return;
        }

        $response = new JsonResponse($this->buildResponseData($event->getException()));
        $response->setStatusCode($event->getException()->getCode());

        $event->setResponse($response);
    }

    private function buildResponseData(ApiExceptionInterface $exception)
    {
        $messages = json_decode($exception->getMessage());
        if (!is_array($messages)) {
            $messages = $exception->getMessage() ? [$exception->getMessage()] : [];
        }

        return [
            'error' => [
                'statusCode' => $exception->getCode(),
                'messages' => $messages
            ]];
    }
}