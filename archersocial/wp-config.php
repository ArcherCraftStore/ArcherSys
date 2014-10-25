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
define('AUTH_KEY',         'o+[}Uh.U++BQ!YE,^-)7i+o7<qdbRcvst}5>F0=v_peG^UZgIUH$<d>@FYBv+uUU');
define('SECURE_AUTH_KEY',  'VeQR:h dN|w0f=p?C,DVZZi?ISMm1-[s%u9JIPsuOl5]uPU2>9#N_[;/Q`r6x{$7');
define('LOGGED_IN_KEY',    'Ook`~?$x=h5u)( 6B5<MJz-0[*MtX=[G6g4sl|K?F5e/T]undH6,zJl7?}|Wi_;a');
define('NONCE_KEY',        'P!yS6kmponR]({KWA+Lm<H:JaY5+*0He4l{B p*D6xF]RYGJ G&4lW%aC2Ae,0rj');
define('AUTH_SALT',        'ls9`e~00>M:^}pPk{3-fcp9kTP2fFY}bOXx6n4NTaX[%?>@J:IFb%jIbn6xwYo:[');
define('SECURE_AUTH_SALT', 'hYRP1-]K<,H8JHL%bGAMJ$H&E:QoS3*x_*3im_N0C26}|eXP5%I%ot?HES~;shkY');
define('LOGGED_IN_SALT',   'Bidcm!]CBB`.glik3syI0q);|3QY]<)3G?g(I5{bW$Wx%]|z( dL?hY!Qa=GhS{n');
define('NONCE_SALT',       'hVgoWTY a^o5>.S@a6o53OGMpc3yJ~z W?D<[0hzf1R}&$[BRT_Osavwq.K5?cuU');

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
