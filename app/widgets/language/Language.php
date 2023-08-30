<?php

namespace app\widgets\language;

use Exception;
use RedBeanPHP\R;
use wfm\App;

class Language
{
    // здесь будет храниться шаблон какой-то хтмл код
    protected $tpl;

    //все языки
    protected $languages;

    // текущий язык
    protected $language;

    public function __construct()
    {
        $this->tpl = __DIR__ . '/lang_tpl.php';
        $this->run();
    }

    public function run()
    {
        $this->languages = App::$app->getProperty('languages');
        $this->language = App::$app->getProperty('language');
        echo $this->getHtml();
    }

    /**
     * @return array возвращает список языков
     */
    public static function getLanguages(): array
    {
        return R::getAssoc("SELECT code, title, base, id FROM language
ORDER BY base DESC");
    }


    /**
     * @param $languages
     * @return mixed
     * @throws Exception
     */
    public static function getLanguage($languages)
    {
        $lang = App::$app->getProperty('lang');

        // чекаем если язык передали в адресной строке и он есть в массиве всех языков
        if ($lang && array_key_exists($lang, $languages)) {
            $key = $lang;

            // если код языка не передали значит используем тот по умолчанию
        } elseif (!$lang) {
            $key = key($languages);

            // если передали несуществующий язык
        } else {
            $lang = h($lang);
            throw new Exception("Not fount language $lang", 404);
        }

        $lang_info = $languages[$key];
        $lang_info['code'] = $key;
        return $lang_info;
    }

    protected function getHtml(): string
    {
        ob_start();
        require_once $this->tpl;
        return ob_get_clean();
    }
}