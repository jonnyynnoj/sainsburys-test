<?php

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use Goutte\Client as Goutte;

abstract class ResponseTest extends PHPUnit_Framework_TestCase
{
    protected static $goutte;

    protected static function mockClient($responses)
    {
        self::$goutte = new Goutte;

        $mock = new MockHandler($responses);
        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        self::$goutte->setClient($guzzle);
    }

    protected static function makeResponse($scraper, $type)
    {
        return fopen(__DIR__ . '/mocks/responses/' . $scraper . '/' . $type . '.html', 'r');
    }
}
