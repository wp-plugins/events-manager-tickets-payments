<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
class HC_Admin_dashboard extends HC_Admin
{
	private static function set_data()
	{
		$admin_url 				= admin_url();
		$ess_search_plugin_url 	= $admin_url . "plugin-install.php?tab=search&s=Events+Manager+ESS&plugin-search-input=Search+Plugins";

		$data_ = array(
			array(
				'completed' 	=> parent::$dashboard_[ 'EVENTS_MANAGER' ],
				'title'			=> ( ( parent::$dashboard_[ 'EVENTS_MANAGER' ] )? __( "Events Manager is instaled!", 'dbem' ) : __( "Install Events Manager", 'dbem' ) ),
				'description'	=> ( ( parent::$dashboard_[ 'EVENTS_MANAGER' ] )? "" : __( "You must install Events Manager Wordpress plugin to use Hypecal and start selling tickets for your events on your website.", 'dbem' ) ),
				'link_url'		=> ( ( self::$dashboard_[ 'EVENTS_MANAGER' ] )? HC_Constants::PLUGIN_WEBSITE : '' ),
				'link_name'		=> __( "Events Manager", 'dbem' ),
				'hide_validate' => TRUE
			),
			array(
				'completed' 	=> parent::$dashboard_[ 'ESS' ],
				'title'			=> ( ( parent::$dashboard_[ 'ESS' ] == FALSE )? __( "Install the ESS Plugin", 'dbem' ) : __( "ESS Plugin installed!", 'dbem' ) ),
				'description'	=> __( "The Events Manager ESS Plugin allows you to broadcast automatically your events to 3rd party websites. Your events published on WordPress will be sync with tickets seller portals. <a href='".HC_Constants::ESS_WEBSITE."' target='_blank'>plugin page</a>", 'dbem' ),
				'link_url'		=> $ess_search_plugin_url,
				'link_name'		=> __( "Install ESS", 'dbem' ),
				'hide_validate' => TRUE
			)
		);

		if ( parent::$dashboard_[ 'HYPECAL_SYNC' ] )
		{
			$admin_event_url 			=  $admin_url . 'edit.php?post_type=' . ( defined( 'EM_POST_TYPE_EVENT' )? EM_POST_TYPE_EVENT : 'event' );
			$admin_finance_url 			= "javascript:hc_admin_bookings.goto_tab(\"finance\");";
			$admin_custom_tickets_url	= "javascript:hc_admin_bookings.goto_tab(\"custom-tickets\");";

			array_push( $data_,
				array(
					'completed' 	=> parent::$dashboard_[ 'EVENTS' ],
					'title'			=> ( ( parent::$dashboard_[ 'EVENTS' ] == FALSE )? __( "Create an Event", 'dbem' ) : __( "Events created!", 'dbem' ) ),
					'description'	=> __( "You have to create an event in order to sell tickets. Your events must have a valide date, price and location. If you already have events created, edit them and set your tickets in the booking section.", 'dbem' ),
					'link_url'		=> $admin_event_url,
					'link_name'		=> ( ( self::$dashboard_[ 'HYPECAL_SYNC' ] )? __( "Manage Events", 'dbem' ) : "" ),
					'hide_validate' => TRUE
				),
				array(
					'completed' 	=> parent::$dashboard_[ 'BANK' ],
					'title'			=> ( ( parent::$dashboard_[ 'BANK' ] == FALSE )? __( "Bank Account info", 'dbem' ) : __( "Bank Account Completed!", 'dbem' ) ),
					'description'	=> __( "In order to receive payouts for your tickets sold, you need to complete your bank account information. You will receive the payment 7 weekdays after your event endday.", 'dbem' ),
					'link_url'		=> $admin_finance_url,
					'link_name'		=> ( ( self::$dashboard_[ 'HYPECAL_SYNC' ] )? __( "Bank Settings", 'dbem' ) : "" ),
					'hide_validate' => TRUE
				),
				array(
					'completed' 	=> parent::$dashboard_[ 'TAXPAYER' ],
					'title'			=> ( ( parent::$dashboard_[ 'TAXPAYER' ] == FALSE )? __( "Taxpayer info", 'dbem' ) : __( "Taxpayer Completed!", 'dbem' ) ),
					'description'	=> __( "If you process over 200 orders and have not provided us with your taxpayer information, Hypecal is required to withhold on your payout until we receive this information. To avoid service interruptions, please fill out your taxpayer information now.", 'dbem' ),
					'link_url'		=> $admin_finance_url,
					'link_name'		=> ( ( self::$dashboard_[ 'HYPECAL_SYNC' ] )? __( "Taxpayer Settings", 'dbem' ) : "" ),
					'hide_validate' => TRUE
				),
				array(
					'completed' 	=> parent::$dashboard_[ 'BILLING' ],
					'title'			=> ( ( parent::$dashboard_[ 'HYPECAL_SYNC' ] == FALSE )? __( "Billing Address", 'dbem' ) : __( "Billing Address Completed!", 'dbem' ) ),
					'description'	=> __( "You have to complete your billing address information in order to receive invoices for your ticket sold. The billing address will be also displayed on your tickets receipts.", 'dbem' ),
					'link_url'		=> $admin_finance_url,
					'link_name'		=> ( ( self::$dashboard_[ 'HYPECAL_SYNC' ] )? __( "Billing Address", 'dbem' ) : "" ),
					'hide_validate' => TRUE
				),
				array(
					'completed' 	=> parent::$dashboard_[ 'CUSTOM_TICKETS' ],
					'title'			=> ( ( parent::$dashboard_[ 'CUSTOM_TICKETS' ] == FALSE )? __( "Customize your Tickets", 'dbem' ) : __( "Ticket Customized!", 'dbem' ) ),
					'description'	=> __( "You have to complete your billing address information in order to receive invoices for your ticket sold. The billing address will be also displayed on your tickets receipts.", 'dbem' ),
					'link_url'		=> $admin_custom_tickets_url,
					'link_name'		=> ( ( self::$dashboard_[ 'HYPECAL_SYNC' ] )? __( "Customize now", 'dbem' ) : "" ),
					'hide_validate' => TRUE
				)
			);
		}

		if ( parent::$dashboard_[ 'ESS' ] )
		{
			array_push( $data_,
				array(
					'completed' 	=> parent::$dashboard_[ 'HYPECAL_SYNC' ],
					'title'			=> ( ( parent::$dashboard_[ 'HYPECAL_SYNC' ] )? __( "Hypecal Sync!", 'dbem' ) : __( "Sync your events with Hypecal.com", 'dbem' ) ),
					'description'	=> __( "Hypecal.com gives you the ability to sell tickets, manage bookings, receive payments and boost your promotion. Your events and tickets are displayed on your Wordpress website, on partners events portals and ticketing reseller services. More info on <a href='".HC_Constants::HYPECAL_WEBSITE."' target='_blank'>hypecal.com</a>", 'dbem' ),
					'link_url'		=> "javascript:hc_admin_bookings.authorize();",
					'link_name'		=> ( ( self::$dashboard_[ 'HYPECAL_SYNC' ] )? __( "Update Account", 'dbem' ) : __( "Sync now", 'dbem' ) ),
					'hide_validate' => FALSE
				)
			);
		}

		return $data_;
	}

