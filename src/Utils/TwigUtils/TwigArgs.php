<?php
namespace Utils\TwigUtils;

use App\Sessao\Sessao;
use Utils\Mensagem\Mensagem;

final class TwigArgs
{
    private $args;

    public function __construct()
    {
        $this->args = array();
        $this->args['mensagem'] = array();
        $this->args['sessao'] = array();
        $this->args['dados'] = array();
    }

    public function adcMensagem(Mensagem $mensagem)
    {
        array_push($this->args['mensagem'], $mensagem->serialize());  
    }

    public function adcSessao(Sessao $sessao)
    {
        $this->args['sessao'] = $sessao->retDadosSessao();
    }

    public function adcDados(String $campo, $valor)
    {
        $this->args['dados'][$campo] = $valor;   
    }
    
    public function retArgs()
    {
        return $this->args;
    }
}