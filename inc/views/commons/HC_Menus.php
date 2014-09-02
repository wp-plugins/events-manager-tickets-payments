<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
final class HC_Menus
{
	public static function get_states_us( $id, $name, $selected, $style='', $class='' )
	{
		?><select <?php echo ((isNull($name)==FALSE)?"name='".$name."'":'');?> <?php echo ( ( isNull( $id ) == FALSE )? "id='" . $id . "'" : '' );?> style="<?php echo $style;?>;" class="<?php echo $class;?>">
			<option <?php echo (($selected==''							)?"selected='selected'":'');?> value="">Select a State</option>
			<option <?php echo (($selected=='Alabama'					)?"selected='selected'":'');?> value="Alabama">Alabama</option>
			<option <?php echo (($selected=='Alaska'					)?"selected='selected'":'');?> value="Alaska">Alaska</option>
			<option <?php echo (($selected=='American Samoa'			)?"selected='selected'":'');?> value="American Samoa">American Samoa</option>
			<option <?php echo (($selected=='Arizona'					)?"selected='selected'":'');?> value="Arizona">Arizona</option>
			<option <?php echo (($selected=='Arkansas'					)?"selected='selected'":'');?> value="Arkansas">Arkansas</option>
			<option <?php echo (($selected=='Armed Forces Americas'		)?"selected='selected'":'');?> value="Armed Forces Americas">Armed Forces Americas</option>
			<option <?php echo (($selected=='Armed Forces Europe'		)?"selected='selected'":'');?> value="Armed Forces Europe">Armed Forces Europe</option>
			<option <?php echo (($selected=='Armed Forces Pacific'		)?"selected='selected'":'');?> value="Armed Forces Pacific">Armed Forces Pacific</option>
			<option <?php echo (($selected=='California'				)?"selected='selected'":'');?> value="California">California</option>
			<option <?php echo (($selected=='Colorado'					)?"selected='selected'":'');?> value="Colorado">Colorado</option>
			<option <?php echo (($selected=='Connecticut'				)?"selected='selected'":'');?> value="Connecticut">Connecticut</option>
			<option <?php echo (($selected=='Delaware'					)?"selected='selected'":'');?> value="Delaware">Delaware</option>
			<option <?php echo (($selected=='District of Columbia'		)?"selected='selected'":'');?> value="District of Columbia">District of Columbia</option>
			<option <?php echo (($selected=='Florida'					)?"selected='selected'":'');?> value="Florida">Florida</option>
			<option <?php echo (($selected=='Georgia'					)?"selected='selected'":'');?> value="Georgia">Georgia</option>
			<option <?php echo (($selected=='Guam'						)?"selected='selected'":'');?> value="Guam">Guam</option>
			<option <?php echo (($selected=='Hawaii'					)?"selected='selected'":'');?> value="Hawaii">Hawaii</option>
			<option <?php echo (($selected=='Idaho'						)?"selected='selected'":'');?> value="Idaho">Idaho</option>
			<option <?php echo (($selected=='Illinois'					)?"selected='selected'":'');?> value="Illinois">Illinois</option>
			<option <?php echo (($selected=='Indiana'					)?"selected='selected'":'');?> value="Indiana">Indiana</option>
			<option <?php echo (($selected=='Iowa'						)?"selected='selected'":'');?> value="Iowa">Iowa</option>
			<option <?php echo (($selected=='Kansas'					)?"selected='selected'":'');?> value="Kansas">Kansas</option>
			<option <?php echo (($selected=='Kentucky'					)?"selected='selected'":'');?> value="Kentucky">Kentucky</option>
			<option <?php echo (($selected=='Louisiana'					)?"selected='selected'":'');?> value="Louisiana">Louisiana</option>
			<option <?php echo (($selected=='Maine'						)?"selected='selected'":'');?> value="Maine">Maine</option>
			<option <?php echo (($selected=='Maryland'					)?"selected='selected'":'');?> value="Maryland">Maryland</option>
			<option <?php echo (($selected=='Massachusetts'				)?"selected='selected'":'');?> value="Massachusetts">Massachusetts</option>
			<option <?php echo (($selected=='Michigan'					)?"selected='selected'":'');?> value="Michigan">Michigan</option>
			<option <?php echo (($selected=='Minnesota'					)?"selected='selected'":'');?> value="Minnesota">Minnesota</option>
			<option <?php echo (($selected=='Mississippi'				)?"selected='selected'":'');?> value="Mississippi">Mississippi</option>
			<option <?php echo (($selected=='Missouri'					)?"selected='selected'":'');?> value="Missouri">Missouri</option>
			<option <?php echo (($selected=='Montana'					)?"selected='selected'":'');?> value="Montana">Montana</option>
			<option <?php echo (($selected=='Nebraska'					)?"selected='selected'":'');?> value="Nebraska">Nebraska</option>
			<option <?php echo (($selected=='Nevada'					)?"selected='selected'":'');?> value="Nevada">Nevada</option>
			<option <?php echo (($selected=='New Hampshire'				)?"selected='selected'":'');?> value="New Hampshire">New Hampshire</option>
			<option <?php echo (($selected=='New Jersey'				)?"selected='selected'":'');?> value="New Jersey">New Jersey</option>
			<option <?php echo (($selected=='New Mexico'				)?"selected='selected'":'');?> value="New Mexico">New Mexico</option>
			<option <?php echo (($selected=='New York'					)?"selected='selected'":'');?> value="New York">New York</option>
			<option <?php echo (($selected=='North Carolina'			)?"selected='selected'":'');?> value="North Carolina">North Carolina</option>
			<option <?php echo (($selected=='North Dakota'				)?"selected='selected'":'');?> value="North Dakota">North Dakota</option>
			<option <?php echo (($selected=='Northern Mariana Islands'	)?"selected='selected'":'');?> value="Northern Mariana Islands">Northern Mariana Islands</option>
			<option <?php echo (($selected=='Ohio'						)?"selected='selected'":'');?> value="Ohio">Ohio</option>
			<option <?php echo (($selected=='Oklahoma'					)?"selected='selected'":'');?> value="Oklahoma">Oklahoma</option>
			<option <?php echo (($selected=='Oregon'					)?"selected='selected'":'');?> value="Oregon">Oregon</option>
			<option <?php echo (($selected=='Pennsylvania'				)?"selected='selected'":'');?> value="Pennsylvania">Pennsylvania</option>
			<option <?php echo (($selected=='Puerto Rico' 				)?"selected='selected'":'');?> value="Puerto Rico">Puerto Rico</option>
			<option <?php echo (($selected=='Rhode Island'				)?"selected='selected'":'');?> value="Rhode Island">Rhode Island</option>
			<option <?php echo (($selected=='South Carolina'			)?"selected='selected'":'');?> value="South Carolina">South Carolina</option>
			<option <?php echo (($selected=='South Dakota'				)?"selected='selected'":'');?> value="South Dakota">South Dakota</option>
			<option <?php echo (($selected=='Tennessee'					)?"selected='selected'":'');?> value="Tennessee">Tennessee</option>
			<option <?php echo (($selected=='Texas'						)?"selected='selected'":'');?> value="Texas">Texas</option>
			<option <?php echo (($selected=='Utah'						)?"selected='selected'":'');?> value="Utah">Utah</option>
			<option <?php echo (($selected=='Vermont'					)?"selected='selected'":'');?> value="Vermont">Vermont</option>
			<option <?php echo (($selected=='Virgin Islands'			)?"selected='selected'":'');?> value="Virgin Islands">Virgin Islands</option>
			<option <?php echo (($selected=='Virginia'					)?"selected='selected'":'');?> value="Virginia">Virginia</option>
			<option <?php echo (($selected=='Washington'				)?"selected='selected'":'');?> value="Washington">Washington</option>
			<option <?php echo (($selected=='West Virginia'				)?"selected='selected'":'');?> value="West Virginia">West Virginia</option>
			<option <?php echo (($selected=='Wisconsin'					)?"selected='selected'":'');?> value="Wisconsin">Wisconsin</option>
			<option <?php echo (($selected=='Wyoming'					)?"selected='selected'":'');?> value="Wyoming">Wyoming</option>
		</select><?php
	}

