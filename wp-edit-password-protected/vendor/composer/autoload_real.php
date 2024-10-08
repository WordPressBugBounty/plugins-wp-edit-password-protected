<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit82c1ad5b8351cf14e55657da4a3e539b
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

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit82c1ad5b8351cf14e55657da4a3e539b', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit82c1ad5b8351cf14e55657da4a3e539b', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit82c1ad5b8351cf14e55657da4a3e539b::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
