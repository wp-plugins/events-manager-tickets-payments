<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
/**
  * View HC_Elements
  * Container of recyclebale graphical sub-elements used within the Hypecal plugin
  *
  * @author  	Hypecal.com
  * @copyright 	Copyright to Hypecal.com.
  * @license   	https://www.hypecal.com/terms/
  **/
final class HC_Elements
{
	function __construct(){}

	public static function get_hypecal_signature()
	{
		return "<p style='color:rgb(153,153,153);font-size:11px;padding:0;margin:0;display:inline;'>" .
			__( "Event promotion boosted by ", 'dbem' ) .
			" <a href='".HC_Constants::HYPECAL_WEBSITE."' target='_blank' alt='" . __( "Hypecal Events Search Engine", 'dbem' )."'>" .
				__( "Hypecal", 'dbem' ) .
			"</a>".
		"</p>";
	}

	public static function get_output_single( $content='' )
	{
		global $EM_Event;

		return $content . self::get_hypecal_signature();
	}


	public static function get_error_block( $message='', $is_visible=FALSE )
	{
		?><div class="error-bloc info-popup" <?php echo (($is_visible==FALSE)?"style='display:none;'":'');?>>
			<i class="fa fa-exclamation-triangle"></i>
			<p><?php echo $message;?></p>
			<a class='close' href="#" onclick="hc.loader(false);$('.info-popup').slideUp('slow')">x</a>
		</div><?php
	}

	public static function get_valid_block( $message='', $is_visible=FALSE )
	{
		?><div class="valid-bloc info-popup" <?php echo (($is_visible==FALSE)?"style='display:none;'":'');?>>
			<i class="fa fa fa-thumbs-up"></i>
			<p><?php echo $message;?></p>
			<a class='close' href="#" onclick="hc.loader(false);$('.info-popup').slideUp('slow')">x</a>
		</div><?php
	}

	public static function get_popup_container()
	{
		?><div class="pp_int" id="popup_container" style="display:none;">
			<div class="modal-display-area"><div class="edit_close">×</div>
				<div class="int_cont">
					<?php self::get_error_block(''); self::get_valid_block('');?>
					<div class="popup-container-element"></div>
				</div>
			</div>
		</div>
		<div class="pp_int" id="popup_container2" style="display:none;">
			<div class="modal-display-area"><div class="edit_close">×</div>
				<div class="int_cont">
					<?php self::get_error_block(''); self::get_valid_block('');?>
					<div class="popup-container-element2"></div>
				</div>
			</div>
		</div>
		<div class="pp_int" id="popup_container3" style="display:none;">
			<div class="modal-display-area"><div class="edit_close">×</div>
				<div class="int_cont">
					<?php self::get_error_block(''); self::get_valid_block('');?>
					<div class="popup-container-element3"></div>
				</div>
			</div>
		</div><?php
	}

	public static function get_page_loader()
	{
		?><div id="pageLoader" style="display:none;">
			<div id="loadingProgressG">
				<div id="loadingProgressG_1" class="loadingProgressG"></div>
			</div>
		</div>
		<div id="hidder_overlay" style="display:none;"></div><?php
	}

	public static function get_explain_block( $txt='' )
	{
		?><div class="hc_explain">
			<img src="<?php echo EM_HYPECAL_URL. '/assets/img/info_icon_30x30.png'; ?>" alt="<?php _e('Info','dbem');?>" />
			<p><?php _e( $txt, "dbem" ); ?></p>
		</div><?php
	}

	public static function button_checkbox( Array $DATA_=NULL )
	{
		if(empty($DATA_))return;
		?><div
			class			= "toggle hide-if-no-js iphone <?php echo ( ( $DATA_['checked'] == true )? 'on' : 'off' ); ?>"
			id				= "<?php echo $DATA_['id']; ?>-div"
			data-checkbox	= "<?php echo $DATA_['id']; ?>-checkbox"
			data-ontext		= "<?php echo $DATA_['on']; ?>"
			data-offtext	= "<?php echo $DATA_['off']; ?>">
			<?php echo ( ( $DATA_['checked'] == true )? $DATA_['on'] : $DATA_['off'] );	?>
		</div>
		<input
			<?php if(isset($DATA_['onchecked'])||isset($DATA_['onunchecked'])) : ?>
				onchange = "if(jQuery(this).is(':checked')){<?php echo $DATA_['onchecked'];?>}else{<?php echo $DATA_['onunchecked']; ?>};"
			<?php endif; ?>
			type	= "checkbox"
			class	= "<?php echo $DATA_['id']; ?>-checkbox input-checkbox"
			name	= "<?php echo $DATA_['name']; ?>"
			<?php echo( ( $DATA_['checked'] == true )? "checked='checked'" : '' );?>
		/>
    	<?php
	}

	/*
	public static function get_events_manager_required()
	{
		?><div class="update-nag" style="width:95%;">
			<?php _e('Events Manager is required to use the event payment plugin. Please install it first and reload this page: ','dbem'); ?>
			<a href="<?php echo HC_Constants::PLUGIN_WEBSITE; ?>" target="_blank">
				<?php _e( 'Events Manager', 'dbem' ); ?>
			</a>
		</div><?php
		die;
	}
	*/

	public static function get_php_curl_required()
	{
		?><div class="update-nag">
			<?php _e( "The library PHP cURL must be installed on your server ", 'dbem' ); ?>
		</div><?php
		die;
	}

	public static function get_ahref( $url )
	{
		return "<a href='".$url."' target='_blank'>" .$url ."</a>";
	}

	public static function get_info( $text )
	{
		?><img src="<?php echo EM_HYPECAL_DIR_URI . "assets/img/info_icon_30x30.png";?>" width="14" height="14" class="tooltip" title="<?php echo $text;?>"/><?php
	}

	public static function get_map_tooltip( $event = NULL )
	{
		return "<table cellpadding='0' cellspacing='0' class='tt_map'>" .
			"<tr>" .
				"<td rowspan='5'>" .
					"<img src='https://maps.google.com/maps/api/staticmap?center=".$event->lat.",".$event->lng."&zoom=9&size=80x80&maptype=roadmap&sensor=false&markers=color:blue|".$event->lat.",".$event->lng."'/>".
				"</td>" .
				"<td><h5>".$event->venue_name."</h5></td>" .
			"</tr>" .
			"<tr>" .
				"<td>".$event->address."</td>" .
			"</tr>" .
			"<tr>" .
				"<td>".$event->city."</td>" .
			"</tr>" .
			"<tr>" .
				"<td>". trim( $event->zip." ".$event->country )."</td>" .
			"</tr>" .
		"</table>";
	}

	public static function get_category_tooltip( $event = NULL )
	{
		$tags = "<h5>" . $event->category_name . "</h5>".
		"<div class='tag_head'>" .
			$event->category_type .
		"</div>";

		foreach ( $event->tags as $tg )
			$tags .= "<a>" . preg_replace( '/_/', ' ', $tg ) . "</a>";

		return $tags;
	}

}