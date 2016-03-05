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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'P*C}LB:~NtGuB_qwx>o`;}WF+4VAA.Ht}3xJ~]pr>u6~|r8~-}8S/OOnY]C](+zy');
define('SECURE_AUTH_KEY',  '|, s-G`S*fh7HhO+ku.wDN/(D,zAACn>k<3%TZ#N.d+W/{`BRWdn`W*RgLw,EV{}');
define('LOGGED_IN_KEY',    '*{d?Qp:A2[jdrUR039QsE:uuH&RwrR7QxAxi-J.>Y!fkZkPuN3nmR}m0,$* qIcP');
define('NONCE_KEY',        'I.6>{kf3zIg*Fo9]!w2r&`$JCR;+q0p[nJq[9YE_.x>k+=v&SU6wYP!^}XCN9UG@');
define('AUTH_SALT',        '.:_O}e)||<A#W/Va1`4GJ(~zLx*)YCpYL1vV:5!$0-C_KY|g{{M&8PDXpeGppl*$');
define('SECURE_AUTH_SALT', 'twtK$v<N]`IAJ|n4!<_]MWa0!o~GHJa>qD=,LX@yyW!Y=,g/yxoc.Du|=UC3cuI0');
define('LOGGED_IN_SALT',   'KOp`Pt;Tp9mJh7oX!qEe#g;pVzp;8h&aZA^M)^+`gO&-|`SwQLA/H]4-ME=Gr%GM');
define('NONCE_SALT',       '!{Y:6`||o`8-Uoh4F0-<x?MB$q>+*SS<qe+beZ8NHcG+-KrWH+B_c|a-po5a6JO&');

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
