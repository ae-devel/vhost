<?php

	try {
		
		$Data = array();


		$Data = array( 
			'page_title' => 'Replication',
			'server_name' => $_SERVER[ 'SERVER_NAME' ],
			'template_path' => '/tpl/replicationtemplate',
		);
		
		include_once PATH_TPL_DIR . '/replicationtemplate/index.tpl';

	} catch( Exception $Ex ) {
		
		CommonFunctions::displayError( $Ex->getMessage() );
		
	}
