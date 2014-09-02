<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
class HC_Admin_custom_tickets extends HC_Admin
{
	public static function section()
	{
		?><section class="em-menu-custom-tickets em-menu-group" style="display:none;">
			<form method="post" enctype='multipart/form-data' target="_self" onsubmit="hc.loader(true);">
				<section class="nav_btns" style="display:none;">
					<a class="btn confirm tooltip" title="<?php _e('Create a custom ticket', 'dbem'); ?>" onclick="hc.account.tickets.popup_design();"><i class="fa fa-plus"></i></a>
					<span class='bt_tableTools'></span>
				</section>
				<table id="tickets_custom_grid" class="display widefat" cellpadding="0" cellspacing="0" width="100%" style="display:none;"></table>
			</form>
		</section><?php
	}
}