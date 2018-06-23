<?php
namespace App\Sessao;

final class Sessao
{
    private $status;
    private $dadosSessao;

    public function __construct(Bool $status)
    {
        $this->status = $status;
    }

    public function __set($prop, $valor)
    {
        $this->dadosSessao[$prop] = $valor;
    }

    public function __get($prop)
    {
        if(isset($this->dadosSessao[$prop])) {
            return $this->dadosSessao[$prop];
        } else {
            return null;
        }
    }

    public function checaStatus()
    {
        return $this->status;
    }

    public function retDadosSessao(): Array
    {
        return $this->dadosSessao;
    }
}