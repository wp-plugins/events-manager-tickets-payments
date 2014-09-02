<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
/**
  * View HC_Admin
  * Container of all the structure of the admin page to manage the ESS settings.
  *
  * @author  	Hypecal.com
  * @copyright 	Copyright Hypecal.com
  * @license   	https://www.hypecal.com/terms/
  */
class HC_Admin
{
	function __construct(){}

	// -- Commons
	protected static $dashboard_	= array();

	// -- Booking pages
	protected static $orders_stats	= NULL;
	protected static $bank			= NULL;
	protected static $taxpayer		= NULL;
	protected static $billing 		= NULL;
	protected static $custom_tickets= NULL;
	protected static $custom_forms	= NULL;

	// -- Hypecal events sync pages
	protected static $events_stats	= NULL;

	// -- Edit event page
	protected static $event_ids		= NULL;


	private static function get_billing_data()
	{
		$EM_SYNC 		= defined( 'EM_ESS_VERSION' );
		$ESS_SYNC		= defined( 'EM_DIR' );
		$HYPECAL_SYNC 	= FALSE;

		if ( $EM_SYNC == TRUE && $ESS_SYNC == TRUE )
		{
			if ( @count( HC_Database::get() ) > 0 )
			{
				$HYPECAL_SYNC = TRUE;

				global $HC_Notices;
				$api = new HC_API();

				// -- EVENTS STATS --
				$r = $api->call( 'account/events/stats.json' );
				self::$events_stats = ( ( isset( $r->result ) )? @$r->result : NULL );
				//d( self::$events_stats );

				// -- ORDERS STATS --
				$r = $api->call( 'account/events/orders/stats.json' );
				self::$orders_stats = ( ( isset( $r->result ) )? @$r->result : NULL );
				//d( self::$orders_stats );

				// -- BANK ACCOUNT --
				$r = $api->call( 'account/bank_account/get.json' );
				if ( isset( $r->result->error->message ) ) $HC_Notices->add_error( $r->result->error->message );
				else self::$bank = ( ( isset( $r->result ) )? @$r->result->result : NULL );
				//d( self::$bank );

				// -- TAXPAYER INFO --
				$r = $api->call( 'account/taxpayer/get.json' );
				if ( isset( $r->result->error->message ) ) $HC_Notices->add_error( $r->result->error->message );
				else self::$taxpayer = ( ( isset( $r->result ) )? @$r->result->result : NULL );
				//d( self::$taxpayer );

				// -- BILLING ADDRESS
				$r = $api->call( 'account/billing_address/get.json' );
				if ( isset( $r->result->error->message ) ) $HC_Notices->add_error( $r->result->error->message );
				else self::$billing = ( ( isset( $r->result ) )? @$r->result->result : NULL );
				//d( self::$billing );

				// -- CUSTOM TICKETS
				$r = $api->call( 'account/tickets/custom/list.json' );
				if ( isset( $r->result->error->message ) ) $HC_Notices->add_error( $r->result->error->message );
				else self::$custom_tickets = ( ( isset( $r->result ) )? @$r->result->list : NULL );
				//d( self::$custom_tickets );

				// -- CUSTOM FORMS
				//$r = $api->call( 'account/tickets/forms/list.json' );
				//if ( isset( $r->result->error->message ) ) $HC_Notices->add_error( $r->result->error->message );
				//else self::$custom_forms = ( ( isset( $r->result ) )? @$r->result->list : NULL );
				//d( self::$custom_forms );

				// -- COUPONS

				// -- SERVICES SYNC

				// -- ATTENDEES
			}
		}

		self::$dashboard_ = array(
			'ESS'				=> $EM_SYNC,
			'EVENTS_MANAGER' 	=> $ESS_SYNC,
			'HYPECAL_SYNC'		=> $HYPECAL_SYNC,
			'EVENTS'			=> ( ( @self::$events_stats->TOTAL <=0 	)? FALSE : TRUE ),
			'BANK'				=> ( ( self::$bank 				== NULL )? FALSE : TRUE ),
			'TAXPAYER'			=> ( ( self::$taxpayer 			== NULL )? FALSE : TRUE ),
			'BILLING'			=> ( ( self::$billing 			== NULL )? FALSE : TRUE ),
			'CUSTOM_TICKETS'	=> ( ( self::$custom_tickets 	== NULL )? FALSE : TRUE ),
			'CUSTOM_FORMS'		=> ( ( self::$custom_forms 		== NULL )? FALSE : TRUE ),
			'COUPONS'			=> FALSE,
			'SERVICES'			=> FALSE,
			'ATTENDEES'			=> FALSE
		);
	}

	private static function get_event_sync_data()
	{
		$ACTIVATED = FALSE;

		if ( @count( HC_Database::get() ) > 0 )
		{
			$ACTIVATED = TRUE;

			$api = new HC_API();

			// -- EVENTS STATS --
			$r = $api->call( 'account/events/stats.json' );
			self::$events_stats = ( ( isset( $r->result ) )? @$r->result : NULL );
			//d( self::$events_stats );

		}
	}

