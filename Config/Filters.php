<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use \App\Filters\Filterauth;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'filterauth' => Filterauth::class
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            'filterauth' => [
                'except' => [
                    'auth', 'auth/*',
                    'home', 'home/*',
                    'maintenance', 'maintenance/*',
                    'pengaduan', 'pengaduan/*',
                ]
            ]
        ],
        'after'  => [
            'filterauth' => [
                'except' => [
                    'auth', 'auth/*',
                    'portal', 'portal/*',
                    'home', 'home/*',
                    'maintenance', 'maintenance/*',
                    'pengaduan', 'pengaduan/*',
                    'su', 'su/*',
                    'adm', 'adm/*',
                    'dinas', 'dinas/*',
                    'pan', 'pan/*',
                    'sek', 'sek/*',
                    'pd', 'pd/*',
                ]
            ],
            'toolbar',
            //'honeypot'
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}
