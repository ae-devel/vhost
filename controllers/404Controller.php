<?php

	try {
		
		$Data = array();


		$Data = array( 
			'page_title' => '404, Page not found',
			'template_path' => '/tpl'
		);
		
		include_once PATH_TPL_DIR . '/system/404.tpl';

	} catch( Exception $Ex ) {
		
		CommonFunctions::displayError( $Ex->getMessage() );
		
	}
