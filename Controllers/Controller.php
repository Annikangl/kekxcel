<?php

namespace kekxcel\Controllers;

use kekxcel\Views\View;
use kekxcel\Models\Model;

class Controller {

    public $model;
    public $view;
    public $pageData = [];

    public function __construct() {
        $this->model = new Model();
        $this->view = new View();
    }
}