	private static function get_event_edit_data()
	{
		if ( @count( HC_Database::get() ) > 0 )
		{
			global $EM_Event;

			// set event UID from server host name + local Event Manager's eventID
			$uid = ( ( strlen( @$_SERVER[ 'SERVER_NAME' ] ) > 0 )? $_SERVER[ 'SERVER_NAME' ] : @$_SERVER[ 'HTTP_HOST' ] ) . ":" . $EM_Event->event_id;
			$essFeed = new FeedWriter();
			$newEvent = $essFeed->newEventFeed();
			$newEvent->setId( $uid );

			//d( $uid, $newEvent->getId(), $EM_Event );

			$api = new HC_API();
			$r = $api->call( 'events/get_ids.json', array( 'id' => $newEvent->getId() ) );
			self::$event_ids = ( ( isset( $r->result ) )? @$r->result : NULL );
			//d( self::$event_ids );

			// if event doesn't exists on Hypecal push the current EM_Event object as a new event
			if ( intval( self::$event_ids->eventID ) <= 0 )
			{
				if ( ESS_IO::set_event_saved_filter( TRUE ) )
				{
					$r = $api->call( 'events/get_ids.json', array( 'id' => $newEvent->getId() ) );
					self::$event_ids = ( ( isset( $r->result ) )? @$r->result : NULL );
					//d( self::$event_ids );
				}
			}
		}
	}


	/**
	 *	Booking/Registration element that appears in the admin's edit event page
	 */
	public static function get_tickets_form()
	{
		self::get_event_edit_data();

		if ( intval( @self::$event_ids->eventID ) > 0 )
		{
			?><div class="contain re">
				<section class="line btnav nav_btns" style="display:none;">
					<a class="btn confirm tooltip internal_popup" data-popup="ticket_edit" title="Create a ticket"><i class="fa fa-plus"></i></a>
					<a class="btn cancel tooltip internal_popup" data-popup="tax_edit" title="Edit tax options"><i class="fa fa-cog"></i></a>
					<span class='bt_tableTools'></span>
				</section>
				<table id="edit-event-prices-grid" data-encryptedID="<?php echo @self::$event_ids->encryptedID; ?>" class="display" cellpadding="0" cellspacing="0" width="100%" style="display:none;"></table>
			</div><?php
			HC_Elements::get_page_loader();
			HC_Elements::get_popup_container();
		}
		else
		{
			?><div><h3 class="orange"><?php _e('You must "Save Draft" or "Publish" this event first to be able to define tickets','dbem'); ?></h3></div><?php
		}
	}

	public static function bookings_page()
	{
		global $HC_Notices;

		self::get_billing_data();

		HC_Control_admin::control_forms();

		$is_activated = ( ( self::$dashboard_[ 'EVENTS_MANAGER' ] == TRUE &&
					 	  	self::$dashboard_[ 'ESS' 		 	] == TRUE &&
					 	  	self::$dashboard_[ 'HYPECAL_SYNC'   ] == TRUE
						)? TRUE : FALSE );

		?><div class="wrap ui-tabs" id="main_tabs">
			<h2 class="nav-tab-wrapper">
				<a href="#dashboard" id="em-menu-dashboard" class="nav-tab nav-tab-active"><b><?php _e('Dashboard','dbem'); ?></b><i class="fa fa-dashboard"></i></a>
				<?php if ( $is_activated ) { ?>
					<a href="#orders" id="em-menu-orders" class="nav-tab"><b><?php _e("Orders",'dbem'); ?></b><i class="fa fa-ticket"></i></a>
					<a href="#custom-tickets" id="em-menu-custom-tickets" class="nav-tab"><b><?php _e("Custom tickets",'dbem'); ?></b><i class="fa fa-ticket"></i></a>
					<a href="#finance" id="em-menu-finance" class="nav-tab"><b><?php _e('Finance','dbem'); ?></b><i class="fa fa-money"></i></a>
				<?php } ?>
			</h2>
			<?php echo $HC_Notices; ?>
			<script type="text/javascript">var selected_tab_index=0;</script>
			<div class="ui-tabs-panel ui-widget-content"><?php

				HC_Admin_dashboard::section();

				if ( $is_activated )
				{
					HC_Admin_orders::section();
					HC_Admin_custom_tickets::section();
					//HC_Admin_custom_forms::section();
					HC_Admin_finance::section();
				}
			?></div>
		</div><?php

		HC_Elements::get_page_loader();
		HC_Elements::get_popup_container();
	}

	public static function sync_page()
	{
		global $HC_Notices;

		self::get_event_sync_data();

		$is_activated = ( ( self::$dashboard_[ 'EVENTS_MANAGER' ] == TRUE &&
					 	  	self::$dashboard_[ 'ESS' 			  ] == TRUE &&
					 	  	self::$dashboard_[ 'HYPECAL_SYNC'   ] == TRUE
						)? TRUE : FALSE );

		?><div class="wrap ui-tabs" id="main_tabs">
			<h2 class="nav-tab-wrapper">
				<?php if ( $is_activated ) { ?>
					<a href="#events" id="em-menu-events" class="nav-tab"><b><?php _e("Events",'dbem'); ?></b><i class="fa fa-calendar-o"></i></a>
					<a href="#services" id="em-menu-services" class="nav-tab"><b><?php _e("Services",'dbem'); ?></b><i class="fa fa-exchange"></i></a>
				<?php } ?>
			</h2>
			<?php echo $HC_Notices; ?>
			<div class="ui-tabs-panel ui-widget-content"><?php
				if ( $is_activated )
				{
					HC_Admin_events::section();
					HC_Admin_services::section();
				}
			?></div>
		</div><?php

		HC_Elements::get_page_loader();
		HC_Elements::get_popup_container();
	}





}