<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\language\Language;
use RedBeanPHP\R;
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

        $categories = R::getAssoc("SELECT c.*, cd.* FROM category c
            JOIN category_description cd 
            ON c.id = cd.category_id 
            WHERE cd.language_id = ?", [$lang['id']]);

        App::$app->setProperty("categories_{$lang['code']}", $categories);
    }
}