	public static function section()
	{
		$completed = 0;

		$data_ = self::set_data();

		foreach ( $data_ as $step_ ) { if($step_['completed']==TRUE) $completed++; }

		?><section class="em-menu-dashboard em-menu-group">
			<div id="poststuff">
				<div class="signup-checklist">

					<section class="checklist-breakdown">
						<script type="text/javascript">
							var num_total = <?php echo intval( @count( $data_ ) );?>;
							var num_completed = <?php echo intval( $completed );?>;
						</script>
						<div class="checklist-chart" width="145" height="145"></div>
						<p>
							You've completed
							<strong><?php echo intval( $completed );?> of our list of <?php echo intval( @count( $data_ ) );?></strong>
							actions to activate the Hypecal plugin. Follow step by step each section and your tickets will be online in a minute!
						</p>
					</section>

					<section class="checklist" style="display:none;">
						<ol><?php
						if ( @count($data_) > 0 )
						{
							 foreach ( $data_ as $step_ )
							{
								?><li class="task <?php echo ( ( $step_[ 'completed' ] == TRUE )? 'complete' : '' );?>">
									<h3><?php echo $step_[ 'title' ];?></h3><?php

								  	echo ( ( ( $step_[ "description" ] != '' && $step_['completed'] == FALSE ) ||$step_[ "hide_validate" ] == FALSE )?
								  		"<p>".$step_["description"]."</p>"
										:
										''
									);

									echo ( ( $step_[ "link_url" ] != '' )?
								  		"<a target='_self' href='".$step_["link_url"]."' class='btn " . ( ( $step_[ "hide_validate" ] == FALSE && $step_['completed'] == TRUE )? 'cancel' : 'confirm' ) . "'>" .
								  			$step_[ "link_name" ] .
								  		"</a>"
										:
										''
									);?></li><?php
								}
							}
						?></ol>
					</section>
				</div>
			</div>
		</section><?php
	}


}