<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
/**
  * Model HC_IO (Input/Output)
  * Manage the I/O between user, local server and web-services
  *
  * @author  	Hypecal.com
  * @copyright 	Copyright Hypecal.com
  * @license   	https://www.hypecal.com/terms/
  */
final class HC_IO
{
	public static function set_filters_handler()
	{
		if ( has_filter( 'the_content', 'em_content' ) )
		{
			add_filter( 'em_content', 					array( 'HC_Elements', 		'get_output_single' 	) );
			add_filter( 'em_event_output_single', 		array( 'HC_Orders', 		'get_tickets_form' 		) );
		}

		//add_filter( 'em_booking_form_before_tickets', array( 'HC_Orders', 		'get_tickets_form' 		) );

		if ( is_admin() )
		{
			add_action( 'admin_menu', 	 				array( 'HC_IO',				'set_submenu' 			) );
			add_action( "wp_ajax_get_popup_content",	array( 'HC_API', 			'get_popup_content' 	) );
			add_action( "wp_ajax_get_webservice",		array( 'HC_API', 			'get_webservice' 		) );

			add_filter( 'em_deactivate', 				array( 'EM_HYPECAL', 		'set_deactivation' 		) );
			add_action( 'em_events_admin_bookings_footer',array( 'HC_Admin',		'get_tickets_form' 		) );
			add_action( 'admin_print_styles', 			array( 'HC_IO', 			'set_admin_em_styles'	) );

			// -- edit an event
			if ( @$_GET[ 'action' ] == 'edit' )
			{
				add_action(	'admin_print_scripts', 		array( 'HC_IO',				'set_admin_event_scripts'	) );
				add_action( 'admin_print_styles', 		array( 'HC_IO', 			'set_admin_event_styles'	) );
			}

			// -- booking section
			else if ( preg_match_all( "/".HC_Constants::EM_HC_ARGUMENT."/", @$_GET[ 'page' ] ) > 0 )
			{
				add_action(	'admin_print_scripts', 		array( 'HC_IO',				'set_admin_bookings_scripts' ) );
				add_action( 'admin_print_styles', 		array( 'HC_IO', 			'set_admin_bookings_styles'	 ) );
				add_action( 'admin_init',				array( 'HC_API', 			'set_authorize' 			 ) );
			}
		}
		else
		{
			// -- event booking widget
			add_action( 'wp_print_scripts', 			array( 'HC_IO', 			'set_web_scripts'		) );
			add_action( 'wp_print_styles', 				array( 'HC_IO', 			'set_web_styles'		) );
		}
	}

	private static function get_root()
	{
		return ( ( $_SERVER[ 'HTTP_HOST' ] == 'localhost' )? HC_Constants::HYPECAL_DEV : HC_Constants::HYPECAL_WEBSITE );
	}

	public static function get_geo()
	{
		$geo_ = array();

		if ( $geo_ = wp_cache_get( 'geo', HC_Constants::EM_HC_ARGUMENT ) === FALSE )
		{
			$geo_ = @FeedWriter::get_geo();
			wp_cache_set( 'geo', $geo_, HC_Constants::EM_HC_ARGUMENT, 3600*24 );
		}

		return $geo_;
	}


	// -- scripts

