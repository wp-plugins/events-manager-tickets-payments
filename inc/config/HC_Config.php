<?php
require_once( "HC_Constants.php" );
require_once( EM_HYPECAL_DIR . "/inc/models/HC_IO.php" 			);
require_once( EM_HYPECAL_DIR . "/inc/models/HC_Database.php" 	);

final class HC_Config
{
	function __construct(){}

	public static function load_MVC_files()
	{
		$dir = str_replace( '/config', '', plugin_dir_path( __FILE__ ) );

		// -- LIBS
		require_once( $dir .'libs/HC_HTTP.php' 		);
		require_once( $dir .'libs/HC_OAuth2.php' 	);
		require_once( $dir .'libs/HC_Tools.php' 	);
		if ( !class_exists( 'kint' 		 ) ) require_once( EM_HYPECAL_DIR . "/inc/libs/kint-0.9/Kint.class.php" );
		if ( !class_exists( 'FeedWriter' ) ) require_once( EM_HYPECAL_DIR . "/inc/libs/ess/FeedWriter.php" 		);


		// -- MODELS
		require_once( $dir .'models/HC_API.php' 		);
		require_once( $dir .'models/HC_Database.php' 	);
		require_once( $dir .'models/HC_IO.php' 			);


		// -- CONTROLLERS
		require_once( $dir .'controllers/HC_Control_admin.php' 	);
		require_once( $dir .'controllers/HC_Notices.php' 		);


		// -- VIEWS
		require_once( $dir .'views/commons/HC_Elements.php' 	);
		require_once( $dir .'views/commons/HC_Menus.php'	 	);
		// 			-- ADMIN
		require_once( $dir .'views/admin/HC_Admin.php' 			);
		//					-- Bookings
		require_once( $dir .'views/admin/bookings/HC_Admin_dashboard.php'		);
		require_once( $dir .'views/admin/bookings/HC_Admin_orders.php'			);
		require_once( $dir .'views/admin/bookings/HC_Admin_custom_tickets.php'	);
		require_once( $dir .'views/admin/bookings/HC_Admin_custom_forms.php'	);
		require_once( $dir .'views/admin/bookings/HC_Admin_finance.php' 		);
		//					-- Events sync
		require_once( $dir .'views/admin/sync/HC_Admin_events.php' 			);
		require_once( $dir .'views/admin/sync/HC_Admin_services.php' 		);

		//			-- WEB
		require_once( $dir .'views/web/HC_Orders.php' 	);

	}
}