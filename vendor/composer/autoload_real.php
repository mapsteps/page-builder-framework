<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitdf755d3323c84bd8bd262eb6aca82972
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

        spl_autoload_register(array('ComposerAutoloaderInitdf755d3323c84bd8bd262eb6aca82972', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitdf755d3323c84bd8bd262eb6aca82972', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitdf755d3323c84bd8bd262eb6aca82972::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}