	public static function get_currencies_actives( $id, $name, $selected )
	{
		?><select <?php echo ((isNull($name)==FALSE)?"name='".$name."'":'');?> <?php echo ( ( isNull( $id ) == FALSE )? "id='" . $id . "'" : '' );?>>
			<optgroup label="Americas">
				<option <?php echo (($selected=='USD')?"selected='selected'":'');?> value="USD">U.S. Dollars  -  $</option>
				<option <?php echo (($selected=='CAD')?"selected='selected'":'');?> value="CAD">Canadian Dollars  -  CA$</option>
				<option <?php echo (($selected=='MXN')?"selected='selected'":'');?> value="MXN">Mexican Peso  -  Mex$</option>
				<option <?php echo (($selected=='BRL')?"selected='selected'":'');?> value="BRL">Brazilian Real  -  R$</option>
			</optgroup>
			<optgroup label="Europe">
				<option <?php echo (($selected=='EUR')?"selected='selected'":'');?> value="EUR">Euros  -  €</option>
				<option <?php echo (($selected=='GBP')?"selected='selected'":'');?> value="GBP">Pounds Sterling  -  £</option>
				<option <?php echo (($selected=='CZK')?"selected='selected'":'');?> value="CZK">Czech Koruna  -  Kč</option>
				<option <?php echo (($selected=='DKK')?"selected='selected'":'');?> value="DKK">Danish Krone  -  Dkr</option>
				<option <?php echo (($selected=='HUF')?"selected='selected'":'');?> value="HUF">Hungarian Forint  -  Ft</option>
				<option <?php echo (($selected=='NOK')?"selected='selected'":'');?> value="NOK">Norwegian Krone  -  Nkr</option>
				<option <?php echo (($selected=='PLN')?"selected='selected'":'');?> value="PLN">Polish Zloty  -  zł</option>
				<option <?php echo (($selected=='SEK')?"selected='selected'":'');?> value="SEK">Swedish Krona  -  Skr</option>
				<option <?php echo (($selected=='CHF')?"selected='selected'":'');?> value="CHF">Swiss Franc  -  Fr</option>
				<option <?php echo (($selected=='TRY')?"selected='selected'":'');?> value="TRY">Turkish Lira  -  ₤</option>
			</optgroup>
			<optgroup label="Asia Pacific">
				<option <?php echo (($selected=='JPY')?"selected='selected'":'');?> value="JPY">Japanese Yen  -  ¥</option>
				<option <?php echo (($selected=='AUD')?"selected='selected'":'');?> value="AUD">Australian Dollars  -  AU$</option>
				<option <?php echo (($selected=='NZD')?"selected='selected'":'');?> value="NZD">New Zealand Dollar  -  NZ$</option>
				<option <?php echo (($selected=='HKD')?"selected='selected'":'');?> value="HKD">Hong Kong Dollar  -  HK$</option>
				<option <?php echo (($selected=='SGD')?"selected='selected'":'');?> value="SGD">Singapore Dollar  -  SG$</option>
				<option <?php echo (($selected=='ILS')?"selected='selected'":'');?> value="ILS">Israeli Shekels  -  ₪</option>
				<option <?php echo (($selected=='MYR')?"selected='selected'":'');?> value="MYR">Malaysian Ringgits  -  RM</option>
				<option <?php echo (($selected=='PHP')?"selected='selected'":'');?> value="PHP">Philippine Pesos  -  ₱</option>
				<option <?php echo (($selected=='TWD')?"selected='selected'":'');?> value="TWD">Taiwan New Dollars  -  NT$</option>
				<option <?php echo (($selected=='THB')?"selected='selected'":'');?> value="THB">Thai baht  -  ฿</option>
			</optgroup>
		</select><?php
	}

