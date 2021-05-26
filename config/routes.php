<?php

namespace kekxcel;

use AltoRouter;

$router = new AltoRouter();
$router->setBasePath('/');

$router->map('GET|POST', '', 'IndexController#index', 'index');
$router->map('POST', 'import', 'IndexController#importExcelData', 'import');
$router->map('POST', 'export', 'IndexController#exportDataToExcel', 'export');
$router->map('POST', 'search', 'IndexController#searchData', 'search');

$match = $router->match();

if (is_array($match)) {
    list($controller, $action) = explode('#', $match['target']);
    $controller = "kekxcel\\Controllers\\$controller";
    $obj = new $controller();
    call_user_func_array(array($obj,$action), array($match['params']));
} else {
    http_response_code(404);
    include VIEW_PATH . '/Error/404.php';
}