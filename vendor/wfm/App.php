<?php

namespace wfm;

class App
{
    /**
     * @var Registry контейнер приложения
     */
    public static $app;

    public function __construct()
    {
        $query = trim(urldecode($_SERVER['QUERY_STRING']), '/');
        new ErrorHandler();
        self::$app = Registry::getInstance();
        $this->getParams();
        Router::dispatch($query);
    }

    protected function getParams()
    {
        if (file_exists(CONFIG . '/params.php')) {
            $params = require_once CONFIG . '/params.php';
            if (!empty($params)) {
                foreach ($params as $key => $value) {
                    self::$app->setProperty($key, $value);
                }
            }
        } else {
            return 'Empty';
        }
    }

}