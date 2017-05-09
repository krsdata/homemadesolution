<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
define( 'WP_MEMORY_LIMIT', '256M' );
ini_set('memory_limit', '512M');
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'homemade_homemadesolution');

/** MySQL database username */
define('DB_USER', 'homemade_home');

/** MySQL database password */
define('DB_PASSWORD', 'homemadesolution@123');

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
define('AUTH_KEY',         '{Zsu5xH5o ;{5qU2jI#^*xf}N^+{)}yA2;^x(<hN<9l{Q|^+A)oFykB)Ot+ S[jc');
define('SECURE_AUTH_KEY',  '&1M6{v>0~Acmup{QSDifm${>{:s}h](yN:yZp[keJj O=9;rJre5Sm^:|v0*___B');
define('LOGGED_IN_KEY',    '$E%Fi{=-:=b93|f>||NJdL4QIcMy@RG@[[g]5PBz[F|mw?xPxGJ14tsx4[nwzB,!');
define('NONCE_KEY',        '4EcEH::+R)8Kqm4VjT/ShIv.Ay1V8[m<a;*NZTGGe$J)>fuqSA}GHVIr[h]p9>O-');
define('AUTH_SALT',        'F&v2B5%6TlA$M$IAsHEkB)S_t5KT?W<y8Xrels>8 Zy,jh0k.X{!muJ{oaS=Whx]');
define('SECURE_AUTH_SALT', '!xl?ayr0F<Qb5R#L+ zOj|R1%|)k,p}b|=j|XB**6U(!=|2K?d_?!j2lJ~t/Rn!.');
define('LOGGED_IN_SALT',   '>Oatjqqeb0 1-C?p>G ??HjpQP`C~4nt.>pUH$tM$3rj%09Dzlr9Tb}^v82*ueKR');
define('NONCE_SALT',       'ceI^n0_0bK+<|&0u`CNc<ER:!bUY{xzx/<R3L*5PYO.>2f0Q[EkXoJqR]4i=N83g');

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
