<?php
/*
Plugin Name: 	Hypecal Ticketing System for Events Manager
Version: 		1.3
Plugin URI: 	https://www.hypecal.com
Description: 	Sell tickets with Events Manager, support any kind of payment cards.
Author: 		hypecal, essfeed
Author URI: 	https://www.hypecal.com/add-events/ess/
*/

require_once( "inc/config/HC_Config.php" );

if ( get_site_option( 'dbem_ms_global_table' ) && is_multisite() )	define( 'HC_MS_GLOBAL', TRUE  );
else																define( 'HC_MS_GLOBAL', FALSE );

add_option( EM_HYPECAL_VERSION_KEY, EM_HYPECAL_VERSION );
add_action( 'plugins_loaded', array( 'EM_HYPECAL', 'init' ) );

final class EM_HYPECAL
{
	protected static $instance;

	function __construct()
    {
        add_action( current_filter(), array( &$this, 'init_plugin' ), 30 );
    }

	public static function init_plugin()
    {
        HC_Config::load_MVC_files();
		HC_Notices::set_notices_global_handler();
		HC_IO::set_filters_handler();
    }

	public static function init()
	{
		if ( !defined( 'EM_VERSION' ) ) return; // EM is not istalled

		is_null( self::$instance ) AND self::$instance = new self;
        return self::$instance;
	}
}

register_activation_hook( 	__FILE__, 	array( 'HC_IO', 'set_activation' 	) );
register_deactivation_hook( __FILE__, 	array( 'HC_IO', 'set_deactivation' 	) );
register_uninstall_hook(    __FILE__, 	array( 'HC_IO', 'set_uninstall' 	) );