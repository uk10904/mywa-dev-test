<?php
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
define('DB_NAME', 'gciowago_wp_m3a9');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

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
define('AUTH_KEY',         'OS*4(>,<us7]&Np6h~j<]v5e?Kvj_b?$eW(nl&6Ed>WkYu9TZRQ8Eu2hwxAJc=S;');
define('SECURE_AUTH_KEY',  '_w&H;7`%[.Cz;etN`%U^HrU2GrHTpGfMnIBEW3mwo9 ``4#e}#XV.}[&(5{Nehib');
define('LOGGED_IN_KEY',    '2|lAncSkxk&1nsW6c7Dm2_$.INZ(&_SvdS]ez!nA3L1n+5vo(>GTgC)b!,bCq2?g');
define('NONCE_KEY',        'Y~0VnYvrt*k&e&%~+ j^kEL0*JQ _AX]WmA6>sPc=x*cEu=O8}/^9%PPe_=a(j6Z');
define('AUTH_SALT',        '-f)WHWfeH4XU98_qD(#YcCI`H@;3DrJE>yVIfHw9q$6rn+,?f^ypKk?sdK}8&81H');
define('SECURE_AUTH_SALT', 'bXF#5.wmS7swsNDb0eS^Bt}obRG7OQ]`gYPRgX`KQlob6{{Ak_`/3fD[guf)XO}?');
define('LOGGED_IN_SALT',   'uugH%+mFH0o1$|hT-lfAV&G`}t~j]9~ Tp>a;!>aP[}b:ZNIW[J5:mh.#++zQ%dY');
define('NONCE_SALT',       '~}6!J>/qB:*3P}%Dv^5N##!E {O3i3OW~;FlU|U^NZ<E0=9M]@hC-I6f|!)jYHCh');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_m3a9e1y0_';

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
//define('WP_DEBUG', true);
//define('WP_DEBUG_LOG', true);

define('WP_POST_REVISIONS', 10);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
