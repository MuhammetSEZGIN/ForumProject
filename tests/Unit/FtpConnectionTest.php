<?php

namespace Tests\Unit;

use App\Modules\FileHandlers\TextHandler;
use PHPUnit\Framework\TestCase;
/*
 * Sanırım bu testi tamamlayamayacağım
 * */
class FtpConnectionTest extends TestCase
{
    protected TextHandler $textHandler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->textHandler = new TextHandler();
    }
    function test_ftp_connection(): void{

    }
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {

        $this->assertTrue(true);
    }
}
