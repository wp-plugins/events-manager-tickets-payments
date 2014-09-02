var hc_admin_bookings =
{
	init : function(e)
	{
		hc.set_radio_buttons();
		hc.set_restrict_numbers();
		hc.set_number_stepper();
		hc.set_tooltips();
		hc.set_chart();
		hc.set_internal_popup_info();
		hc.set_form_validator();

		// -- Navigation
		hc_admin_bookings.init_tabs_nav(e);
		hc_admin_bookings.handle_tab_selected();

		// -- Finance
		hc_admin_bookings.set_tax_toggle_actions();
		hc_admin_bookings.set_taxpayer_entity_type_required();

		hc.loader( false );
	},

	set_tax_toggle_actions : function()
	{
		jQuery( '#taxpayer_applicable-div').off( 'click' );
		jQuery( '#taxpayer_applicable-div').on( 'click', function()
		{
			if ( jQuery( '.taxpayer_applicable-checkbox' ).prop( 'checked' ) == true )	jQuery( '#taxpayer_main_block' ).show();
			else 																		jQuery( '#taxpayer_main_block' ).hide();
		});

		jQuery( '#taxpayer_entity_form-div').off( 'click' );
		jQuery( '#taxpayer_entity_form-div').on( 'click', function()
		{
			if ( jQuery( '.taxpayer_entity_form-checkbox' ).prop( 'checked' ) == true )
	    	{
	    		jQuery( '#W9-form-block'	).show();
				jQuery( '#W8BEN-form-block' ).hide();
	    	}
	    	else
	    	{
	    		jQuery( '#W8BEN-form-block' ).show();
				jQuery( '#W9-form-block' 	).hide();
	    	}
	    	hc_admin.set_taxpayer_entity_type_required();
	    });

		jQuery('.taxid-type').off('change');
		jQuery('.taxid-type').on('change',function( e )
		{
			switch( jQuery(this).val() )
			{
				default :
				case 'NATIONAL' :
					jQuery( '.taxid' ).prop( 'placeholder', 'XXXXXXXXXXXXXXXXX' );
					jQuery( '.taxid' ).attr( 'maxlength', 	'' );
					jQuery( '.taxid' ).attr( 'size', 		'' );
					break;

				case 'EIN' :
					jQuery( '.taxid' ).prop( 'placeholder', 'XX-XXXXXXX' );
					jQuery( '.taxid' ).prop( 'maxlength', 	10 );
					jQuery( '.taxid' ).attr( 'size', 		10 );
					break;

				case 'SSN' :
					jQuery( '.taxid' ).prop( 'placeholder', 'XXX-XX-XXXX' );
					jQuery( '.taxid' ).attr( 'maxlength', 	11 );
					jQuery( '.taxid' ).attr( 'size', 		11 );
					break;
			}
		});
	},

	set_taxpayer_entity_type_required : function()
	{
		jQuery( '.fieldset_form' ).each( function( i )
		{
			var is_activated = ( ( jQuery( this ).is( ':visible' ) == true )? 'false' : 'true' );

			jQuery( '#' + jQuery(this).attr( 'id' ) + ' input' ).each( function( i )
			{
				if ( typeof jQuery(this).attr('data-validation-optional') !== 'undefined' ) jQuery(this).attr('data-validation-optional', is_activated );
			});
		});
	},

	handle_tab_selected : function()
	{
		var navUrl = document.location.toString();

		if ( navUrl.match( '#' ) )
		{
			var nav_tab = navUrl.split( '#' )[ 1 ].split( ':' );

			jQuery( 'a#em-menu-' + ( ( nav_tab == 'dashboard' )? 'dashboard' : nav_tab ) ).trigger( 'click' );
		}
	},

	goto_tab : function( tab_name )
	{
		jQuery( 'a#em-menu-' + ( ( tab_name == '' )? 'dashboard' : tab_name ) ).trigger( 'click' );
	},

	set_event_id : function( event_id )
	{
		jQuery( '#selected_event_id' ).val( event_id );
	},

	init_tabs_nav : function($)
	{
		$(".postbox > h3").off();
		$(".postbox > h3").on( 'click', function(){ $(this).parent().toggleClass('closed'); });
		$(".postbox").addClass('closed');

		$( '.nav-tab-wrapper .nav-tab' ).off();
		$( '.nav-tab-wrapper .nav-tab' ).on( 'click', function()
		{
			$('.nav-tab-wrapper .nav-tab').removeClass('nav-tab-active');
			el = $(this);
			elid = el.prop('id');
			$('.em-menu-group').hide();
			$('.'+elid).show();
			el.addClass('nav-tab-active');
			$(".postbox").addClass('closed');

			selected_tab_index = 1;
		});

		var navUrl = document.location.toString();
		if ( navUrl.match( '#' ) )  //anchor-based navigation
		{
			var nav_tab = navUrl.split('#')[1].split(':');

			$('a#em-menu-' + nav_tab[0]).trigger('click');

			if ( nav_tab.length > 1 )
			{
				section = $( "#em-opt-" + nav_tab[ 1 ] );

				if( section.length > 0 ){
					section.children('h3').trigger('click');
			    	//$('html, body').animate({ scrollTop: section.offset().top - 30 }); //sends user back to top of form
				}
			}
		}
		else document.location = navUrl+"#general";//set to general tab by default, so we can also add clicked subsections

		$( 'nav-tab-link' ).off();
		$('.nav-tab-link').on('click',function(){ $($(this).prop('rel')).trigger('click'); }); //links to mimick tabs

		$( 'input[type="submit"]' ).off();
		$( 'input[type="submit"]' ).on( 'click', function()
		{
			var el = $(this).parents('.postbox').first();
			var docloc = document.location.toString().split('#');
			var newloc = docloc[0];

			if ( docloc.length > 1 ){
				var nav_tab = docloc[1].split(':');
				newloc = newloc + "#" + nav_tab[0];
				if( el.prop('id') ){
					newloc = newloc + ":" + el.prop('id').replace('em-opt-','');
				}
			}
			document.location = newloc;
		});

	},

	authorize : function()
	{
		window.open(
	        global_vars.SELF + '&code=OAuth2',
	        'popUpWindow',
	        'height=590,	\
	         width=680,     \
	         left=300,      \
	         top=80,        \
	         resizable=no,  \
	         scrollbars=yes,\
	         toolbar=no,    \
	         menubar=no,    \
	         location=no,   \
	         directories=no,\
	         status=no'
	   	);
	},

	call: function( actions, onSuccess, onFail )
	{
	     jQuery.ajax({
		     url	 : global_vars.API,
		     data	 : ({action : actions }),
		     success : function( data, code, jqx ) { if ( typeof onSuccess == 'function' ) onSuccess(); },
		     error	 : function( jqx, err, ex 	 ) { if ( typeof onSuccess == 'function' ) onFail();    },
	     });
	},



};
jQuery( document ).ready( function( e ) { hc_admin_bookings.init(e); });

