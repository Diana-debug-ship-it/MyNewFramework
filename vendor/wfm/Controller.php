<?php

namespace wfm;

abstract class Controller
{
    // сюда мы будем загружать данные из model и передавать в view
    public array $data = [];

    // массив с метаданными страницы
    public array $meta = [
        'title' => '',
        'description' => '',
        'keywords' => ''
    ];

    // базовый шаблон страницы
    // false может быть в случае, если мы
    // подключаем ajax запрос и нам нужно
    // отдать только вид без подключения шаблона
    // типа ответ без лишней вёрстки
    public false|string $layout = '';

    //вид по умолчанию
    public string $view = '';

    //объект модели по умолчанию
    public $model = '';

    // маршрут до контроллера и экшена
    protected array $route = [];

    public function __construct($route)
    {
        $this->route = $route;
    }


    public function getModel()
    {
        $model = 'app\models\\' . $this->route['admin_prefix'] . $this->route['controller'];
        if (class_exists($model)) {
            $this->model = new $model;
        }
    }

    // проверяет не переопределялся ли вид
    // если переопределялся то ставит новый вью
    // если нет то берет по по умолчанию и отправляет на отрисовку
    public function getView()
    {
        // проверяет
        $this->view = $this->view ?: $this->route['action'];
        (new View($this->route, $this->layout, $this->view, $this->meta))->render($this->data);
    }

    public function set($data)
    {
        $this->data = $data;
    }

    public function setMeta($title = '', $description = '', $keywords = '')
    {
        $this->meta = [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords
        ];
    }
}