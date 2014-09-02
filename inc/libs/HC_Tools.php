<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
final class HC_Tools
{
	function __construct() {}

	/**
	 * Takes a url and appends GET params (supplied as an assoc array),
	 * it automatically detects if you already have a querystring there
	 * CF: Event Manager Wordpress Plugin: em-functions.php
	 *
	 * @param string $url
	 * @param array $params
	 * @param bool $html
	 * @param bool $encode
	 * @return string
	 */
	public static function add_get_params( $url, $params = array(), $html = TRUE, $encode = TRUE )
	{
		// -- splig the url up to get the params and the page location
		$url_parts 			= explode( '?', $url );
		$url 				= $url_parts[ 0 ];
		$url_params_dirty 	= array();

		if ( @count( $url_parts ) > 1 )
		{
			$url_params_dirty = $url_parts[ 1 ];

			// -- get the get params as an array
			if ( !is_array( $url_params_dirty ) )
			{
				$url_params_dirty = ( ( strstr( $url_params_dirty, '&amp;' ) !== FALSE )?
					explode( '&amp;', $url_params_dirty )
					:
					explode( '&', $url_params_dirty )
				);
			}

			// -- split further into associative array
			$url_params = array();

			foreach ( $url_params_dirty as $url_param )
			{
				if ( !empty( $url_param ) )
				{
					$url_param = explode( '=', $url_param );

					if ( @count( $url_param ) > 1 )
						$url_params[ $url_param[ 0 ] ] = $url_param[ 1 ];
				}
			}

			// -- merge it together
			$params = array_merge( $url_params, $params );
		}

		// -- build the array back up.
		$count = 0;

		foreach ( $params as $key => $value )
		{
			if ( $value !== NULL )
			{
				if ( is_array( $value ) )
					$value = implode( ',', $value );

				$value = ( ( $encode )? urlencode( $value ) : $value );
				$url  .= ( ( $count == 0 )? "?{$key}=".$value : ( ( $html == TRUE )? "&amp;{$key}=".$value : "&{$key}=".$value ) );
				$count++;
			}
		}
		return ( ( $html == TRUE )? esc_url( $url ) : esc_url_raw( $url ) );
	}


}
