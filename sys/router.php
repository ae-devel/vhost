<?php

	if ( empty( $_SERVER[ 'REQUEST_URI' ]) ) {
		throw new Exception( 'Fail. REQUEST_URI is empty' );
	}

	switch( $_SERVER[ 'REQUEST_URI' ] ) {
		
		
		case '/':
		
			include_once PATH_CONTROLLERS_DIR . '/IndexController.php';
		
			break;

        case '/replication/':
		
			include_once PATH_CONTROLLERS_DIR . '/ReplicationController.php';
		
			break;
		
		
			
		default:
		
			include_once PATH_CONTROLLERS_DIR . '/404Controller.php';
		
			break;

	}
