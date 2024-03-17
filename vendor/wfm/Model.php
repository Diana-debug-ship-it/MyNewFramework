<?php

namespace wfm;

use RedBeanPHP\R;
use Valitron\Validator;

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

    public function load($post = true)
    {
        $data = $post ? $_POST : $_GET;
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function validate($data): bool
    {
        Validator::langDir(APP . '/languages/validator/lang');
        Validator::lang('ru');
        $validator = new Validator($data);
        $validator->rules($this->rules);
        $validator->labels($this->getLabels());
        if ($validator->validate()) {
            return true;
        } else {
            $this->errors = $validator->errors();
            debug($this->errors);
            return false;
        }
    }

    public function getErrors()
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= "<li>{$item}</li>";
            }
        }
        $errors .= "</ul>";
        $_SESSION['errors'] = $errors;
    }

    public function getLabels(): array
    {
        $labels = [];
        foreach ($this->labels as $k => $v) {
            $labels[$k] = ___($v);
        }
        return $labels;
    }

    public function save($table): int|string
    {
        $tbl = R::dispense($table); //создаем объект
        foreach ($this->attributes as $name => $value) {
            if ($value != '') {
                $tbl->$name = $value; // указываем для него свойства
            }
        }
        return R::store($tbl); // сохраняем этот объект
    }

    public function update($table, $id): int|string
    {
        $tbl = R::load($table, $id);
        foreach ($this->attributes as $name => $value) {
            if ($value != '') {
                $tbl->$name = $value;
            }
        }
        return R::store($tbl);
    }
}