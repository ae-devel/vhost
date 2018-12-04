<?php

	try {
		
		$Data = array();


		$Data = array( 
			'page_title' => 'My little world',
			'server_name' => $_SERVER[ 'SERVER_NAME' ],
			'template_path' => '/tpl/indextemplate',
		);
		
		include_once PATH_TPL_DIR . '/indextemplate/index.tpl';

	} catch( Exception $Ex ) {
		
		CommonFunctions::displayError( $Ex->getMessage() );
		
	}
