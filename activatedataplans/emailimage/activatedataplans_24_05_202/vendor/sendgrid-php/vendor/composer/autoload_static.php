<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb7047d7e9d037f9136261af1baf84184
{
    public static $files = array (
        '79f66bc0a1900f77abe4a9a299057a0a' => __DIR__ . '/..' . '/starkbank/ecdsa/src/ellipticcurve.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SendGrid\\Stats\\' => 15,
            'SendGrid\\Mail\\' => 14,
            'SendGrid\\Helper\\' => 16,
            'SendGrid\\EventWebhook\\' => 22,
            'SendGrid\\Contacts\\' => 18,
            'SendGrid\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SendGrid\\Stats\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib/stats',
        ),
        'SendGrid\\Mail\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib/mail',
        ),
        'SendGrid\\Helper\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib/helper',
        ),
        'SendGrid\\EventWebhook\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib/eventwebhook',
        ),
        'SendGrid\\Contacts\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib/contacts',
        ),
        'SendGrid\\' => 
        array (
            0 => __DIR__ . '/..' . '/sendgrid/php-http-client/lib',
        ),
    );

    public static $classMap = array (
        'BaseSendGridClientInterface' => __DIR__ . '/../..' . '/lib/BaseSendGridClientInterface.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'SendGrid' => __DIR__ . '/../..' . '/lib/SendGrid.php',
        'TwilioEmail' => __DIR__ . '/../..' . '/lib/TwilioEmail.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb7047d7e9d037f9136261af1baf84184::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb7047d7e9d037f9136261af1baf84184::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb7047d7e9d037f9136261af1baf84184::$classMap;

        }, null, ClassLoader::class);
    }
}
