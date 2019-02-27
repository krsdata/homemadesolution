<?php
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'homemade_homemadesolutions');

/** MySQL database username */
define('DB_USER', 'homemade_home');

/** MySQL database password */
define('DB_PASSWORD', 'homemadesolutions@123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ']0o2|UF0rfh`03m<+ahVX?*D>o[4#AJo+`Epi(gNQTkvu:rqwO=I=-XqOnpxzH7I');
define('SECURE_AUTH_KEY',  'hEaBe=|/g$P>N+A-c/CK[Fw!,oa=GQ/ntBLK7V%~>EqU98*_>kD%p(QP%Z4}K,kh');
define('LOGGED_IN_KEY',    'n%/*B;Vs9G4pu!{:d~~d/K4`j^m5 rF>&=WAEn8f<>*,9zhh<PHT)=n;8osnVl9s');
define('NONCE_KEY',        'O|d!3$}8KwP6+#|^)p(h/dXPo%eVZ+U(H?I|{/`ULw rJ:;lQ9Te{AUt|}Z0l61/');
define('AUTH_SALT',        '&L<RJ&DD0qT29BL!iL3i~xKI:Uuv+Jw&%&BWtRxM5G@c.V%g^@@r{^F~Ee9Kt||I');
define('SECURE_AUTH_SALT', 'Jig%z$QS^8Qzio,xcN!]~%=>usCd{!q`:9c#CR?^sjkE`j[gc<g^YWJ;Bg;V!yTs');
define('LOGGED_IN_SALT',   '|@xVR{^|/;6Hz<+Ypk0H /@WK/mz$U#MDf2L8v4D;h,h%5Fbub~HA?#Q6SH-BR+p');
define('NONCE_SALT',       '#*osFv/Bw_1h{g AmWKOF$ubOS{<D }e)lZc;WvbK>Rg292lucy|(^]s~{]8tD,#');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
