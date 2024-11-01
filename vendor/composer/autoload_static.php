<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8124084db0678e632b965e165d8dc0ff
{
    public static $files = array (
        'cff41d6db3aab22c2f8c9e0af2f8ae76' => __DIR__ . '/../..' . '/Inc/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'JLTWPFOLIO\\Libs\\License\\' => 24,
            'JLTWPFOLIO\\Libs\\' => 16,
            'JLTWPFOLIO\\Inc\\Admin\\' => 21,
            'JLTWPFOLIO\\Inc\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'JLTWPFOLIO\\Libs\\License\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Libs/License',
        ),
        'JLTWPFOLIO\\Libs\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Libs',
        ),
        'JLTWPFOLIO\\Inc\\Admin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Inc/Admin',
        ),
        'JLTWPFOLIO\\Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8124084db0678e632b965e165d8dc0ff::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8124084db0678e632b965e165d8dc0ff::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8124084db0678e632b965e165d8dc0ff::$classMap;

        }, null, ClassLoader::class);
    }
}