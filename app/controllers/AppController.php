<?php

namespace app\controllers;

use wfm\Controller;

// контроллер AppController расширяет базовый класс Controller
// все остальные контроллеры будут наследоваться от AppController-а
// это сделано для того чтобы вынести в отдельный класс общий код
// то же самое и с моделью
class AppController extends Controller
{

    public function __construct($route = [])
    {
        parent::__construct($route);
        //TODO
    }
}