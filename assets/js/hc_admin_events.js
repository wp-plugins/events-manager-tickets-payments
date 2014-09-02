var hc_admin_event =
{
	init : function(e)
	{
		hc_admin_event.set_datagrid();
	},

	set_datagrid : function()
	{
		var id = '#edit-event-prices-grid';

		//if ( jQuery( '#event-rsv' ).prop( 'checked' ) == true )

		hc.popups.event_edit.eventID = jQuery( id ).attr( 'data-encryptedID' );

		hc.set_datagrid( id, "No tickets created", 6, 'account/events/tickets/datagrid.json', { key: hc.popups.event_edit.eventID } );
		hc.popups.event_edit.set_internal_popup_actions();
	},

	popup_create_event : function()
	{
		hc.popup( 'event_new', function()
		{
			hc.popups.event_new.onLoad();
		},
		function()
		{
			hc.popups.event_new.onClose();
		});
	}

};
jQuery( document ).ready( function( e ) { hc_admin_event.init( e ); });