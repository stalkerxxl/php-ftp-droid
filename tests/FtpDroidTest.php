<?php

namespace Kartulin\FtpDroid\Tests;

use Kartulin\FtpDroid\FtpDroid;
use PHPUnit\Framework\TestCase;

class FtpDroidTest extends TestCase
{
    public string $hostname = '127.0.0.1';
    public int $port = 21;
    public bool $ssl = false;
    public int $timeout = 5;
    public string $login = 'ftp';
    public string $password = 'ftp';
    public FtpDroid $ftp;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ftp = FtpDroid::connect($this->hostname)
            ->login('ftp','ftp');
    }

    /**
     * @covers \Kartulin\FtpDroid\FtpDroid::connect
     * @return void
     */
    public function testConnect()
    {
        $ftp = FtpDroid::connect($this->hostname);
        $this->assertNotFalse($ftp);
        unset($ftp);

        $this->expectException(\RuntimeException::class);
        $ftp = FtpDroid::connect('127.0.0.2');
    }

    /**
     * @covers \Kartulin\FtpDroid\FtpDroid::login
     * @return void
     */
    public function testLogin()
    {
        $ftp = FtpDroid::connect($this->hostname);
        $this->assertInstanceOf(FtpDroid::class, $ftp);
        $ftp->login($this->login, $this->password);
        $this->assertTrue($ftp->result);

        $this->expectError();
        $ftp->login('1','1');
        $this->assertFalse($ftp->result);
    }

    public function testLogin2(){
        $methods = get_class_methods(FtpDroid::class);
        //dd($methods);
        $ftp = $this->getMockBuilder(FtpDroid::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->addMethods(['login'])
            ->onlyMethods($methods)
            ->getMock();
        //dd(method_exists($ftp, 'runCommand'));
        $ftp->method('login')->willReturn(true);
        $this->assertTrue($ftp->login());

        $this->markTestIncomplete();

    }

    /**
     * @covers \Kartulin\FtpDroid\FtpDroid::callback
     * @return void
     */
    public function testCallback(){
        $res = $this->ftp->callback(function (FtpDroid $ftp){
            $ftp->result = 'callback';
        });
        $this->assertEquals('callback', $this->ftp->result);
        $this->assertInstanceOf(FtpDroid::class, $res);
    }

}
