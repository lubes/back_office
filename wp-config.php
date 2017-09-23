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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'jO7ugbvEyZB5svmKphcODalVBmOh9XIL' );

/** MySQL hostname */
define( 'DB_HOST', '683aa0db9a05d4e8950d0af751acc5344e9df3c3.rackspaceclouddb.com' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'bnjL&[brk|[5QQ@Rzg[Gs*%s-W},^jM$]XD~)FCm,I!M3-A1*iRpQBbqMt7f0-NO');
define('SECURE_AUTH_KEY',  'vxW~$x^WLkD {Ms@oST_x;3!S!wqT~rXN(;S+Y_OD=G1MDzmg2znUK)(r+P//LGq');
define('LOGGED_IN_KEY',    '-Wy.y],+fW+EFg>cc,19Z2XGLlKcn0Z`>5T25 3a8c+dI0QzNk1qbA0jP<@3!U0$');
define('NONCE_KEY',        'VArp&;A+62ZSG!$^9)=9d*h6WdUy-$82gU|D}gv1^?IAOSpxeP/9jm{an(!KZF1d');
define('AUTH_SALT',        'b8(;4`9N|p#=[(8pb3/z$X;RC7-$K$I-U4zz]R|rk0[^-t:#l7?)z+dbkY>el+-d');
define('SECURE_AUTH_SALT', 'XZUWHaV>=g{G1/6> lJo6Tpy+#<{v#N+eaD)W46l!k3@Y<zCHjB9|E,,ylvahf|Z');
define('LOGGED_IN_SALT',   'o^<iyk3qnm>sPp@8N5AFPO|/VK*TFeh?w6zs{e4?U5zoDZ9BqXEJ2YIY2?#RS,X|');
define('NONCE_SALT',       '$<p$iqI#Z(37/i!DQ$m(|m&V0<)zr$pa%RIcs$x-Gtgi4bii7O8 MI[9OONX`aqP');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
