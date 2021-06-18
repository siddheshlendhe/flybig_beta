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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         'vHithtwmZRYiOo1tH3PQDzv4Tphg5xET7nHDZbfiSCZcb6yIIiqu48XFSk2OHP5ZuPkLsi+0aTCD5RMfIb9Ivw==');
define('SECURE_AUTH_KEY',  'k8zKqmhJDyBt0Tzy3QeKyRDsERbQXobNgKnSvttomMJ5iYlq+arZpeKmP/pb883eIwbfbqWArNCdzJrnPxpptg==');
define('LOGGED_IN_KEY',    'XRPvg013kkbQPpKJawTW/BzRXOt+PVQdmtqi9K+pBIpA888v3xLmXIvwyzP9cO9PkQXSkcVtKp51Ds9K6zyjxw==');
define('NONCE_KEY',        'EPYXktKAbjFUUjK5DudiD02U07xL8vu/8NkJtkiT3B/78pZOuNJXFIgjKxHEiGsYsEXSNp+mkfXsZDVc647tVw==');
define('AUTH_SALT',        '+GzIz+VNkRMlvixRP5oafVnvE3mSASEweTrowRCaGjkC08xGtSs/vu/GlNo+yjqFUODfW9h5H0yfqc4vqYXsSw==');
define('SECURE_AUTH_SALT', 'tUjDa49wUdkngrtMo19BVghGzHn2wXjqjxA8UCDzN9bNrP6nBZQAnux0EjENw1sNxU5j43T5+51F9x68u2v7+g==');
define('LOGGED_IN_SALT',   'P0EyUkqvNtrRnMFQPpoECKdRhesr/aWtzoDE7+URLVBdjc6ym7I+MTwv9Zm50j3oZYF4kSSKmxOXu5jths11Cg==');
define('NONCE_SALT',       'phLZPfBixbTboYxHNu00MkV7gA2x4IyrzroaAjqb9tYcgjyIuNAk3cm02LLe7IEwWMCsHDLhEWh32Ew9eT8BLA==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
