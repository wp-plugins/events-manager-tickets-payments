var hc_order = {
	c : '#em-booking',

	init : function()
	{
		hc_order.em_hidder();
	},

	em_hidder : function()
	{
		jQuery( hc_order.c + ' .em-tickets' 				).hide();
		jQuery( hc_order.c + ' .em-booking-form-details' 	).hide();
		jQuery( hc_order.c + ' .em-booking-buttons' 		).hide();
	},

};
jQuery( document ).ready(function() { hc_order.init(); });
