<?php
namespace App\Sessao;

use App\Login\Usuario;
use App\Sessao\Sessao;

interface InterfaceSessao
{
    public function iniciar(Usuario $usuario): Sessao;
    public function verificar(): Sessao;
}