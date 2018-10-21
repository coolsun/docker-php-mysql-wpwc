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
define('DB_NAME', 'wpwcdb');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'password');

/** MySQL hostname */
define('DB_HOST', 'mysql5.6-3326');

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
define('AUTH_KEY', 'vFl&|Fr=axhoJBop/WfwMm)ZKsMu--p/_Ss?y?Nv!]DWBMIBTG?Gd<Rmq}iEn)</G)PwwA]hW?R+-^|jiqUDTob>k-ks?$SPovVd%uF{|+YKHQ+uG/MGjBRqi]TKhOh');
define('SECURE_AUTH_KEY', '$YXiZuE}d_[aolRFaICf$sh<xPm=tCB&%uS+>sgeaH{yXZjXrxl|OYi_zZfog$Y_U-coi!i$*Bps]n]Nm>@t-Y<-W;_<YEaAA]@LIGGhJ=%qN*UhnmLI^E&/UaFh_<}');
define('LOGGED_IN_KEY', 'ubTT+uJ}jxv!AVt/OT=R]}QPW]dB;oHBVuANvf);;Lo<cw=Yo^Ha{r!Pbwgu=]%ElVepss$uWcOe]$KV@a?;|x|b@BS=onIKBrqQ&+Wa]An$*BCOhXkmKBMLXlN)_fU');
define('NONCE_KEY', 'pNqXSBzJ)ajJz+Y}!Xw@=vYy+!Qh=tylOs|kV|p)eyv}fhS^}/]BN]be(=|bo!__;w>V_?hjVW_O/sxi]&d)i)KpURnquEZEUUvTTLYZp+wvn{a_liY/^>oh/rCpN(j');
define('AUTH_SALT', 'UI>!uwvW|=PlQ]JE-^ou}/jqMB$><t]B<e<Z><fb}ddH+;iZ_Uzm;T)TV/KbIMPRt]rhwcvwZfaszzGiBaI[!l|JskrUYUBx]V><T$WtZi)M?^Grz^!eHJl%Ws+|X+z');
define('SECURE_AUTH_SALT', 'NT/w;NNqi?Fb_!+Mnnm*BNtvpI{$ukUbnMmUXso=%gBFMzs{w(kPgPOrCI[ILOuHXSx}Hpoo(lYnp{K/zcYt[H&Z_nc@Hck)}kOOa-!vN*LQ^|)wfG]HQ?ARCtO{K[D');
define('LOGGED_IN_SALT', '^RDpWzmK?[GA_BzPX^yxG]DG[yoYtUx&bk_xbR-dkhZUJKUK[;Yj(*i_/OrrZk]ljZ?-?dP>w<qv<=*VT@I;FG>&!luF$bUrSZpP;mr(+rZk]AhyKvObl}HnC;*UTyC');
define('NONCE_SALT', 'P/k$o]_tD=!UTr^z=cSSGG|utx%%]EfqplCJ+HtbVu]uB$Bd;MXfFMgOhkTTit=lfdi[sy@r[iv$ANhYZNZc)e=OuRYKIeEeGYViAyrTn([zmIKwjdYPY^Ma!{ZCF]$');

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
