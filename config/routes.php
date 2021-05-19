<?php

namespace kekxcel;

use AltoRouter;

$router = new AltoRouter();
$router->setBasePath('/');

$router->map('GET|POST', '', 'IndexController#index', 'index');
$router->map('POST', 'import', 'IndexController#importExcelData', 'import');

$match = $router->match();

if (is_array($match)) {
    list($controller, $action) = explode('#', $match['target']);
    $controller = "kekxcel\\Controllers\\$controller";
    $obj = new $controller();
    call_user_func_array(array($obj,$action), array($match['params']));
} else {
    throw new \Exception("Страница не найдена", 404);
}