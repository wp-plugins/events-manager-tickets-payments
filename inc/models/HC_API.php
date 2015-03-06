<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
/**
  * Controller HC_API
  * Control user interaction with the Hypecal OAuth2 API
  *
  * @author  	Hypecal.com
  * @copyright 	Copyright Hypecal.com
  * @link    	https://www.hypecal.com/terms/
  */
final class HC_API extends HC_OAuth2
{
	var $client_id 			= '1/lB0uoIL16dlip0RT/tUg==';
	var $client_secret		= 'DWa3TCDETKOcSMBFpy8zNw==';
	var $redirect_uri		= '';

	var $oauth_version 		= '2.0';
	var $dialog_url			= 'https://www.hypecal.com/authorize?response_type=code&client_id={CLIENT_ID}&redirect_uri={REDIRECT_URI}&scope={SCOPE}&state={STATE}';
	var $access_token_url 	= 'https://www.hypecal.com/access_token';
	var $scope				= '';

	const ENDPOINT			= 'https://www.hypecal.com/api/v1/';

	var $debug 				= TRUE;
	var $debug_http 		= TRUE;
	var $session_started 	= FALSE;

	private static $client = NULL;

	function __construct(){}

	private static function get_redirect()
	{
		return 'http' . ( ( isset( $_SERVER['HTTPS'] ) )? 's' : ''  ) . '://' . @$_SERVER[ 'HTTP_HOST' ] . @$_SERVER[ 'REQUEST_URI' ];
	}

	public static function set_authorize()
	{
		$success = FALSE;

		if ( isset( $_GET[ 'code' ] ) )
		{
			if ( @$_GET[ 'error' ] == 'access_denied' )
				$r = HC_Database::delete();

			$local_ = HC_Database::get();
			$local  = @$local_[0];

			if ( strlen( @$local->api_token ) > 0 )
				return TRUE;

			if ( self::$client == NULL )
				self::$client = new HC_API;

			if ( self::$client->debug == TRUE )
				self::$client->ResetAccessToken();

			if ( strtolower( $_GET[ 'code' ] ) == 'oauth2' )
			{
				$user = @wp_get_current_user();

				if ( isset( $user->data ) )
				{
					if ( FeedValidator::isValidEmail( @$user->data->user_email ) == TRUE )
					{
						$l 				= @get_bloginfo( 'language' );
						$language 		= strtolower( $l{0}.$l{1} );
						$geo_ 			= HC_IO::get_geo();
						$country_code 	= ( ( strlen( @get_option( 'dbem_location_default_country' ) ) > 1 )? get_option( 'dbem_location_default_country' ) : @$geo_['country_code'] );

						self::$client->dialog_url .=
							"&auto_signin=".	( ( @count( $local_   ) >  0 )? 'yes' 	  : '' ) .
							"&language=". 		( ( strlen( $language ) == 2 )? $language : '' ) .
							"&email=" . 		@$user->data->user_email .
							"&first_name=". 	@$user->data->user_nicename .
							"&city=". 			@$geo_[ 'city' ] .
							"&latitude=". 		@$geo_[ 'lat' ] .
							"&longitude=". 		@$geo_[ 'lng' ] .
							"&zip=". 			@$_SERVER[ 'GEOIP_POSTAL_CODE' ] .
							"&country_code=". 	$country_code .
							"&phone=".			@$user->data->phone;
					}
				}
			}

			self::$client->redirect_uri = self::get_redirect();

			if ( ( $success = self::$client->Initialize() ) )
			{
				if ( ( $success = self::$client->Process() ) )
				{
					//dd( self::$client );

					if ( strlen( self::$client->access_token ) > 0 )
					{
						if ( HC_Database::add( array(
							'api_token' 	=> self::$client->access_token,
							'api_refresh'	=> self::$client->refresh_token,
							'api_expiry'	=> self::$client->access_token_expiry
						) ) )
						{
							$success = self::$client->Finalize( $success );
						}
					}
					?><script type="text/javascript">
						window.onload = hc_rp;function hc_rp()
						{
							window.opener.location.reload();
							window.close();
						}
					</script><?php die;
				}
			}
		}
		return $success;
	}

	public static function call( $service, Array $params_ = NULL, $action = 'GET', $contentType='application/json' )
	{
		$el = NULL;

		if ( self::$client == NULL )
			self::$client = new HC_API;

		$local_ = HC_Database::get();
		$local_ = @$local_[0];
		if ( strlen( $local_[ 'api_token' ] ) > 0 )
		{
			self::$client->access_token			= $local_[ 'api_token'   ];
			self::$client->refresh_token		= $local_[ 'api_refresh' ];
			self::$client->access_token_expiry	= $local_[ 'api_expiry'  ];

			$params_[ OAUTH2_TOKEN_PARAM_NAME ] = self::$client->access_token;

			if ( strlen( self::$client->access_token ) > 0 )
			{
				$options_ = array(
					'FailOnAccessError' 	=> self::$client->debug,
					//'ConvertObjects' 		=> TRUE,
					//'DecodeXMLResponse' 	=> FALSE,
					'ResponseContentType'	=> $contentType
				);

				//d( $_FILES[ 'files' ] );

				if ( @count( @$_FILES[ 'files' ] ) > 0 )
				{
					$action = 'POST';
					$options_[ 'RequestContentType' ] = 'multipart/form-data';
					$options_[ 'Files' ] = array();

					$options_[ 'Files' ][ 'file' ] = array(
						'Content-Type' 	=> $_FILES[ 'files' ][ 'type' ],
						'FileName'		=> $_FILES[ 'files' ][ 'name' ],
						'Type'			=> 'Data'
					);

					$params_[ 'file' ] = file_get_contents( $_FILES[ 'files' ][ 'tmp_name' ] );
					$params_[ 'mime_type' ] = $_FILES[ 'files' ][ 'type' ];
				}

				$success = self::$client->CallAPI(
					( ( $_SERVER[ 'HTTP_HOST' ] == 'localhost' )? 'http://localhost:8080/api/v1/' : self::ENDPOINT ) . $service,
					$action,
					$params_,
					$options_,
					$el
				);
			}
		}
		return $el;
	}

	public static function get_popup_content()
	{
		$cache = "";
		$name  = @$_POST[ 'name' ];

		$l = @get_bloginfo( 'language' );
		$_POST[ 'language' ] = strtolower( $l{0}.$l{1} );

		if ( strlen( $name ) > 0 )
		{
			if ( $cache = wp_cache_get( $name, HC_Constants::EM_HC_ARGUMENT ) === FALSE )
			{
				$cache = self::call( 'popups/content.json', $_POST, 'GET', 'text' );
				wp_cache_set( $name, $cache, HC_Constants::EM_HC_ARGUMENT, 3600*24*30 );
			}
		}
		echo $cache;
		die;
	}

	public static function get_webservice()
	{
		$r = "";
		$_POST[ 'output' ] = 'json';

		$l = @get_bloginfo( 'language' );
		$_POST[ 'language' ] = strtolower( $l{0}.$l{1} );

		if ( strlen( @$_POST[ 'webservice' ] ) )
			$r = self::call( $_POST[ 'webservice' ], $_POST, 'POST', 'text' );

		echo $r;
		die;
	}
}