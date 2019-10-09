<?php


use DI\ContainerBuilder;
use League\Plates\Engine;
use Aura\SqlQuery\QueryFactory;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    // place your definitions here
    Engine::class    =>  function() {
        return new Engine(__DIR__ .'/View');
    },

    QueryFactory::class    =>  function() {
        return new QueryFactory('mysql');
    },

    PDO::class    =>  function() {
        $dbOptions = (require __DIR__ . '/DbConnection.php')['db'];
        return new PDO(
            'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
            $dbOptions['user'],
            $dbOptions['password']);
    },
]);
$container = $containerBuilder->build();


$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->get('/', ["App\OnlineStore\Controllers\HomePageController", "main"]);
    $r->get('/add', ["App\OnlineStore\Controllers\HomePageController", "add"]);
    $r->post('/add', ["App\OnlineStore\Controllers\HomePageController", "add"]);
    $r->get('/delete/{id:\d+}', ["App\OnlineStore\Controllers\HomePageController", "delete"]);
    $r->get('/show/{id:\d+}', ["App\OnlineStore\Controllers\HomePageController", "show"]);
    $r->get('/edit/{id:\d+}', ["App\OnlineStore\Controllers\HomePageController", "edit"]);
    $r->post('/edit/{id:\d+}', ["App\OnlineStore\Controllers\HomePageController", "edit"]);

//    $r->post('/update/{id:\d+}', ["App\OnlineStore\Controllers\HomePageController", "edit"]);
    // {id} must be a number (\d+)
//    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
//    // The /{title} suffix is optional
//    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        var_dump('404 not found');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        var_dump('405 not found');
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars

//        $container = new Container();
        $container->call($handler, $vars);

        break;
}