<?php


if ( defined( 'WP_CLI' ) && WP_CLI ) {
	define( 'WP_DEBUG', false );
	define( 'WP_DEBUG_DISPLAY', false );
	$_SERVER['HTTP_HOST'] = '{{DOMAIN}}';
}


defined( 'WP_CONTENT_DIR' ) or define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/wp-content' );
defined( 'WP_CONTENT_URL' ) or define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/wp-content' );

define( 'WPMDB_LICENCE', '{{WPMDB_LICENCE}}' );

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );

// Use WP normal debug.log
// define('WP_DEBUG_LOG', true);
// OR, set custom error log
define( 'WP_DEBUG_LOG', false );
ini_set( 'log_errors', 1 );
ini_set( 'error_log', dirname( __FILE__ ) . '/logs/wordpress/debug.log' );

define( 'SCRIPT_DEBUG', true );
define( 'JETPACK_DEV_DEBUG', true );

// includes/bootstrap.php:45 defines DISABLE_WP_CRON this which causes an annoying notice. Be sure to define PHPUNIT_RUNNING in local PHPUnit bootstrap
if ( ! defined( 'PHPUNIT_RUNNING' ) ) {
	// Loopback connections can suck, disable if you don't need cron
	define( 'DISABLE_WP_CRON', false );
}

// You'll probably want Automatic Updates disabled during development
define( 'AUTOMATIC_UPDATER_DISABLED', true );

// Disable external calls
//define('WP_HTTP_BLOCK_EXTERNAL', true);
// whitelist some domains from external call block
//define('WP_ACCESSIBLE_HOSTS', 'site1.com, site2.com');

//define('WP_HOME', 'http://xxx');
//define('WP_SITEURL', 'http://xxx/wp');
//define('WP_ALLOW_REPAIR', true);


class PDS_Debug {


	// dump and die - could use more informative header output
	static function dd( $data ) {
		echo '<pre>';
		var_dump( $data );
		echo '</pre>';
		die();
	}


	/**
	 * Logs data to pds.log file
	 *
	 * @param object|string $data
	 * @param string $mode specifies write mode ('a' for append || 'w' for write)
	 * @param boolean $pretty if true, var_export is used
	 * @param boolean $informative if true, informative header is printed
	 */
	static function log( $data, $informative = false, $mode = 'w', $pretty = true ) {
		$file_location = dirname( __FILE__ ) . '/logs/wordpress/dev.log';

		$datetime = new DateTime; // current time = server time
		$otherTZ  = new DateTimeZone( 'Australia/Melbourne' );
		$datetime->setTimezone( $otherTZ ); // calculates with new TZ now

		$bt   = debug_backtrace();
		$file = "Calling file: " . basename( $bt[0]['file'] );
		$line = "Line: " . $bt[0]['line'];

		$info = '';

		if ( $informative ) {
			$info = ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
			$info .= $datetime->format( 'm/d/Y h:i:s a' ) . "\n";
			$info .= $file . "\n";
			$info .= $line . "\n";
			$info .= ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
		}

		// Better boolean logging
		if ( $data === false ) {
			$data = '(bool)FALSE';
		} elseif ( $data === true ) {
			$data = '(bool)TRUE';
		}

		if ( $pretty ) {
			$info .= print_r( $data, true );
		} else {
			$info .= var_export( $data, true );
		}

		$info .= $informative ? "\n\n" : "\n";

		$file = fopen( $file_location, $mode ) or print( '<div style="background-color:#db514d;color:white;text-align:center;padding:10px;">Cannot open dev.log file for logging</div>' );
		fwrite( $file, $info );
		fclose( $file );
	}
}
