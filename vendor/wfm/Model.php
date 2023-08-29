<?php

namespace wfm;

abstract class Model
{
    // данные для автозаполнения модели данными
    public array $attributes = [];

    // массив для ошибок
    public array $errors = [];

    // массив для правил валидации данных
    public array $rules = [];

    // массив для полей которые не прошли валидацию
    public array $labels = [];

    public function __construct()
    {
        Db::getInstance();
    }
}