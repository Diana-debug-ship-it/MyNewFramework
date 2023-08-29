<?php

namespace app\controllers;
use wfm\Controller;

class MainController extends Controller
{

    public function indexAction()
    {
        $this->setMeta('Главная страница', 'Description', 'keywords');
        $this->set(['test' => 'TEST_VAR', 'name' => 'NAME']);
    }
}