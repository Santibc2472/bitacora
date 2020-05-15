<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : config.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Configuration file. The file is mandatory.
 */

/*
 * Main configuration.
 */
define('DOT_ID', 'pbs'); // Unique aplication ID.
define('DOT_STATUS', isset($_SERVER['SERVER_NAME']) ? ($_SERVER['SERVER_NAME'] == 'dopstudios.net' ? 'beta':'live'):'beta'); // Application status (beta, live, maintenance).
define('DOT_VERSION', '2.6.7'); // Application version.

/*
 * AJAX configuration.
 */
define('DOT_AJAX_VAR', 'action'); // AJAX request variable.

/*
 * Cookie configuration.
 */
define('DOT_COOKIE_EXPIRE', 2678400); // Default cookie expiration time in seconds.
define('DOT_COOKIE_SECURE', DOT_STATUS == 'beta' ? false:true); // Default cookie security.

/*
 * Database configuration.
 */
define('DOT_DATABASE_TABLES_PREFIX', 'dopbsp_');

/*
 * Session configuration.
 */
define('DOT_SESSION_COOKIE', 'pinpoint_ounicutevdxxtvpl'); // Session cookie name. If it is blank a cookie is not going to be used.
define('DOT_SESSION_COOKIE_SECURE', false); // Session cookie security.
define('DOT_SESSION_COOKIE_HTTP', true); // Session cookie security.

/*
 * Add config files that are not framework defaults.
 */
include_once DOT_ABS_PATH.'/application/config/config-businesses.php'; // Include businesses configuration.

/*
 * Cookies configuration.
 */
define('PW_COOKIE_NAME', 'pw_cccccccccccccccc'); // Cart cookie name.