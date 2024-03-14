<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'magazine' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'fZYr`yH)H<rgK]i4vrxv^OpeC>a,LT]h$eEM0zmFQ0_+v$R,9o=uV M;ge,)y3ds' );
define( 'SECURE_AUTH_KEY',  'j)X#s|{~uDT_3w{NlL9}d&6OEPIREo@M6vYp;Y-+K~NQSIwh(sf#{dlf}M,S5h.-' );
define( 'LOGGED_IN_KEY',    'rAtL98>UW aCZ$dU3-7XxU<]E.|FrBEuV7(&<;7UqMr7.QimG8*kBf`vKEL#8I*R' );
define( 'NONCE_KEY',        'P;slZ*$O8@ZlKLZ7@G,qLt8(&KmHwJ*fA]^KJp25;3qfl;0EHpq/_%lG{H}pD.#C' );
define( 'AUTH_SALT',        'q^.d#>f3|#r?mYtO=4dAKC$wt7jd=Dn1fNO/=$Z[l[2pZbCTb>jYR5j6O&WW1Ez+' );
define( 'SECURE_AUTH_SALT', '.m3k9sRz:qROV( k{h|@A<SG;}|R(cVkv|~QoGIggUC-T}d?nJw*4JN<S#W:YA]9' );
define( 'LOGGED_IN_SALT',   'Sd!^n;<+WYHaKjzD!C3n67BBV^MMmY6v4z4EB_BV7VkiBlB]X)S6/@uNz4N~67vs' );
define( 'NONCE_SALT',       '8M1e.ycBH[vvULURos{Ry!qBGiURj^5?o-x]tQy]43QW j&W{ps/t==(n[Z|w,Jp' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
