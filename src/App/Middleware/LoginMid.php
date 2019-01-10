<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Utils\Middleware\Middleware;
use Utils\Middleware\InterfaceMiddleware;

use App\Sessao\SessaoNormal;

final class LoginMid extends Middleware implements InterfaceMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $sessaoNormal = new SessaoNormal();
        $sessao = $sessaoNormal->verificar();
        if($sessao->checaStatus()) {
            $path = $this->router->pathFor('dashboard');
            return $response->withRedirect($path);
        }
        $response = $next($request, $response);
        return $response;
    }
}