<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
class HC_Orders
{
	const WIDGET = '/api/v1/widgets/orders.json';
	private static $event_ids;
	private static $domain;

	function __construct(){}

	private static function get_data()
	{
		self::$domain = ( ( $_SERVER[ 'HTTP_HOST' ] == 'localhost' )? HC_Constants::HYPECAL_DEV : HC_Constants::HYPECAL_WEBSITE );

		if ( @count( HC_Database::get() ) > 0 )
		{
			global $EM_Event;

			$uid = ( ( strlen( @$_SERVER[ 'SERVER_NAME' ] ) > 0 )? $_SERVER[ 'SERVER_NAME' ] : @$_SERVER[ 'HTTP_HOST' ] ) . ":" . $EM_Event->event_id;
			$essFeed = new FeedWriter();
			$newEvent = $essFeed->newEventFeed();
			$newEvent->setId( $uid );

			//d( $uid, $newEvent->getId(), $EM_Event );

			$api = new HC_API();
			$r = $api->call( 'events/get_ids.json', array( 'id' => $newEvent->getId() ) );


			self::$event_ids = ( ( isset( $r->result ) )? @$r->result : NULL );
			//d( self::$event_ids );
		}
	}

	public static function get_tickets_form( $content='' )
	{
		global $EM_Event;

		self::get_data();

		$bookingform = "";

		if ( isset( self::$event_ids ) )
		{
			if ( strlen( @self::$event_ids->encryptedID ) > 0 )
			{
				ob_start();
				?><iframe src="<?php echo self::$domain . self::WIDGET; ?>?key=<?php echo self::$event_ids->encryptedID; ?>" id="hc-tickets-widget" width="100%" height="1040px" marginheight="0" frameborder="0" scrolling="auto"></iframe><?php
				$bookingform = apply_filters( 'em_bookings_form_create', ob_get_clean() );
			}
		}

		return 	$content .
			( ( $EM_Event->event_rsvp )?
				$bookingform
				:
				"<h3>".__('Bookings','dbem') . "</h3>" .
				self::get_contact_button( self::$event_ids->encryptedID )
			) .
			HC_Elements::get_popup_container() .
			HC_Elements::get_page_loader() .
			HC_Elements::get_hypecal_signature();
	}

	public static function get_contact_button( $encryptID )
	{
		return "<p>" . __('Bookings have closed','dbem') . "</p>" .
		"<button type='button' class='btn confirm contact_organizer_link' data-key='". $encryptID . "'>Contact Organizer</button>";
	}

}