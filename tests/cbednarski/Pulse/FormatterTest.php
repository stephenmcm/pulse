<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

class FormatterTest extends PHPUnit_Framework_TestCase
{
    public function testToJson()
    {

    }

    public function testToHtml()
    {

    }

    public function testToCli()
    {

    }

    public function testIsBrowser()
    {
        $pulse = new cbednarski\Pulse\Pulse();
        $formatter = new cbednarski\Pulse\Formatter($pulse);

        $_SERVER['HTTP_USER_AGENT'] = 'Opera/9.80 (Android 4.0.4; Linux; Opera Mobi/ADR-1301080958) Presto/2.11.355 Version/12.10';
        $this->assertTrue($formatter->isBrowser());

        $_SERVER['HTTP_USER_AGENT'] = 'Java/1.6.0_22';
        $this->assertFalse($formatter->isBrowser());

        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows; U; nl-NL) AppleWebKit/533.19.4 (KHTML, like Gecko) AdobeAIR/3.1';
        $this->assertTrue($formatter->isBrowser());

        unset($_SERVER['HTTP_USER_AGENT']);
        $this->assertFalse($formatter->isBrowser());

    }

    public function testAcceptsJson()
    {

    }
}