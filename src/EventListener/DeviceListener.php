<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class DeviceListener
{
    public function onKernelRequest(RequestEvent $requestEvent)
    {
        $request = $requestEvent->getRequest();
        $userAgent = $request->headers->get('User-Agent');

        if (preg_match('/(iPhone|Android.+Mobile)/i', $userAgent)) {
            $request->attributes->set('device', 'mobile');
            
        } else {
            $request->attributes->set('device', 'desktop');
        }
    }
}