	public static function get_languages( $id, $selected_lang, $class="" )
	{
		?><select name="<?php echo $id;?>" <?php echo ( ( isNull( $id ) == FALSE )? "id='" . $id . "'" : '' );?> class="<?php echo $id;?>">
			<option label="Chinese Simplified (简体中文)" value="zh_CN" <?php echo (($selected_lang=='zh_CN')?"selected='selected'":'');?>>Chinese Simplified (简体中文)</option>
			<option label="Chinese Traditional (繁體中文)" value="zh_HK" <?php echo (($selected_lang=='zh_HK')?"selected='selected'":'');?>>Chinese Traditional (繁體中文)</option>
			<option label="Dutch (Nederlands)" value="nl_NL" <?php echo (($selected_lang=='nl_NL')?"selected='selected'":'');?>>Dutch (Nederlands)</option>
			<option label="English" value="en_US" <?php echo (($selected_lang=='en_US')?"selected='selected'":'');?>>English</option>
			<option label="French (Français)" value="fr_FR" <?php echo (($selected_lang=='fr_FR')?"selected='selected'":'');?>>French (Français)</option>
			<option label="German (Deutsch)" value="de_DE" <?php echo (($selected_lang=='de_DE')?"selected='selected'":'');?>>German (Deutsch)</option>
			<option label="Indonesian (Bahasa Indonesia)" value="id_ID" <?php echo (($selected_lang=='id_ID')?"selected='selected'":'');?>>Indonesian (Bahasa Indonesia)</option>
			<option label="Italian (Italiano)" value="it_IT" <?php echo (($selected_lang=='it_IT')?"selected='selected'":'');?>>Italian (Italiano)</option>
			<option label="Japanese (日本語)" value="ja_JP" <?php echo (($selected_lang=='ja_JP')?"selected='selected'":'');?>>Japanese (日本語)</option>
			<option label="Korean (한국어)" value="ko_KO" <?php echo (($selected_lang=='ko_KO')?"selected='selected'":'');?>>Korean (한국어)</option>
			<option label="Polish (Język polski)" value="pl_PL" <?php echo (($selected_lang=='pl_PL')?"selected='selected'":'');?>>Polish (Język polski)</option>
			<option label="Português (Brasil)" value="pt_BR" <?php echo (($selected_lang=='pt_BR')?"selected='selected'":'');?>>Português (Brasil)</option>
			<option label="Russian (Русский язык)" value="ru_RU" <?php echo (($selected_lang=='ru_RU')?"selected='selected'":'');?>>Russian (Русский язык)</option>
			<option label="Spanish (Español)" value="es_ES" <?php echo (($selected_lang=='es_ES')?"selected='selected'":'');?>>Spanish (Español)</option>
			<option label="Thai (ภาษาไทย)" value="th_TH" <?php echo (($selected_lang=='th_TH')?"selected='selected'":'');?>>Thai (ภาษาไทย)</option>

			<option label="Arabic (العربية)" value="ar_AR" <?php echo (($selected_lang=='ar_AR')?"selected='selected'":'');?>>Arabic (العربية)</option>
			<option label="Croatian (Hrvatski)" value="hr_HR" <?php echo (($selected_lang=='hr_HR')?"selected='selected'":'');?>>Croatian (Hrvatski)</option>
			<option label="Czech (Český jazyk)" value="cs_CZ" <?php echo (($selected_lang=='cs_CZ')?"selected='selected'":'');?>>Czech (Český jazyk)</option>
			<option label="Danish (Dansk)" value="da_DA" <?php echo (($selected_lang=='da_DA')?"selected='selected'":'');?>>Danish (Dansk)</option>
			<option label="Greek (Ελληνική γλώσσα)" value="el_GR" <?php echo (($selected_lang=='el_GR')?"selected='selected'":'');?>>Greek (Ελληνική γλώσσα)</option>
			<option label="Hebrew (אָלֶף־בֵּית עִבְרִי‎‎)" value="he_IL" <?php echo (($selected_lang=='he_IL')?"selected='selected'":'');?>>Hebrew (אָלֶף־בֵּית עִבְרִי‎‎)</option>
			<option label="Hindi (हिंदी)" value="hi_IN" <?php echo (($selected_lang=='hi_IN')?"selected='selected'":'');?>>Hindi (हिंदी)</option>
			<option label="Malay (Melayu)" value="ms_MY" <?php echo (($selected_lang=='ms_MY')?"selected='selected'":'');?>>Malay (Melayu)</option>
			<option label="Norwegian (Norsk)" value="no_NO" <?php echo (($selected_lang=='no_NO')?"selected='selected'":'');?>>Norwegian (Norsk)</option>
			<option label="Persian (زبان فارسی)" value="fa_IR" <?php echo (($selected_lang=='fa_IR')?"selected='selected'":'');?>>Persian (زبان فارسی)</option>
			<option label="Portuguese (Português)" value="pt_PT" <?php echo (($selected_lang=='pt_PT')?"selected='selected'":'');?>>Portuguese (Português)</option>
			<option label="Romanian (Limba română)" value="ro_RO" <?php echo (($selected_lang=='ro_RO')?"selected='selected'":'');?>>Romanian (Limba română)</option>
			<option label="Swedish (Svenska)" value="sv_SE" <?php echo (($selected_lang=='sv_SE')?"selected='selected'":'');?>>Swedish (Svenska)</option>
			<option label="Turkish (Türkçe)" value="tr_TR" <?php echo (($selected_lang=='tr_TR')?"selected='selected'":'');?>>Turkish (Türkçe)</option>
			<option label="Urdu (ﺍﺭﺩﻭ)" value="ur_PK" <?php echo (($selected_lang=='ur_PK')?"selected='selected'":'');?>>Urdu (ﺍﺭﺩﻭ)</option>
			<option label="Welsh (Cymraeg)" value="cy_GB" <?php echo (($selected_lang=='cy_GB')?"selected='selected'":'');?>>Welsh (Cymraeg)</option>
		</select><?php
	}

