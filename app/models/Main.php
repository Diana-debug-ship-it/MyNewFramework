<?php

namespace app\models;

use RedBeanPHP\R;
use wfm\Model;

class Main extends Model
{
    public function getNames()
    {
        $names = R::findAll('name');
        return $names;
    }
}