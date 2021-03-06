<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/7/14
 * Time: 下午9:12
 *
 * you can test use:
 *  php -S 127.0.0.1:5671 examples/object.php
 *
 * then you can access url: http://127.0.0.1:5671
 */

use Inhere\Route\Dispatcher;
use Inhere\Route\ORouter;

require __DIR__ . '/simple-loader.php';

$router = new ORouter;

// set config
$router->setConfig([
    // 'ignoreLastSep' => true,
    // 'tmpCacheNumber' => 100,

//    'matchAll' => '/', // a route path
//    'matchAll' => function () { // a callback
//        echo 'System Maintaining ... ...';
//    },

    // enable autoRoute
    // you can access '/demo' '/admin/user/info', Don't need to configure any route
    'autoRoute' => 1,
    'controllerNamespace' => 'Inhere\Route\Examples\Controllers',
    'controllerSuffix' => 'Controller',
]);

$router->get('/routes', function() use($router) {
    var_dump(
        $router->getStaticRoutes(),
        $router->getVagueRoutes()
    );
    var_dump($router->getRegularRoutes());
});

/** @var array $routes */
$routes = require __DIR__ . '/some-routes.php';

foreach ($routes as $route) {
    // group
    if (is_array($route[1])) {
        $rs = $route[1];
        $router->group($route[0], function (ORouter $router) use($rs){
            foreach ($rs as $r) {
                $router->map($r[0], $r[1], $r[2], isset($r[3]) ? $r[3] : []);
            }
        });

        continue;
    }

    $router->map($route[0], $route[1], $route[2], isset($route[3]) ? $route[3] : []);
}

// var_dump($router);die;

$dispatcher = new Dispatcher([
    'dynamicAction' => true,
    // on notFound, output a message.
    Dispatcher::ON_NOT_FOUND => function ($path) {
        echo "the page $path not found!";
    }
]);

// OR register event by `Dispatcher::on()`
// $dispatcher->on(Dispatcher::ON_NOT_FOUND, function ($path) {
//     echo "the page $path not found!";
// });

/*
method 1

$dispatcher->setMatcher(function ($path, $method) use($router) {
    return $router->match($path, $method);
});
$dispatcher->dispatch();
 */

/*
method 2
 */
$router->dispatch($dispatcher);

/*
method 3

$router->dispatch([
    'dynamicAction' => true,
    Dispatcher::ON_NOT_FOUND => function ($path) {
        echo "the page $path not found!";
    }
]);
 */
