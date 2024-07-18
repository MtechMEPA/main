<?php

/*
| --------------------------------------------------------------------
| App Namespace
| --------------------------------------------------------------------
|
| This defines the default Namespace that is used throughout
| CodeIgniter to refer to the Application directory. Change
| this constant to change the namespace that all application
| classes should use.
|
| NOTE: changing this will require manually modifying the
| existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
| --------------------------------------------------------------------------
| Composer Path
| --------------------------------------------------------------------------
|
| The path that Composer's autoload file is expected to live. By default,
| the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
|--------------------------------------------------------------------------
| Timing Constants
|--------------------------------------------------------------------------
|
| Provide simple ways to work with the myriad of PHP functions that
| require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR') || define('HOUR', 3600);
defined('DAY') || define('DAY', 86400);
defined('WEEK') || define('WEEK', 604800);
defined('MONTH') || define('MONTH', 2592000);
defined('YEAR') || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

defined('EXIT_SUCCESS') || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// Role
define('ROLE_RELAWAN', 'relawan');
define('ROLE_PEMILIH', 'pemilih');
