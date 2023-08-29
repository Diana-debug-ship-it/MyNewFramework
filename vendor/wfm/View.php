<?php

namespace wfm;

use Exception;

class View
{
    public string $content = '';

    protected $route;
    protected $layout = '';
    protected $view = '';
    protected $meta = [];

    public function __construct($route, $layout, $view, $meta)
    {
        $this->route = $route;
        $this->layout = $layout;
        $this->view = $view;
        $this->meta = $meta;

        // проверяем не переопределили ли файл шаблона
        if (false !== $this->layout) {
            $this->layout = $this->layout ?: LAYOUT;
        }
    }

    // занимается отрисовкой
    public function render($data)
    {
        if (is_array($data)) {
            extract($data);
        }

        // заменяем admin\ на admin/ чтобы всё работало
        $prefix = str_replace('\\', '/', $this->route['admin_prefix']);

        // ищем файл с вью
        // префикс нужен чтобы проверить вдруг это админка
        //если не админка то пустая строка и ищем не в админке
        $view_file = APP . "/views/{$prefix}{$this->route['controller']}/{$this->view}.php";

        // в данном методе мы берем вью и тащим его в буфер
        // вью из буфера помещаем в метод контент
        // свойство контент мы будем использовать в шаблоне в layout
        if (file_exists($view_file)) {
            ob_start();
            require_once $view_file;
            $this->content = ob_get_clean();
        } else {
            throw new Exception("Не найден вид {$view_file}", 500);
        }

        // это сам layout который находится во вьюс
        // тупо подключаем файл если он есть
        // если нет то выкидываем исключение
        if (false !== $this->layout) {
            $layout_file = APP . "/views/layouts/{$this->layout}.php";

            if (is_file($layout_file)) {
                require_once $layout_file;
            } else {
                throw new Exception("Не найден шаблон {$layout_file}", 500);
            }
        }
    }


    public function getMeta()
    {
        $out = '<title>' . h($this->meta['title']) . '</title>' . PHP_EOL;
        $out .= '<meta name="description" content="' . h($this->meta['description']) . '">' . PHP_EOL;
        $out .= '<meta name="keywords" content="' . h($this->meta['keywords']) . '">' . PHP_EOL;
        return $out;
    }
}