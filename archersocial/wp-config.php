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
define('AUTH_KEY',         '1(^O41T$Wk,fM5J5yb<iH@Ld>.DL;l~ssMatdGL$mKTyb| B^^SOpriaiLRsB4k%');
define('SECURE_AUTH_KEY',  '}r*Gub~0FY]aAo2o8[BZzZ7&i-Trau _EDs~7Fn{YcT@dVr1+J4,#FZ;AI^>yMlP');
define('LOGGED_IN_KEY',    'p]Jx {Uqn_zC~aLPS2h{pBM,xtXab[rnj+0!q# ]JudTvTK{CyK!!*/gODRi!_j+');
define('NONCE_KEY',        '`>g3 z| M.|9*ZZ/sj@<a]80gl{ds{sV3?umsLM3}3>kS$c(po3wt3{a;:fuMnKP');
define('AUTH_SALT',        '(]g**rzajt-_N?MYAmg/+=>djdtd-DqjfW`* UuC9R+-8XQof(YD|D[7#`QasUYe');
define('SECURE_AUTH_SALT', '=POL;pN7vG|Y[-Gi+6*=Q wrH~s4SLB/SS|pqG[}#)!@30-p;5dd@6}jsUxIC]ZX');
define('LOGGED_IN_SALT',   'SM0Y*5D+ -~qs|s$_6;Cb(=V|Ja+4Vu26Ew^ KL#_4$tRz=k3hUEwsEeiY8G?dY4');
define('NONCE_SALT',       'n=i#jG|tAaxHfoQ0/a+F>@QCJ3%K-)<gf=+Lty~PA4h[al^[?NP/Cc7Fv3*UGhNs');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
