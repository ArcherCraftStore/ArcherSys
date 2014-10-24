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
define('DB_NAME', 'acoserver_acoserver');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'aco1234');

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
define('AUTH_KEY',         '~k*M-~[o(RVY~9RadQLTd1?bI%tg)[4IB>VCZ:RF. sHqh#}I*_esMSix]#QIc,k');
define('SECURE_AUTH_KEY',  'D:9E>hoy;EqN(AAkbbB@0-CnyW=[^`Sr]~Rwsx*f6O C r*{?23Y/.GnX6M*JPO8');
define('LOGGED_IN_KEY',    'pH=fW9a&5f#4@Rj)XZe2ABlqU){0?D`s_s?.mbkAEo&4HF17_hc_lNs[`#oBV0Bx');
define('NONCE_KEY',        '_.@n],KK@XsU&/@`]HxHEcaC^(t90T(M,mgOzh}}(]_A~8-2GnsEP0`EGFYIBV4E');
define('AUTH_SALT',        'U%t;mq]h!13jp[zs9Q7J99Wo9nhuT{Wnm+@EA%O{L2AIwj:TZIJu+1-G).~fR37u');
define('SECURE_AUTH_SALT', '[K E5f#qTuAs!dJ|jT@ckf0P>=#ZZ8,6SACYM?SQUg$5R)H$i_ >W 6q@}j{dRUu');
define('LOGGED_IN_SALT',   '.-y=qxJ%k.tgI^SQ<QNY~cXSnQ/Bz;?p&!$|%eb+@^1tWuagvr3hZ9}7nnY*@|04');
define('NONCE_SALT',       '$XS hH:/Er Eri74=]JVhihKG2uIxG)bq9T4RgFc]8wt/K,Q~m_S]hyiQe%`FL@S');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'asoswp_';

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
