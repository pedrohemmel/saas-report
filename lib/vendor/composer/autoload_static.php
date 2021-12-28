<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfd16ffb9b5a0d26309902345751bdcde
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfd16ffb9b5a0d26309902345751bdcde::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfd16ffb9b5a0d26309902345751bdcde::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfd16ffb9b5a0d26309902345751bdcde::$classMap;

        }, null, ClassLoader::class);
    }
}
