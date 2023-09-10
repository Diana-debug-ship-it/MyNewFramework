<?php

use wfm\App;

function debug($data, $die = false)
{
    echo '<pre> ' . print_r($data, 1) . '</pre>';
    if ($die) {
        die;
    }
}

function h($str)
{
    return htmlspecialchars($str);
}

function redirect($http = false)
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }
    header("Location: $redirect");
    die;
}

function base_url()
{
    // вернет 'http://mynewframework/en/' (если стоит англ)
    // вернет 'http://mynewframework/' (если стоит русский)
    return PATH . '/' . (App::$app->getProperty('lang') ?
            App::$app->getProperty('lang') . '/' : '');
}


/**
 * получает данные из массива _GET
 * @param $key название элемента массива _GET
 * @param $type тип передаваемых данных из массива _GET 'i', 'f', 's'
 * типы могут быть int string float
 * @return void
 *
 * get('page') == _GET['page']
 */
function get($key, $type = 'i')
{
    $param = $key;

    // пр. $page = $_GET['page'] ?? ''
    $$param = $_GET[$param] ?? '';

    if ($type == 'i') {
        return (int)$$param;
    } else if($type == 'f') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}


/**
 * получает данные из массива _POST
 * @param $key название элемента массива _POST
 * @param $type тип передаваемых данных из массива _POST 'i', 'f', 's'
 * типы могут быть int string float
 * @return void
 *
 * get('page') == _GET['page']
 */
function post($key, $type = 's')
{
    $param = $key;

    // пр. $page = $_POST['page'] ?? ''
    $$param = $_POST[$param] ?? '';

    if ($type == 'i') {
        return (int)$$param;
    } else if($type == 'f') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

/**
 * обертка для метода get из класса wfm/Language
 * @param $key
 * @return void
 * распечатывает то что возвращает метод get
 */
function __($key) {
    echo \wfm\Language::get($key);
}

/**
 * возвращает результат метода get класса wfm/Language
 * @param $key
 * @return void
 */
function ___($key) {
    return \wfm\Language::get($key);
}