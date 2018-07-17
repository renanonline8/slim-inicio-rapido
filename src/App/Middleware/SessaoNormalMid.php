<?php
namespace App\Middleware;

use Utils\Middleware\Middleware;
use Utils\Middleware\InterfaceMiddleware;
use Utils\TwigUtils\TwigInputs;
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
        $inputs = new TwigInputs();
        if (!empty($inputs->retorna())) {
            $this->twigArgs->adcDados('inputForm', $inputs->retorna());
            $inputs->limpa();
        }
        $response = $next($request, $response);
        return $response;
    }
}