	public static function get_bank_accounts_types( $id, $name, $selected )
	{
		?><select <?php echo ((isNull($name)==FALSE)?"name='".$name."'":'');?> <?php echo ( ( isNull( $id ) == FALSE )? "id='" . $id . "'" : '' );?> data-validation="required" data-validation-error-msg="The bank account type is required">
			<option <?php echo ( ( $selected == '' 			)? "selected='selected'" : '' ); ?> value="">Select...</option>
			<option <?php echo ( ( $selected == 'CHECKING' 	)? "selected='selected'" : '' ); ?> value="CHECKING">Checking</option>
			<option <?php echo ( ( $selected == 'SAVING' 	)? "selected='selected'" : '' ); ?> value="SAVING">Saving</option>
		</select><?php
	}

	public static function get_tax_entities( $id, $name, $entity_type, $selected='0' )
	{
		?><select <?php echo ( ( isNull( $name ) == FALSE )? "name='" . $name . "'" : '' ); ?> <?php echo ( ( isNull( $id ) == FALSE )? "id='" . $id . "'" : '' );?> style="width:406px;">
			<?php foreach ( HC_Constants::$TYPE_ENTITIES_[ $entity_type ] as $id => $name ) { ?>
				<option value="<?php echo $id;?>" <?php echo ( ( intval( $id ) == intval( $selected ) )? "selected='selected'" : '' ); ?>><?php echo $name;?></option>
			<?php } ?>
		</select><?php
	}

