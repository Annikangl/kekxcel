<?php

namespace kekxcel\Views;

class View 
{
    public function render($tpl,$pageData = []) {
        require_once ROOT . $tpl;
    }
}