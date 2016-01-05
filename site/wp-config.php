<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sgc');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '}j~s&d|fgs+J]>HX7(.i,maPclN[f| 2pY9t9,@485uCq^yCRweom]|e#Y~%D&;k');
define('SECURE_AUTH_KEY',  'Sjh7)C1?narCgcf#b?{I.f/E%$[Ft+0Hy`w:gb{=~81oE1G+LQpOsY^`br|gavnX');
define('LOGGED_IN_KEY',    '5UxZR-ICWC1wQ,|_W{cfEGcho:5f5UB:JiK2$i])yI:idlYfCM1r-|j1tN&/_K4M');
define('NONCE_KEY',        'TpE6U |/U}mr&~]AhGROF|+;OT i-i*l5*OmowQt@nZ%)2HdCb6;-)%a{-(rlBy<');
define('AUTH_SALT',        '=dk6k|*0BQbz_mVc0W7s)UToH1Jhliy0YHX/<+=X[;/<&|?)@qtDRm`TE4;{pCAK');
define('SECURE_AUTH_SALT', 'c|L Q%M;6dHAOR$sW4dfjBI)aqR+>2Vygpy!s@cMZrwX2mv-U*+%Uw7m%++rd-&^');
define('LOGGED_IN_SALT',   'c5mZve31F<$w}Mw7j{U!AR3J({ds)=?Co<-`K^o*>w~p)Y;h*vo<mC7f$}){TW4@');
define('NONCE_SALT',       'B.K+kt/mlmG!a[Vwnb=i^|3dU7|[57|+hhD/iB-=rq-)6jNveO^=j@^w7XTDescw');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
