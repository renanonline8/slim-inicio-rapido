<?php
namespace Utils\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface InterfaceMiddleware
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next);
}