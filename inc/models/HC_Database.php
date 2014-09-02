<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
/**
  * Model Hypecal_Database
  * Connecting interface with the database
  *
  * @author  	Hypecal.com
  * @copyright 	Copyright Hypecal.com
  * @license 	https://www.hypecal.com/terms/
  * @link		https://www.hypecal.com
  **/
final class HC_Database
{
	const TABLE_NAME = 'em_hypecal_credentials';

	private static $wpdb 	= NULL;
	private static $table 	= "";
	private static $sql 	= "";

	public function __construct()
	{
		self::init();
	}

	private static function init()
	{
		if ( strlen( self::$table ) <= 0 )
		{
			global $wpdb;
			if ( !isset( $wpdb ) ) $wpdb = $GLOBALS[ 'wpdb' ];
			self::$wpdb = $wpdb;

			self::$wpdb->show_errors();

			if ( HC_MS_GLOBAL )	$prefix = self::$wpdb->base_prefix;
			else 				$prefix = self::$wpdb->prefix;

			self::$table = $prefix . self::TABLE_NAME;
		}
	}

	private static function add_error( $errors )
	{
		global $HC_Notices;
		$HC_Notices->add_error( $errors );
	}

	public static function createTable()
	{
		self::init();

		if ( @count( self::$wpdb->get_results( "SHOW TABLES LIKE '".self::$table."';" ) ) >= 1 )
			return;

		self::$sql =
		" CREATE TABLE " . self::$table .
		" (
			api_token	 	VARCHAR( 255 ) 	CHARACTER SET utf8 COLLATE utf8_unicode_ci 	NOT NULL,
			api_refresh		VARCHAR( 255 ) 	CHARACTER SET utf8 COLLATE utf8_unicode_ci 	NOT NULL,
			api_expiry		DATETIME												 	NOT NULL,
			api_timestamp	DATETIME 													NOT NULL,
			PRIMARY KEY `api_token`   	(`api_token`),
			UNIQUE	KEY `api_refresh` 	(`api_refresh`)
		) CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( self::$sql );
	}

	public static function deleteTable()
	{
		self::init();

		self::$sql = 'DROP TABLE ' . self::$table ;

		return ( ( self::$wpdb->query( self::$sql ) === FALSE )? FALSE : TRUE );
	}



	public static function get( Array $DATA_ = NULL )
	{
		$a_ = array();

		self::init();

		self::$sql =
		" SELECT * " .
		" FROM " . self::$table .
			( ( isset( $DATA_[ 'api_token' ] 	) )? " WHERE api_token = " .	self::$wpdb->prepare( "%s", $DATA_[ 'api_token' ] 	) : "" ) .
			( ( isset( $DATA_[ 'api_refresh' ]	) )? " AND 	 api_refresh = ". 	self::$wpdb->prepare( "%s", $DATA_[ 'api_refresh' ]	) : "" ) .
			( ( isset( $DATA_[ 'api_expiry' ]	) )? " AND 	 api_expiry = ". 	self::$wpdb->prepare( "%s", $DATA_[ 'api_expiry' ]	) : "" ) .
		" ORDER BY api_timestamp DESC LIMIT 0,1;";

		//self::add_error( self::$sql );

		foreach ( self::$wpdb->get_results( self::$sql, OBJECT_K ) as $key => $el )
		{
			array_push( $a_, array(
				'api_token'		=> $el->api_token,
				'api_refresh'	=> $el->api_refresh,
				'api_expiry'	=> $el->api_expiry,
				'api_timestamp'	=> $el->api_timestamp
			) );
		}

		return $a_;
	}

	public static function add( Array $DATA_=NULL )
	{
		self::init();

		if ( !empty( $DATA_ ) )
		{
			$result = self::delete(); // to prevent duplicate entries

			self::$sql =
			" INSERT INTO " . self::$table . //IGNORE
			" ( ".
				( ( isset( $DATA_[ 'api_token' ] 	) )? "api_token," 	: "" ) .
				( ( isset( $DATA_[ 'api_refresh'] 	) )? "api_refresh," : "" ) .
				( ( isset( $DATA_[ 'api_expiry'] 	) )? "api_expiry," 	: "" ) .
												 		 "api_timestamp".
			" ) VALUES ( " .
				( ( isset( $DATA_[ 'api_token' ] 	) )? self::$wpdb->prepare( "%s", $DATA_[ 'api_token' ] 	 ) . "," : "" ) .
				( ( isset( $DATA_[ 'api_refresh'] 	) )? self::$wpdb->prepare( "%s", $DATA_[ 'api_refresh' ] ) . "," : "" ) .
				( ( isset( $DATA_[ 'api_expiry'] 	) )? self::$wpdb->prepare( "%s", $DATA_[ 'api_expiry' ]  ) . "," : "" ) .
				"'" . 											 date( "Y-m-d H:i:s" ) 						   . "' " .
			" ) " .
			( ( isset( $DATA_[ 'api_token' ] ) )?
				" ON DUPLICATE KEY UPDATE ".
				( ( isset( $DATA_[ 'api_token' ] 	) )? "api_token = " . 	 	self::$wpdb->prepare( "%s", $DATA_[ 'api_token' ] 	) . "," : "" ) .
				( ( isset( $DATA_[ 'api_refresh' ] 	) )? "api_refresh = " . 	self::$wpdb->prepare( "%s", $DATA_[ 'api_refresh' ] ) . "," : "" ) .
				( ( isset( $DATA_[ 'api_expiry' ] 	) )? "api_expiry = " . 		self::$wpdb->prepare( "%s", $DATA_[ 'api_expiry' ]	) . "," : "" ) .
														 "api_timestamp = '". 	date( "Y-m-d H:i:s" ) 								  . "' "
				:
				""
			);

			//self::add_error( self::$sql );

			return ( ( self::$wpdb->query( self::$sql ) === FALSE )? FALSE : TRUE );
		}

		//self::add_error( self::$wpdb->last_error );

		return FALSE;
	}

	public static function delete( Array $DATA_ = NULL )
	{
		self::init();

		self::$sql =
		" DELETE " .
		" FROM ". self::$table . " " .
			( ( isset( $DATA_[ 'api_token' ] 	) )? " WHERE api_token	 = " . self::$wpdb->prepare( "%s", $DATA_[ 'api_token' ] 	) : "" ) .
			( ( isset( $DATA_[ 'api_refresh' ] 	) )? " AND   api_refresh = " . self::$wpdb->prepare( "%s", $DATA_[ 'api_refresh' ]	) : "" ) .
		";";

		//self::add_error( self::$sql );

		return ( ( self::$wpdb->query( self::$sql ) === FALSE )? FALSE : TRUE );
	}

	public static function set_option( $name=NULL, $value=NULL )
	{
		if ( $name !== NULL && $value !== NULL )
		{
			update_option( $name, $value );
			return true;
		}
		return false;
	}

	public static function get_option( $name=NULL, $default='' )
	{
		return ( $name !== NULL )? stripcslashes( strip_tags( esc_html( ( strlen( get_option( $name ) ) > 0 )? get_option( $name, $default ) : $default ) ) ) : $default;
	}

}