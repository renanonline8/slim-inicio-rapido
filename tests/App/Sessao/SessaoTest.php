<?php
namespace App\Login;

require __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Sessao\Sessao;
use App\Login\Usuario;

final class SessaoTest extends TestCase
{
    public function testIniciarSessao()
    {
        $usuario = new Usuario();
        $usuario->defineLogin(true);
        $usuario->defineEmail('renanonline8@gmail.com');
        $usuario->defineId('XYZ');

        $sessao = new Sessao();
        $atual = $sessao->iniciar($usuario);

        $esperado = true;

        $this->assertEquals($esperado, $atual);
    }
}