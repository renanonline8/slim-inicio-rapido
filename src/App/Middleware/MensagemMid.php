<?php
namespace App\Middleware;

use Utils\Middleware\Middleware;
use Utils\Middleware\InterfaceMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MensagemMid extends Middleware implements InterfaceMiddleware
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $params = $request->getQueryParams();
    
        if(!empty($params['mensagens'])) {
            $codMensagens = $params['mensagens'];
            $mensagens = explode('%', $codMensagens);
            
            foreach ($mensagens as $mensagem) {
                $msg = new \Utils\Mensagem\Mensagem($mensagem);
                $this->twigArgs->adcMensagem($msg);    
            }
        }
        
        $response = $next($request, $response);
        
        return $response;
    }
}