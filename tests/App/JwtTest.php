<?php
namespace Tests\App;

require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use \Firebase\JWT\JWT;

class JwtTest extends TestCase
{
    function testJWTDecoded() {
        $key = 'example_key';
        $token = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000
        );
        $jwt = JWT::encode($token, $key);
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        $this->assertEquals(1356999524, $decoded->iat);
    }
}