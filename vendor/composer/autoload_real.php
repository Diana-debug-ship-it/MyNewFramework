<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitd232827943897ca6d171f2ac247c9ddf
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitd232827943897ca6d171f2ac247c9ddf', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitd232827943897ca6d171f2ac247c9ddf', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitd232827943897ca6d171f2ac247c9ddf::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
