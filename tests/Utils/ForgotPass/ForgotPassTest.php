<?php
namespace Tests\Utils\ForgotPassTest;

require __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

use Utils\ForgotPass\ForgotPassJwt;
use Utils\ForgotPass\ExceptionUserNotExist;

use App\Models\Usuario;

class ForgotPassTest extends TestCase
{
    private $forgotPassJwt;

    function setUp()
    {
        $this->key = 'secret_key';
        $this->forgotPassJwt = new ForgotPassJwt($this->key);
        require __DIR__ . '/../../../src/includes/activerecord.php';
    }

    function testCreateToken()
    {
        $id = 1234;
        $date = new \DateTime();
        $token = $this->forgotPassJwt->createToken($id, $date);

        $decoded = JWT::decode($token, $this->key, array('HS256'));
        $this->assertEquals($id, $decoded->iss);
    }

    function testChangePassword()
    {
        $id = '5b6b95bd06e04';
        $newPass = '2a3o1d2l';
        $date = new \DateTime();
        $token = $this->forgotPassJwt->createToken($id, $date);

        $this->forgotPassJwt->changePassword($token, $newPass);

        $user = Usuario::find_by_id_externo($id);
        $this->assertEquals(
            true,
            $user->passwordVerify($newPass)
        );
    }

    function testErrorTokenExpired()
    {
        $id = '5b6b95bd06e04';
        $newPass = '2a3o1d2l';
        $date = new \DateTime('2018-12-22');
        $token = $this->forgotPassJwt->createToken($id, $date);

        $this->expectException(ExpiredException::class);
        $this->forgotPassJwt->changePassword($token, $newPass);
    }

    function testErrorUserNotExist()
    {
        $id = '5b6b95bd06e0';
        $newPass = '2a3o1d2l';
        $date = new \DateTime();
        $token = $this->forgotPassJwt->createToken($id, $date);

        $this->expectException(ExceptionUserNotExist::class);
        $this->forgotPassJwt->changePassword($token, $newPass);
    }
}