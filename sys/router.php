<?php

	if ( empty( $_SERVER[ 'REQUEST_URI' ]) ) {
		CommonFunctions::showErrorPage( 'Fail. REQUEST_URI is empty' );
	}

	switch( $_SERVER[ 'REQUEST_URI' ] ) {
		
		
		case '/':
		
			include_once PATH_CONTROLLERS_DIR . '/IndexController.php';
		
			break;

        case '/replication/':
		
			include_once PATH_CONTROLLERS_DIR . '/ReplicationController.php';
		
			break;
			
		case '/replication_ajax/':
		
			include_once PATH_CONTROLLERS_DIR . '/ReplicationControllerAjax.php';
		
			break;
		
		
			
		default:
		
			include_once PATH_CONTROLLERS_DIR . '/404Controller.php';
		
			break;

	}
