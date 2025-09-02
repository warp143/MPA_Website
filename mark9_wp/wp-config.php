<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mark9_wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '(|6v<:txj~Qm.yO1^F5@,|XzwHN_M2s/AM;CtRDIdk1F$rtCgROU~3M?b5n7(ZE,');
define( 'SECURE_AUTH_KEY',  ';eU_3{U+uL2t}1&olN%B4b.9JNa=%e0^}xu*ym^20b]4f.=O$+1NtKUp)iV CKMW');
define( 'LOGGED_IN_KEY',    'EC|=})+MuwIRa4_;iR*u5$dE-2)8:1Hgq`R<76nnPy2HFH|-L+Z`)TUj6 2((8Bw');
define( 'NONCE_KEY',        'D6Dx:J6d}D}P;0>*a56~Ywi--|m9zDChX9x4B+KGlQI5cLI=PfO5Pt|J7RVG@sh!');
define( 'AUTH_SALT',        '=$/n|Apor(@-s-l/=0?Z+1:en(3+:h08m9vO-+2L vws)AI?N@7$N+b40+w-XKt.');
define( 'SECURE_AUTH_SALT', 'RQP&{6F[D~ZO%dWU|n0M#)TH8P `+VMXaE)p#1>|1=vd<GH4GMN+y:_6$uLL:*=J');
define( 'LOGGED_IN_SALT',   '1jE]J-Ww]czn;`X4:>pYZJ[0*Xi0gzH+^o;FTQ`z# ne[4Z_qH[*PE)[|XW6,|i{');
define( 'NONCE_SALT',       '&HAKh2pU@Fy?c i+NPHr%pr|uc}5HoWsqM/h+CF9bY-n=Ss~8gI]z=qs+}6mISZf');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
