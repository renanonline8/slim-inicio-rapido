<?php
namespace App\Sessao;

use App\Login\Usuario;
use App\Sessao\Sessao;
use App\Sessao\InterfaceSessao;

final class SessaoNormal implements InterfaceSessao
{

    public function iniciar(Usuario $usuario): Sessao
    {
        if ($usuario->obtemLogin()) {
            $_SESSION = $usuario->retornaDados();
            $dadosSessao = $usuario->retornaDados();
            $sessao = new Sessao(true);
            $sessao->id = $dadosSessao['dados']['id'];
            $sessao->email = $dadosSessao['dados']['email'];
        } else {
            $sessao = new Sessao(false);
        }

        return $sessao;
    }

    public function verificar(): Sessao
    {
        if (isset($_SESSION['login'])) {
            $sessao = new Sessao(true);
            $sessao->id = $_SESSION['dados']['id'];
            $sessao->email = $_SESSION['dados']['email'];
        } else {
            $sessao = new Sessao(false);
        }

        return $sessao;
    }

    public function sairSessao()
    {
        session_unset();
        session_destroy();
    }
}