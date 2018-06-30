<?php
namespace App\Login;

require __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Sessao\SessaoNormal;
use App\Sessao\Sessao;
use App\Login\Usuario;

final class SessaoNormalTest extends TestCase
{
    public function testIniciarSessao()
    {
        $usuario = new Usuario();
        $usuario->defineLogin(true);
        $usuario->email = 'renanonline8@gmail.com';
        $usuario->id = 'XYZ';

        $sessao = new SessaoNormal();
        $atual = $sessao->iniciar($usuario);

        $esperado = new Sessao(true);
        $esperado->id = 'XYZ';

        $this->assertEquals($esperado, $atual);
    }
}