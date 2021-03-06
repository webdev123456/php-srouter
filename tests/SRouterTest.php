<?php
namespace Inhere\Route\Tests;

use PHPUnit\Framework\TestCase;
use Inhere\Route\SRouter;

/**
 * @covers SRouter
 */
class SRouterTest extends TestCase
{

    private function registerRoutes()
    {
        SRouter::get('/', 'handler0');
        SRouter::get('/test', 'handler1');
        SRouter::get('/{name}', 'handler2');
        SRouter::get('/hi/{name}', 'handler3', [
            'params' => [
                'name' => '\w+',
            ]
        ]);
    }

    public function testAddRoutes()
    {
        $this->registerRoutes();

        $this->assertSame(4, SRouter::count());
        $this->assertCount(2, SRouter::getStaticRoutes());
        $this->assertCount(1, SRouter::getRegularRoutes());
        $this->assertCount(1, SRouter::getVagueRoutes());
    }

    public function testStaticRoute()
    {
        $this->registerRoutes();

        // 1
        $ret = SRouter::match('/', 'GET');

        $this->assertCount(3, $ret);

        list($status, $path, $route) = $ret;

        $this->assertSame(SRouter::FOUND, $status);
        $this->assertSame('/', $path);
        $this->assertSame('handler0', $route['handler']);
    }

    public function testParamRoute()
    {
        $this->registerRoutes();

        // route: /{name}
        $ret = SRouter::match('/tom', 'GET');

        $this->assertCount(3, $ret);

        list($status, $path, $route) = $ret;

        $this->assertSame(SRouter::FOUND, $status);
        $this->assertSame('/tom', $path);
        $this->assertSame('handler2', $route['handler']);

        // route: /hi/{name}
        $ret = SRouter::match('/hi/tom', 'GET');

        $this->assertCount(3, $ret);

        list($status, $path, $route) = $ret;

        $this->assertSame(SRouter::FOUND, $status);
        $this->assertSame('/hi/tom', $path);
        $this->assertSame('/hi/{name}', $route['original']);
        $this->assertSame('handler3', $route['handler']);
    }
}
