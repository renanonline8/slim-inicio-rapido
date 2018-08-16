<?php
namespace Utils\Upload;

require __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Utils\Upload\Upload;

class UploadTest extends TestCase
{
    public function testUploadDirOk()
    {
        $upload = new Upload(__DIR__ . '/UploadTests');
        $expect = __DIR__ . '/UploadTests';
        $this->assertEquals($expect, $upload->getBaseDirectory());
    }

    public function testUploadDirError()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(1);
        $upload = new Upload('fail');
    }

    public function testSendFileOK()
    {
        $upload = new Upload(__DIR__ . '/UploadTests');
        $result = $upload->send(__DIR__ . '/UploadTests/text1.txt', 'teste1', 'test/');
        unlink(__DIR__ . '/UploadTests/test/teste1.txt');
        $this->assertEquals(true, $result);
    }

    public function testSendFileNotExist()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(2);
        $upload = new Upload(__DIR__ . '/UploadTests');
        $result = $upload->send(__DIR__ . '/UploadTests/notExist.txt', 'notExist', 'test/');
    }
}