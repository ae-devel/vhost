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
			
		case '/failover/':
		
			include_once PATH_CONTROLLERS_DIR . '/FailoverController.php';
		
			break;
			
		case '/failover_ajax/':
		
			include_once PATH_CONTROLLERS_DIR . '/FailoverControllerAjax.php';
		
			break;
			
		case '/jobserver/':
		
			include_once PATH_CONTROLLERS_DIR . '/JobserverController.php';
		
			break;
			
			
		case '/jobserver_ajax/':
		
			include_once PATH_CONTROLLERS_DIR . '/JobserverControllerAjax.php';
		
			break;
			
			
		case '/memcache/':
		
			include_once PATH_CONTROLLERS_DIR . '/MemcacheController.php';
		
			break;
			
			
		case '/memcache_ajax/':
		
			include_once PATH_CONTROLLERS_DIR . '/MemcacheControllerAjax.php';
		
			break;
		
		
			
		default:
		
			include_once PATH_CONTROLLERS_DIR . '/404Controller.php';
		
			break;

	}
