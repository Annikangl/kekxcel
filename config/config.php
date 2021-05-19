<?php

define('ROOT', dirname(__DIR__) . '/');
define('CONTROLLER_PATH', ROOT . "Controllers/");
define('MODEL_PATH', ROOT . "Models/");
define('VIEW_PATH', ROOT . "Views/");

require_once ROOT . 'config/db.php';
require_once ROOT . 'config/routes.php';
