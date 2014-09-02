<?php if ( !EM_HYPECAL_AUTHORIZED ){ die( "Hacking Attempt: ". @$_SERVER[ 'REMOTE_ADDR' ] ); }
/**
  * Controller HC_Control_admin
  * Control the user interaction with Admin page
  *
  * @author  	https://www.hypecal.com
  * @copyright 	Copyright Hypecal.com.
  * @license   	https://www.hypecal.com/terms
  */
final class HC_Control_admin
{
	function __construct(){}

	public static function control_forms()
	{
		if ( !isset( $_POST[ 'save_finance' ] ) || empty( $_POST[ 'save_finance' ] ) ) return;

		global $HC_Notices;

		$f_ = array_keys( @$_POST[ 'save_finance' ] );
		$form = $f_[0];

		if ( strlen( $form ) > 0 )
		{
			$api = new HC_API();
			$r 	 = NULL;

			switch( $form )
			{
				case "billing_account" :
					$r = $api->call( 'account/billing_address/update.json', $_POST[ $form ], 'POST' );
					break;

				case "bank_account" :
					$_POST[ $form ][ 'aggreement' ] = ( ( $_POST[ $form ][ 'aggreement' ] == 'on' )? HC_Constants::AGGREEMENT_YES : HC_Constants::AGGREEMENT_YES );
					$r = $api->call( 'account/bank_account/update.json', $_POST[ $form ], 'POST' );
					break;

				case "taxpayer" :
					$POST_ = array();
					$POST_[ 'applicable' 	] = ( ( @$_POST[ $form ][ 'applicable'    ] == 'on' )? 'y' 									: 'n' );
					$POST_[ 'taxpayer_type' ] = ( ( @$_POST[ $form ][ 'taxpayer_type' ] == 'on' )? HC_Constants::TYPE_TAXPAYER_BUSINESS 	: HC_Constants::TYPE_TAXPAYER_INDIVIDUAL );
					$POST_[ 'entity_form' 	] = ( ( @$_POST[ $form ][ 'entity_form'   ] == 'on' )? HC_Constants::TYPE_ENTITY_FORM_W9 		: HC_Constants::TYPE_ENTITY_FORM_W8BEN   );
					$POST_[ 'currency' 		] = $_POST[ $form ][ 'currency' ];
					$POST_[ 'rate'			] = $_POST[ $form ][ 'rate'  	];

					$entity_form = $POST_[ 'entity_form' ];
					// -- W9 / W8BEN ---
					$POST_[ 'full_name' 		 ] = @$_POST[ $form ][ $entity_form ][ 'full_name' 			];
					$POST_[ 'business_name' 	 ] = @$_POST[ $form ][ $entity_form ][ 'business_name'		];
					$POST_[ 'country_code'		 ] = @$_POST[ $form ][ $entity_form ][ 'country_code'		];
					$POST_[ 'address'			 ] = @$_POST[ $form ][ $entity_form ][ 'address'			];
					$POST_[ 'city'			 	 ] = @$_POST[ $form ][ $entity_form ][ 'city'				];
					$POST_[ 'zip'				 ] = @$_POST[ $form ][ $entity_form ][ 'zip'				];
					$POST_[ 'state'				 ] = @$_POST[ $form ][ $entity_form ][ 'state'				];
					$POST_[ 'entity_type'		 ] = @$_POST[ $form ][ $entity_form ][ 'entity_type'		];
					$POST_[ 'taxid'				 ] = @$_POST[ $form ][ $entity_form ][ 'taxid'				];
					$POST_[ 'taxid_type'		 ] = @$_POST[ $form ][ $entity_form ][ 'taxid_type'			];
					$POST_[ 'signature'			 ] = @$_POST[ $form ][ $entity_form ][ 'signature'			];
					$POST_[ 'signature_capacity' ] = @$_POST[ $form ][ $entity_form ][ 'signature_capacity' ];

					//d( $POST_ );

					$r = $api->call( 'account/taxpayer/update.json', $POST_, 'POST' );
					break;
			}

			if ( $r != NULL )
			{
				if 		( isset( $r->result->result 		) ) $HC_Notices->add_info(  $r->result->result 			);
				else if ( isset( $r->result->error->message ) ) $HC_Notices->add_error( $r->result->error->message 	);
			}

			//d( $form, $_POST[ $form ], $r, $HC_Notices );

			if ( strlen( $HC_Notices->get_errors() ) <= 0 && strlen( $HC_Notices->get_infos() ) <= 0 )
				$HC_Notices->add_info( __( sprintf( "The %s page have been save correctly.", str_replace( '_', ' ', $form ) ), 'dbem' ) );
		}
	}



}