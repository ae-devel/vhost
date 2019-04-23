<?php

	try {

		$Data = array();
		$Response = array();


		if ( ! isset( $_REQUEST[ 'action' ] ) ) {
			throw new Exception( 'Action not sepcified' );
		}

		
		switch( $_REQUEST[ 'action' ] ) {
			case 'flush_cache':

				$MemcacheHandler = new Memcache();
				$MemcacheHandler->connect( 'rasp1.dev', 11211 );
				$MemcacheHandler->flush();
				$MemcacheHandler->connect( 'rasp2.dev', 11211 );
				$MemcacheHandler->flush();
				
				$Response = array(
					'status' => 'ok',
					'error' => '',
				);
				
				break;
				

			default:
			
				throw new Exception( 'Wrong action' );
			
				break;
			
		}

	} catch( Exception $Ex ) {
		$Response = array(
			'status' => 'error',
			'error' => $Ex->getMessage(),
		);
	}

	CommonFunctions::submitJsonResponse( $Response );
