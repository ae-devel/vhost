<?php

	try {
		
		$Data = array();


		$Data = array( 
			'page_title' => '500, Error',
			'template_path' => '/tpl',
			'ErrorMessage' => isset( $ErrorMessage ) ? $ErrorMessage : '',
		);
		
		include_once PATH_TPL_DIR . '/system/Error.tpl';

	} catch( Exception $Ex ) {
		
		CommonFunctions::displayError( $Ex->getMessage() );
		
	}
