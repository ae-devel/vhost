<?php

	try {

		$Data = array();
		$Response = array();


		if ( ! isset( $_REQUEST[ 'action' ] ) ) {
			throw new Exception( 'Action not sepcified' );
		}

		
		switch( $_REQUEST[ 'action' ] ) {
			case 'shutdown_master':

				$FilePath = PATH_DATA_DIR . '/db_shutdown_flag.txt';
				$FileHandler = fopen( $FilePath, 'w' );
				fclose( $FileHandler );
				
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
