<?php
namespace App\Middleware;

use Utils\Middleware\Middleware;
use Utils\Middleware\InterfaceMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Sessao\SessaoNormal;

final class SessaoNormalMid extends Middleware implements InterfaceMiddleware
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $sessaoNormal = new SessaoNormal();
        $sessao = $sessaoNormal->verificar();
        if (!$sessao->checaStatus()) {
            return $response->withRedirect('login?mensagens=3');
        }
        $this->twigArgs->adcSessao($sessao);
        $response = $next($request, $response);
        return $response;
    }
}