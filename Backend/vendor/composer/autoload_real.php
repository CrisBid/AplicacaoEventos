<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit37213f3f5c6f2d46b70c2e5bfa0a4603
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

        spl_autoload_register(array('ComposerAutoloaderInit37213f3f5c6f2d46b70c2e5bfa0a4603', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit37213f3f5c6f2d46b70c2e5bfa0a4603', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit37213f3f5c6f2d46b70c2e5bfa0a4603::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
