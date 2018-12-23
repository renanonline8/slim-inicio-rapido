<?php
namespace App;

require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Utils\Tests\BaseTestCase;
//use Swift_SmtpTransport;

class EmailTest extends BaseTestCase
{
    function testRouteEmail()
    {
        $response = $this->runApp('GET', '/tests/email');

        $this->assertEquals(200, $response->getStatusCode());
    }
}