	private static function set_common_scripts()
	{
		$l = @get_bloginfo( 'language' );
		$language = strtolower( $l{0}.$l{1} );

		$root = self::get_root();
		$geo_ = self::get_geo();

		wp_enqueue_script(  'google-map', 			'//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places' );
		wp_enqueue_script(  'hc-global-libs', 		$root . '/assets/js/commons/hc.dependencies.global.min.js', FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-global', 			$root . '/assets/js/commons/hc.global.js', 					FALSE, EM_HYPECAL_VERSION, TRUE );

		wp_localize_script( 'hc-global', 'Geo', apply_filters( 'hc_wp_localize_script', array(
			'IP' 			=> @$_SERVER['SERVER_ADDR'],
			'country_code'	=> $geo_[ 'country_code' ],
			'city'			=> $geo_[ 'city' ],
			'lat'			=> $geo_[ 'lat' ],
			'lng'			=> $geo_[ 'lng' ]
		) ) );

		wp_localize_script( 'hc-global', 'global_vars', apply_filters( 'hc_wp_localize_script', array(
			'CORS' 		=> TRUE,
			'HC_DOM'	=> ( ( $_SERVER[ 'HTTP_HOST' ] == 'localhost' )? HC_Constants::HYPECAL_DEV : HC_Constants::HYPECAL_WEBSITE ),
			'HC_ROOT_ASSETS' => EM_HYPECAL_DIR_URI . 'assets/',
			'ROOT' 		=> EM_HYPECAL_PROTOCOL . @$_SERVER[ 'HTTP_HOST' ] . ( ( $_SERVER[ 'HTTP_HOST' ] == 'localhost' )? ':8080' : '' ),
			'SELF' 		=> @$_SERVER[ 'REQUEST_URI' ],
			'API'  		=> admin_url( 'admin-ajax.php' ),
			'LANG' 		=> $language
		) ) );
	}

	public static function set_admin_event_scripts()
	{
		$root = self::get_root();
		self::set_common_scripts();
		wp_enqueue_script(  'hc-account-libs', 		$root . '/assets/js/commons/hc.dependencies.account.min.js',FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-events-libs', 		$root . '/assets/js/commons/hc.dependencies.events.min.js',	FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-event-edit', 		$root . '/assets/js/popups/events/popup_event_edit.js', 	FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-account-tickets', 	$root . '/assets/js/account/account_tickets.js', 			FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-account-taxes', 	$root . '/assets/js/account/account_taxes.js', 				FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-account-events', 	$root . '/assets/js/account/account_events.js', 			FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-admin-events', EM_HYPECAL_DIR_URI . 'assets/js/hc_admin_events.js', 			FALSE, EM_HYPECAL_VERSION, TRUE );
	}

	public static function set_admin_bookings_scripts()
	{
		$root = self::get_root();
		self::set_common_scripts();
		wp_enqueue_script(  'hc-account-libs', 		$root . '/assets/js/commons/hc.dependencies.account.min.js',FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-account-tickets', 	$root . '/assets/js/account/account_tickets.js', 			FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-account-finance', 	$root . '/assets/js/account/account_finance.js', 			FALSE, EM_HYPECAL_VERSION, TRUE );
		//wp_enqueue_script(  'hc-account-taxes', 	$root . '/assets/js/account/account_taxes.js', 				FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-account-attendees', $root . '/assets/js/account/account_attendees.js', 			FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-admin-bookings', EM_HYPECAL_DIR_URI . 'assets/js/hc_admin_bookings.js', 		FALSE, EM_HYPECAL_VERSION, TRUE );
	}

	public static function set_web_scripts()
	{
		$root = self::get_root();
		self::set_common_scripts();
		wp_enqueue_script(  'hc-global-order', 	$root . '/assets/js/commons/hc.orders.js', 		FALSE, EM_HYPECAL_VERSION, TRUE );
		wp_enqueue_script(  'hc-order', 		EM_HYPECAL_DIR_URI . 'assets/js/hc_order.js', 	FALSE, EM_HYPECAL_VERSION, TRUE );
	}



	// -- styles

	public static function set_admin_em_styles()
	{
		wp_enqueue_style( 'hc-admin-em', EM_HYPECAL_DIR_URI. 'assets/css/hc_admin_em.css', FALSE, EM_HYPECAL_VERSION, 'all' );
	}

	private static function get_common_style()
	{
		$root = self::get_root();
		wp_enqueue_style( 'font-awesome', ( ( $_SERVER[ 'HTTP_HOST' ] == 'localhost' )? $root . '/assets/css/ext/font-awesome.min.css' : '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' ), FALSE, EM_HYPECAL_VERSION, FALSE );
		wp_enqueue_style( 'hc-jquery-ui', $root . '/assets/css/ext/jquery-ui-1.10.0.custom.css',	FALSE, EM_HYPECAL_VERSION, FALSE );
		wp_enqueue_style( 'hc-global-ui', $root . '/assets/css/commons/hc.dependencies.global.css',	FALSE, EM_HYPECAL_VERSION, FALSE );
	}

	public static function set_admin_bookings_styles()
	{
		$root = self::get_root();
		self::get_common_style();
		wp_enqueue_style( 'hc-global',			$root . '/assets/css/commons/hc.global.css',				FALSE, EM_HYPECAL_VERSION, FALSE );
		wp_enqueue_style( 'hc-account-setup',	$root . '/assets/css/account/account_setup.css',			FALSE, EM_HYPECAL_VERSION, FALSE );
		wp_enqueue_style( 'hc-account-events',	$root . '/assets/css/account/account_events.css',			FALSE, EM_HYPECAL_VERSION, FALSE );
		wp_enqueue_style( 'hc-account-tickets',	$root . '/assets/css/account/account_tickets.css',			FALSE, EM_HYPECAL_VERSION, FALSE );
		wp_enqueue_style( 'hc-account-finance',	$root . '/assets/css/account/account_finance.css',			FALSE, EM_HYPECAL_VERSION, FALSE );
		wp_enqueue_style( 'hc-admin', EM_HYPECAL_DIR_URI. 'assets/css/hc_admin.css', 						FALSE, EM_HYPECAL_VERSION, FALSE );
	}

	public static function set_admin_event_styles()
	{
		$root = self::get_root();
		self::get_common_style();
		wp_enqueue_style( 'hc-account-events-edit',	$root. '/assets/css/popups/events/popup_event_edit.css',FALSE, EM_HYPECAL_VERSION, FALSE );
		wp_enqueue_style( 'hc-admin', EM_HYPECAL_DIR_URI. 'assets/css/hc_admin.css', 						FALSE, EM_HYPECAL_VERSION, FALSE );
	}

	public static function set_web_styles()
	{
		$root = self::get_root();
		self::get_common_style();
		wp_enqueue_style( 'hc-order', EM_HYPECAL_DIR_URI. 'assets/css/hc_order.css', 						FALSE, EM_HYPECAL_VERSION, 'all' );
	}




	public static function set_submenu()
	{
		$plugin_pages = array();

	   	$plugin_pages[ 'bookings' ] = add_submenu_page(
	   		'edit.php?post_type='.( ( defined( 'EM_POST_TYPE_EVENT' ) )? EM_POST_TYPE_EVENT : 'event' ),
	   		__('Manage events booking orders, custom tickets, custom forms and attendees','dbem'),
	   		__('Bookings','dbem'),
	   		'list_users',
	   		HC_Constants::NAME . "-bookings",
	   		array( 'HC_Admin', 'bookings_page' )
		);

		/*
		$plugin_pages[ 'sync' ] = add_submenu_page(
	   		'edit.php?post_type='.( ( defined( 'EM_POST_TYPE_EVENT' ) )? EM_POST_TYPE_EVENT : 'event' ),
	   		__('Sync events with other events portals','dbem'),
	   		__('Broadcast','dbem'),
	   		'list_users',
	   		HC_Constants::NAME . "-sync",
	   		array( 'HC_Admin', 'sync_page' )
		);
		*/

		$plugin_pages = apply_filters( 'em_create_events_submenu', $plugin_pages );
	}

	public static function set_activation()
	{
		flush_rewrite_rules();

		if ( current_user_can( 'activate_plugins' ) == FALSE )
            return;

        $plugin = isset( $_REQUEST[ 'plugin' ] ) ? $_REQUEST[ 'plugin' ] : HC_Constants::NAME;
        check_admin_referer( "activate-plugin_{$plugin}" );

		if ( !HC_MS_GLOBAL || ( HC_MS_GLOBAL && is_main_blog() ) )
			HC_Database::createTable();
	}

	public static function set_deactivation()
	{
		if ( current_user_can( 'activate_plugins' ) == FALSE )
        	return;

        $plugin = isset( $_REQUEST[ 'plugin' ] ) ? $_REQUEST[ 'plugin' ] : EM_ESS::NAME;
        check_admin_referer( "deactivate-plugin_{$plugin}" );

		// -- remove DB while desactivating the plugin
		if( !HC_MS_GLOBAL || (HC_MS_GLOBAL && is_main_blog()) )
			HC_Database::deleteTable();
	}

	public static function set_uninstall()
    {
        if ( current_user_can( 'activate_plugins' ) == FALSE )
            return;

        check_admin_referer( 'bulk-plugins' );

		if( !HC_MS_GLOBAL || (HC_MS_GLOBAL && is_main_blog()) )
			HC_Database::deleteTable();

		// -- Remove Schedule Hook (CRON tasks)
		//wp_clear_scheduled_hook( 'daily_event_hook' );

		// Important: Check if the file is the one
        // that was registered during the uninstall hook.
        if ( __FILE__ != WP_UNINSTALL_PLUGIN )
            return;
    }

	/**
     * Get a usable temp directory
     *
     * Adapted from Solar/Dir.php
     * @author Paul M. Jones <pmjones@solarphp.com>
     * @license http://opensource.org/licenses/bsd-license.php BSD
     * @link http://solarphp.com/trac/core/browser/trunk/Solar/Dir.php
     *
     * @return string
     */
    public static function tmp()
    {
        static $tmp = null;

        if ( !$tmp )
        {
            $tmp = function_exists( 'sys_get_temp_dir' )? sys_get_temp_dir() : self::_tmp();
			$tmp = rtrim( $tmp, DIRECTORY_SEPARATOR );
        }
        return $tmp;
    }

    /**
     * Returns the OS-specific directory for temporary files
     *
     * @author Paul M. Jones <pmjones@solarphp.com>
     * @license http://opensource.org/licenses/bsd-license.php BSD
     * @link http://solarphp.com/trac/core/browser/trunk/Solar/Dir.php
     *
     * @return string
     */
    protected static function _tmp()
    {
        // non-Windows system?
        if ( strtolower( substr( PHP_OS, 0, 3 ) ) != 'win' )
        {
            $tmp = empty($_ENV['TMPDIR']) ? getenv( 'TMPDIR' ) : $_ENV['TMPDIR'];
            return ($tmp)? $tmp : '/tmp';
        }

        // Windows 'TEMP'
        $tmp = empty($_ENV['TEMP']) ? getenv('TEMP') : $_ENV['TEMP'];
        if ($tmp) return $tmp;

        // Windows 'TMP'
        $tmp = empty($_ENV['TMP']) ? getenv('TMP') : $_ENV['TMP'];
        if ($tmp) return $tmp;

       	// Windows 'windir'
        $tmp = empty($_ENV['windir']) ? getenv('windir') : $_ENV['windir'];
        if ($tmp) return $tmp;

        // final fallback for Windows
        return getenv('SystemRoot') . '\\temp';
    }



}