	public static function get_purposes( $id, $name, $selected )
	{
		?><select <?php echo ( ( isNull( $id ) == FALSE )? "id='" . $id . "'" : '' );?> <?php echo ((isNull($name)==FALSE)?"name='".$name."'":'');?> data-validation="required">
			<?php $el_ = EssDTD::getFeedDTD(); foreach ( $el_['categories']['types'] as $i => $type ) { ?>
				<option value="<?php echo strtolower( $type );?>" <?php echo ((strtolower( $selected) == strtolower( $type ))?"selected='selected'":'');?>><?php echo ucfirst_( $type );?></option>
			<?php } ?>
		</select><?php
	}

	public static function get_orders_types( $id, $name, $selected='' )
	{
		?><select <?php echo ((isNull($name)==FALSE)?"name='".$name."'":'');?> <?php echo ( ( isNull( $id ) == FALSE )? "id='" . $id . "'" : '' );?>>
			<option <?php echo ( ( $selected == ""					)?"selected='selected'" : '' );?> value="">All Orders</option>
			<option <?php echo ( ( $selected == 'TICKETS_BOUGHT'	)?"selected='selected'" : '' );?> value="TICKETS_BOUGHT">Tickets Bought</option>
			<option <?php echo ( ( $selected == 'TICKETS_SOLD'		)?"selected='selected'" : '' );?> value="TICKETS_SOLD">Tickets Solds</option>
		</select><?php
	}

