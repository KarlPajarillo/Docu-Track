<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf5ab098a53c82f89d70086d0de29ea71
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitf5ab098a53c82f89d70086d0de29ea71::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf5ab098a53c82f89d70086d0de29ea71::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf5ab098a53c82f89d70086d0de29ea71::$classMap;

        }, null, ClassLoader::class);
    }
}
