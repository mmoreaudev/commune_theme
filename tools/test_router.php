<?php
require_once __DIR__ . '/../app/Core/Router.php';

// Minimal stub for route definitions
$router = new Router();
$router->get('/admin/login', 'Admin\\AuthController@showLogin', []);

// Simulate server vars
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/login';

try {
    // Access private method via reflection for getUri
    $reflector = new ReflectionClass($router);
    $method = $reflector->getMethod('getUri');
    $method->setAccessible(true);
    $uri = $method->invoke($router);
    echo "getUri() => " . $uri . PHP_EOL;

    // Now test resolve (this will try to execute controller; we'll replace controller with closure)
    $router2 = new Router();
    $router2->get('/admin/login', function() { echo "OK - route matched"; }, []);
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/admin/login';
    $router2->resolve();
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . PHP_EOL;
}
