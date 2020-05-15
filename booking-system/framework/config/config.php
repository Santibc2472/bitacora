<?php

/*
 * Title                   : DOT Pinpoint Framework (World)
 * File                    : framework/config/config.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Framework configuration file.
 */

/*
 * Define the paths.
 */
define('DOT_ABS_PATH', str_replace('/framework/config/', '', str_replace('\\', '/', dirname(rtrim(__FILE__, '/\\' )).'/'))); // Aplication/framework absolute path.
define('DOT_URL', str_replace('/framework/config/', '', plugin_dir_url(__FILE__))); // Application URL.

/*
 * Include main configuration first.
 */
include_once DOT_ABS_PATH.'/config.php';

/*
 * Define configuration before other configuration files.
 */

/*
 * Main configuration.
 */
!defined('DOT_ID') ? define('DOT_ID', 'dot'):''; // Unique aplication ID.
!defined('DOT_STATUS') ? define('DOT_STATUS', 'beta'):''; // Application status (beta, live, maintenance).
!defined('DOT_VERSION') ? define('DOT_VERSION', '1.0'):''; // Application version.

/*
 * AJAX configuration.
 */
!defined('DOT_AJAX_VAR') ? define('DOT_AJAX_VAR', 'ajax'):''; // AJAX request variable.

/*
 * Cookie configuration.
 */
!defined('DOT_COOKIE_EXPIRE') ? define('DOT_COOKIE_EXPIRE', 0):''; // Default cookie expiration time in seconds.
!defined('DOT_COOKIE_PATH') ? define('DOT_COOKIE_PATH', '/'):''; // Default cookie path.
!defined('DOT_COOKIE_DOMAIN') ? define('DOT_COOKIE_DOMAIN', ''):''; // Default cookie (sub)domain.
!defined('DOT_COOKIE_SECURE') ? define('DOT_COOKIE_SECURE', false):''; // Default cookie security.
!defined('DOT_COOKIE_HTTP') ? define('DOT_COOKIE_HTTP', false):''; // Default cookie HTTP access.

/*
 * Database configuration.
 */
!defined('DOT_DATABASE_TABLES_PREFIX') ? define('DOT_DATABASE_TABLES_PREFIX', ''):''; // Tables names prefix from the database.

/*
 * Session configuration.
 */
!defined('DOT_SESSION_COOKIE') ? define('DOT_SESSION_COOKIE', ''):''; // Session cookie name. If it is blank a cookie is not going to be used.
!defined('DOT_SESSION_COOKIE_SECURE') ? define('DOT_SESSION_COOKIE_SECURE', false):''; // Session cookie security.
!defined('DOT_SESSION_COOKIE_HTTP') ? define('DOT_SESSION_COOKIE_SECURE', false):''; // Session cookie HTTP access.

/*
 * Include the rest of the configuration files.
 */
include_once DOT_ABS_PATH.'/framework/config/config-addons.php';
include_once DOT_ABS_PATH.'/framework/config/config-classes.php';

include_once DOT_ABS_PATH.'/application/config/config-countries.php';
include_once DOT_ABS_PATH.'/application/config/config-database.php';
include_once DOT_ABS_PATH.'/application/config/config-languages.php';
include_once DOT_ABS_PATH.'/application/config/config-views.php';