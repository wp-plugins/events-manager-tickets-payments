<?php
if ( !defined( 'EM_HYPECAL_PROTOCOL' 	) ) define( 'EM_HYPECAL_PROTOCOL',  'http'.( ( @$_SERVER[ 'HTTPS' ] == 'on' )? 's' : ''  ) . '://' );
if ( !defined( 'EM_HYPECAL_AUTHORIZED' 	) ) define( 'EM_HYPECAL_AUTHORIZED', TRUE );
if ( !defined( 'EM_HYPECAL_NAME' 		) ) define( 'EM_HYPECAL_NAME', 		 trim( str_replace( '/inc/config', '', dirname( plugin_basename( __FILE__ ) ) ), '/' ) );
if ( !defined( 'EM_HYPECAL_DIR'  		) ) define( 'EM_HYPECAL_DIR', 		 WP_PLUGIN_DIR . '/' . EM_HYPECAL_NAME );
if ( !defined( 'EM_HYPECAL_DIR_URI'  	) ) define( 'EM_HYPECAL_DIR_URI', 	 trailingslashit( str_replace( '/inc/config', '', plugins_url( '', __FILE__ ) ) ) );
if ( !defined( 'EM_HYPECAL_URL'  		) ) define( 'EM_HYPECAL_URL', 		 WP_PLUGIN_URL . '/' . EM_HYPECAL_NAME );

if ( !defined( 'EM_HYPECAL_VERSION'		) ) define( 'EM_HYPECAL_VERSION', 	 '0.1' );
if ( !defined( 'EM_HYPECAL_VERSION_KEY'	) ) define( 'EM_HYPECAL_VERSION_KEY','hypecal_version' );

if ( !defined( 'WP_CACHE' 				) ) define('WP_CACHE', 				 TRUE );

abstract class HC_Constants
{
	const NAME 						= 'em-hypecal';
	const EM_HC_ARGUMENT 			= 'hypecal';

	const PLUGIN_WEBSITE			= 'http://wp-events-plugin.com';
	const ESS_WEBSITE				= 'http://wordpress.org/plugins/events-manager-ess/';
	const HYPECAL_WEBSITE			= 'https://www.hypecal.com';
	const HYPECAL_DEV				= 'http://localhost:8080';

	const DEFAULT_CURRENCY			= 'USD';

	const TYPE_TAXPAYER_BUSINESS 	= 'BUSINESS';
	const TYPE_TAXPAYER_INDIVIDUAL	= 'INDIVIDUAL';

	const TYPE_TAXID_NATIONAL		= 'NATIONAL';
	const TYPE_TAXID_EIN			= 'EIN';
	const TYPE_TAXID_SSN			= 'SSN';

	const TYPE_ENTITY_FORM_W9		= 'W9';
	const TYPE_ENTITY_FORM_W8BEN	= 'W8BEN';



	const FONT_ARIAL 				= 'Arial';
	const FONT_COURIER 				= 'Courier';
	const FONT_HELVETICA 			= 'Helvetica';
	const FONT_TIMES				= 'Times';

	const FORMAT_LETTER				= 'Letter';
	const FORMAT_A4					= 'A4';

	const TYPE_CHECKING 			= 'CHECKING';
	const TYPE_SAVING				= 'SAVING';

	const AGGREEMENT_YES 			= 'yes';
	const AGGREEMENT_NO 			= 'no';

	const TRANSFER_TYPE_BANK		= 'bank';
	const TRANSFER_TYPE_PAYPAL		= 'paypal';


	const STATUS_PUBLISH 		= 'PUBLISH';
	const STATUS_PAST 			= 'PAST';
	const STATUS_DRAFT  		= 'DRAFT';
	const STATUS_DELETE  		= 'DELETE';

	const STATUS_CANCELED		= 'CANCELED';
	const STATUS_ATTENDS		= 'ATTENDS';
	const STATUS_PENDING		= 'PENDING';
	const STATUS_MAYBE			= 'MAYBE';
	const STATUS_SAVED 			= 'SAVED';

	const STATUS_BILLING		= 'BILLING';
	const STATUS_PROCESSING 	= 'PROCESSING';

	public static $TYPE_ENTITIES_ 	= array(
		'W9' => array(
			'0'	 	=> 'Select One',
			'1'  	=> "Individual/Sole Proprietor",
			'2'	 	=> "C Corporation",
			'3'	 	=> "S Corporation",
			'4'	 	=> "Partnership",
			'5'	 	=> "Trust/estate",
			'21'	=> "Limited liability company (C Corporation)",
			'22'	=> "Limited liability company (S Corporation)",
			'23'	=> "Limited liability company (Partnership)",
			'19'	=> "Exempt Payee",
			'20'	=> "Other"
		),
		'W8BEN' => array(
			'0'	 	=> 'Select One',
			"6" 	=> "Grantor Trust",
			"7" 	=> "Central bank of issue",
			"8" 	=> "Individual",
			"9" 	=> "Complex trust",
			"10" 	=> "Tax-exempt organization",
			"11" 	=> "Corporation",
			"12" 	=> "Estate",
			"13" 	=> "Private foundation",
			"14" 	=> "Disregarded entity",
			"15" 	=> "Government",
			"16" 	=> "Partnership",
			"17" 	=> "International organization",
			"18" 	=> "Simple trust"
		)
	);
}

function isNull( $str )
{
	if ( !isset( $str ) ) return TRUE;

	$str = str_replace( array( '-',' ', '	', '\n', '\r' ), '', trim( (string)$str ) );
	return ( $str == '' || $str == NULL )? TRUE : FALSE;
}
