<?php

namespace app\widgets\menu;

use RedBeanPHP\R;
use wfm\App;
use wfm\Cache;

class Menu
{

    protected $data; // данные из бд
    protected $tree; // дерево сформированное из data
    protected $menuHtml; // хтмл код странички
    protected $tpl; // шаблон
    protected $container = 'ul'; // во что оборачивается наше меню
    protected $class = 'menu'; // класс для нашего меню
    protected $table = 'category'; // таблица где наше меню
    protected $cache = 3600;
    protected $cacheKey = 'mynewframework_menu'; // этим ключом кешируются данные
    protected $attrs = []; // аттрибуты к меню
    protected $prepend = ''; // код который мы можем добавить перед меню
    protected $language;

    public function __construct($options = [])
    {
        // берем текущий язык, находим файл с шаблоном, получаем опции если есть

        $this->language = App::$app->getProperty('language');
        $this->tpl = __DIR__ . '/menu_tpl.php';
        $this->getOptions($options);
        $this->run();
    }

    protected function getOptions($options)
    {
        foreach ($options as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    protected function run()
    {
        $cache = Cache::getInstance();
        $this->menuHtml = $cache->get("{$this->cacheKey}_{$this->language['code']}");

        if (!$this->menuHtml) {
//            $this->data = R::getAssoc("SELECT c.*, cd.* FROM category c
//            JOIN category_description cd ON c.id = cd.category_id WHERE cd.language_id = ?", [$this->language['id']]);
            $this->data = App::$app->getProperty("categories_{$this->language['code']}");
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
            if ($this->cache) {
                $cache->set("{$this->cacheKey}_{$this->language['code']}", $this->menuHtml, $this->cache);
            }
        }
        $this->output();
    }

    protected function output()
    {
        $attrs = '';
        if (!empty($this->attrs)) {
            foreach ($this->attrs as $k => $v) {
                $attrs .= " $k = '$v' ";
            }
        }

        echo "<{$this->container} class='{$this->class}' $attrs>";
        echo $this->prepend;
        echo $this->menuHtml;
        echo "</{$this->container}>";
    }

    protected function getTree()
    {
        $tree = [];
        $data = $this->data;
        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent_id']]['children'][$id] = &$node;
            }
        }

        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '')
    {
        $str = '';
        foreach ($tree as $id => $category) {
            $str .= $this->catToTemplate($category, $tab, $id);
        }
        return $str;
    }

    private function catToTemplate($category, $tab, $id)
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }


}