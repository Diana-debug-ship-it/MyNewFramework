<?php

namespace wfm;

/**
 * Данный трейт мы используем в качестве реализации
 * синглтона чтобы эту реализацию можно было
 * переиспользовать в других классах
 */

trait TSingleton
{
    private static ?self $instance = null;

    private function __construct()
    {

    }


    /**
     * здесь возвращается статик а не селф,
     * т.к. это трейт и он используется в других классах
     */
    public static function getInstance(): static
    {

        /** эта абракадабра ?? значит
         * если в инстансе что-то есть, то вернет инстанс
         * если в инстансе ниче нет, то создаст новый и вернет
         */
        return static::$instance ?? static::$instance = new static();
    }
}