<?php

	try {

		$Data = array();
		
		session_start();

		if ( $_SERVER[ 'SERVER_NAME' ] === 'vhost.rasp1.dev' ) {
			$_SESSION[ 'data' ] = $_SERVER[ 'HTTP_USER_AGENT' ];
		}

		$Data = array( 
			'page_title' => 'Memcache session',
			'server_name' => $_SERVER[ 'SERVER_NAME' ],
			'template_path' => '/tpl/memcachesessiontemplate',
			'session_data' => isset( $_SESSION[ 'data' ] ) ? $_SESSION[ 'data' ] : 'Not found',
		);
		
		include_once PATH_TPL_DIR . '/memcachesessiontemplate/index.tpl';

	} catch( Exception $Ex ) {
		
		CommonFunctions::showErrorPage( $Ex->getMessage() );
		
	}
