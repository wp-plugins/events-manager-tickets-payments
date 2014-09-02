<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
class HC_Admin_orders extends HC_Admin
{
	public static function section()
	{
		$order_status 	= @$_POST[ 'orders-list-status' ];
		$order_type		= @$_POST[ 'orders-list-type'   ];

		?><section class="em-menu-orders em-menu-group" style="display:none;">

			<form method="post" target="_self">
				<section class="dash_row">

					<div <?php echo ( ( $order_status == HC_Constants::STATUS_CANCELED )? 'class="active '.strtolower( HC_Constants::STATUS_CANCELED ).'"' : '' );?>>
						<button class="tooltip" title="Display the transactions that haven't been finished before the reservation delay. If the transaction doesn't occur in the allotted timed limit, the tickets will be released and kept as canceled to prevent overselling tickets." type="submit" name="orders-list-status" value="<?php echo HC_Constants::STATUS_CANCELED;?>">
							<h6>
								<em class="delete"></em>
								<span>Canceled</span>
							</h6>
							<h2><?php echo @self::$orders_stats->CANCELED;?></h2>
						</button>
					</div>
					<div <?php echo ( ( $order_status == HC_Constants::STATUS_PROCESSING )? 'class="active '.strtolower( HC_Constants::STATUS_PROCESSING ).'"' : '' );?>>
						<button class="tooltip" title="Display the transactions waiting for the ticket's buyer issuer's bank to validate the payment. If the transaction remains as pending for more than two days you should consider the transaction as canceled." type="submit" name="orders-list-status" value="<?php echo HC_Constants::STATUS_PROCESSING;?>">
							<h6>
								<em class="pending"></em>
								<span>Pending</span>
							</h6>
							<h2><?php echo @self::$orders_stats->PROCESSING;?></h2>
						</button>
					</div>
					<div <?php echo ( ( $order_status == HC_Constants::STATUS_BILLING )? 'class="active '.strtolower( HC_Constants::STATUS_BILLING ).'"' : '' );?>>
						<button class="tooltip" title="Display the transaction fully completed. A sale can contain several tickets." type="submit" name="orders-list-status" value="<?php echo HC_Constants::STATUS_BILLING;?>">
							<h6>
								<em class="sells"></em>
								<span>Confirmed</span>
							</h6>
							<h2><?php echo @self::$orders_stats->BILLING;?></h2>
						</button>
					</div>
					<div <?php echo ( ( $order_status == '' )? 'class="active"' : '' );?>>
						<button class="tooltip" title="Display all the transactions." type="submit" name="orders-list-status" value="">
							<div>
								<h6><b>ATTENDEES</b></h6>
								<h2 class='prc'><?php echo @self::$orders_stats->TOTAL_ATTENDEES;?></h4>
							</div>
							<div>
								<h6><b>TOTAL SALES</b></h6>
								<h2 class="prc"><?php echo @self::$orders_stats->TOTAL_AMOUNT;?></h2>
							</div>
						</button>
					</div>
				</section>
			</form>

			<form id="form_tickets_list" method="post" enctype='multipart/form-data' target="_self" onsubmit="hc.loader(true);">
				<section class="nav_btns" style="display:none;">
					<a class="btn cancel tooltip" title="<?php _e('Fee calculator', 'dbem'); ?>" onclick="hc.account.tickets.popup_fee_calculator();"><i class="fa fa-credit-card"></i></a>
					<span class='bt_tableTools'></span>
					<input type="hidden" id="orders-list-status" name="orders-list-status" value="<?php echo ( ( strlen( $order_status ) > 0 )? $order_status : '' );?>"/>
					<input type="hidden" id="orders-list-type" name="orders-list-type" value="<?php echo ( ( strlen( $order_type ) > 0 )? $order_type:'');?>"/>
					<?php HC_Menus::get_orders_types( 'orders-list-type-menu', NULL, $order_type );?>
				</section>
				<table id="orders_grid" class="display" cellpadding="0" cellspacing="0" width="100%" style="display:none;"></table>
			</form>

		</section><?php
	}

}