	public static function get_taxid_type( $id, $name, $selected='', $className='' )
	{
		?><select <?php echo ( ( isNull( $name ) == FALSE )? "name='" . $name . "'" : '' ); ?> <?php echo ( ( isNull( $id ) == FALSE )? "id='" . $id . "'" : '' ); ?> class="<?php echo $className;?>">
			<option <?php echo ( ( $selected == 'NATIONAL'	)?"selected='selected'" : '' );?> value="NATIONAL">Country specific Tax ID</option>
			<option <?php echo ( ( $selected == 'EIN'		)?"selected='selected'" : '' );?> value="EIN">U.S. Employer Identification Number</option>
			<option <?php echo ( ( $selected == 'SSN'		)?"selected='selected'" : '' );?> value="SSN">U.S. Social Security Number</option>
		</select><?php
	}

	public static function get_events_status( $id, $name, $selected='' )
	{
		?><select <?php echo ((isNull($name)==FALSE)?"name='".$name."'":'');?> <?php echo ( ( isNull( $id ) == FALSE )? "id='" . $id . "'" : '' );?>>
			<option <?php echo ( ( $selected == ""								)?"selected='selected'" : '' );?> value=""><?php _e( 'All events', 'dbem' );?></option>
			<option <?php echo ( ( $selected == HC_Constants::STATUS_DRAFT		)?"selected='selected'" : '' );?> value="<?php echo HC_Constants::STATUS_DRAFT;		?>"><?php _e( 'Draft', 'dbem' );?></option>
		<!--<option <?php echo ( ( $selected == HC_Constants::STATUS_PAST		)?"selected='selected'" : '' );?> value="<?php echo HC_Constants::STATUS_PAST;		?>"><?php _e( 'Past events', 'dbem' );?></option>-->
			<option <?php echo ( ( $selected == HC_Constants::STATUS_PUBLISH	)?"selected='selected'" : '' );?> value="<?php echo HC_Constants::STATUS_PUBLISH;	?>"><?php _e( 'Live events', 'dbem' );?></option>
			<option <?php echo ( ( $selected == HC_Constants::STATUS_DELETE		)?"selected='selected'" : '' );?> value="<?php echo HC_Constants::STATUS_DELETE;	?>"><?php _e( 'Deleted', 'dbem' );?></option>
		</select><?php
	}


	public static function get_tabulation( $class, $id='main_tabs' )
	{
		$tabs_ = $class::get_tabs_data();

		?><div <?php echo ( ( isNull( $id ) == FALSE )? "id='" . $id . "'" : '' );?> style="display:none;" class="main_tabs">
			<ul>
				<?php foreach ( $tabs_ as $TAB_ ) { ?>
					<li><a href="#tabs-<?php echo $TAB_['id'];?>">
						<i class="fa <?php echo $TAB_['icon'];?>"></i>
						<b><?php echo $TAB_['name'];?></b>
					</a></li>
				<?php } ?>
			</ul>
			<?php $tab_exists = FALSE;
			 	foreach ( $tabs_ as $i => $TAB_ ) { ?>
				<?php if ( strtolower( @$_REQUEST['tab'] ) == $TAB_['id'] ) {
					$tab_exists = TRUE;?>
					<script>var selected_tab_index=<?php echo $i;?>;</script>
				<?php } ?>
				<div id="tabs-<?php echo $TAB_['id'];?>" <?php echo ( ( @$_REQUEST['tab'] != $TAB_['id'] )? "style='display:none;'" : '' );?>>
					<?php $func = 'get_'.$TAB_['id']; $class::$func(); ?>
				</div>
			<?php }
			if ( $tab_exists == FALSE ) { ?>
			<script>var selected_tab_index=0;</script>
			<?php } ?>
		</div><?php
	}
}