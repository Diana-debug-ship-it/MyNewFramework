<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\language\Language;
use wfm\App;
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
        new AppModel();

        App::$app->setProperty('languages', Language::getLanguages());

        App::$app->setProperty('language', Language::getLanguage(App::$app->getProperty('languages')));

        $lang = App::$app->getProperty('language');
        \wfm\Language::load($lang['code'], $this->route);
    }
}