<?php
namespace App\Sessao;

use App\Login\Usuario;

final class Sessao
{
    private $status;

    public function iniciar(Usuario $usuario): Bool
    {
        if ($usuario->obtemLogin()) {
            $_SESSION = array (
                'login' => true,
                'data' => array(
                    'id' => $usuario->obtemID(),
                    'email' => $usuario->obtemEmail()
                )
            );
            $this->status = true;
        } else {
            $this->status = false;
        }

        return $this->status;
    }

    public function verificar() 
    {
        ob_start();

        if (isset($_SESSION['login'])) {
            $this->status = true;
        } else {
            $this->status = false;
        }

        ob_end_flush();

        return $this->status;
    }
}