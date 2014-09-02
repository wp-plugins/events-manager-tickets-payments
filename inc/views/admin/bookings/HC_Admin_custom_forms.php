<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
class HC_Admin_custom_forms extends HC_Admin
{
	public static function section()
	{
		?><section class="em-menu-custom-forms em-menu-group" style="display:none;">
			<form method="post" enctype='multipart/form-data' target="_self" onsubmit="hc.loader(true);">
				<section class="nav_btns">
					<a class="btn confirm tooltip" title="<?php _e('Create a custom form', 'dbem'); ?>" onclick="hc.account.tickets.popup_form();"><i class="fa fa-plus"></i></a>
				</section>
				<table id="forms_custom_grid" class="display widefat" cellpadding="0" cellspacing="0" width="100%"></table>
			</form>
		</section><?php
	}

}