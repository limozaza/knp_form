<?php
/**
 * Created by PhpStorm.
 * User: zakaria
 * Date: 22/09/17
 * Time: 20:14
 */

namespace AppBundle\Listener;


use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    protected $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // provide the better way to display a enhanced error page only in prod environment, if you want

        // exception object
        $exception = $event->getException();

        // new Response object
        $response = new Response();

        // set response content
        $response->setContent(
            $this->templating->render(
                ':Exception:exception.html.twig',
                array('exception' => $exception)
            )
        );

        // HttpExceptionInterface is a special type of exception
        // that holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(500);
        }

        // set the new $response object to the $event
        $event->setResponse($response);
    }

}