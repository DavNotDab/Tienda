<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit163cf8d143a08aca85c0d5211b02be05
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit163cf8d143a08aca85c0d5211b02be05::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit163cf8d143a08aca85c0d5211b02be05::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit163cf8d143a08aca85c0d5211b02be05::$classMap;

        }, null, ClassLoader::class);
    }
}
