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
define('DB_NAME', 'db_baz');

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
define('AUTH_KEY', 'X+v^t!=LJ|ay}OZAmDHqmlXM>@QXgep$rIcbv>_zcQ%HlPS{+{J$;M_ktX@LB-UOsJK&-N_[cJ/Wp?(+cAQgoLsA_r<&><ixAU{(C_MgO_g(U=]O;H(J@YOCRnbjmW$P');
define('SECURE_AUTH_KEY', 'Q|QR+)b>QHrwk|(<XlyFivrUvV[tUj[YC]c!IHpQshM)kOo]QyJVF?(!kF/xOOyPiDPh[(^Gt=?edanTrQQ{tE%-V>Zasr^$geL&PpXDEI[(mHetpJ[^mLGq*XjKqLtP');
define('LOGGED_IN_KEY', 'z(fC/-KIsug(oyO=Jv*FzzQ_c{WAodzLhs/&*$@ID|yy<+/*!&^o/-<g{&>wY=nu_vfukC?(GWaT%$Ta-MJ{+Qw?L^i[Av^kbqeUEd*j|RJu)zt=N{S<|Fw^?dI%)?F;');
define('NONCE_KEY', 'GlY?S)bqpwOUUCkGR?yd$/s)$N=?C/t]aTMkBPyBQ]VW/Z;m>(oOeXs}_Ppl)B?^NaTcwi>vT<}?U@Wto<{;]f;MnyPDyx]-Q<UsOktuCwt!<cS[^P]No{jF-dJTB=Kn');
define('AUTH_SALT', 'd@H(*MmHhnfe@qD%>Wcn)n&qJ!%sn>e[>*EyXkyGDcKP@QehL%E>oNlrM+[tEKHfL]eaxix]!&qFz(T{XgqHxpj<wvz*}eCNu)VbDd<oPs!cp-Mu@V(-kPr|gduTP!M]');
define('SECURE_AUTH_SALT', 'c/hY-%=/aos]O<TfVNHMlQ&>Syu+O)yWZ!;OoR&jZ|F_S<SD&ExT+Tet){|PyLc<jlQvBOv$m[]Ba[nCOYP)$$mpb}(bOe-Y<?Rk;>)+seBomS_>;@doGzAb^)^cxBNr');
define('LOGGED_IN_SALT', '/Y>s>b![$NqoH&qt+$Zvo(FtoCEUj)t&{Ok*da<Fkrj)_}y{qi]CzC%N=iORcdPtd}LsaSfHGo$%N&=SEivzXAYuPxw|qwEx|VJHQjF{)TqV^(VZ(}bU?lK{SNFRbSJr');
define('NONCE_SALT', '?bZDv%ZJRw{hSFTL=S_pNaJ;%=%h%fDB?|g>PYp&NQ;jDZTRm@IeU>(b|?|(YCdd*X>obofx>g_V-PLUeE!^/CIkfs/&jdrhtb/Kj;B!h*=iw&MSjK(*{GN(dU]w)UEG');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_gbdo_';

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
