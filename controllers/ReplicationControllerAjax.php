<?php

	try {

		$Data = array();
		$Response = array();


		if ( ! isset( $_REQUEST[ 'action' ] ) ) {
			throw new Exception( 'Action not sepcified' );
		}

		
		switch( $_REQUEST[ 'action' ] ) {
			case 'insert_code':
				
				$MasterHostData = array(
					'host' => 'rasp1.dev',
					'dbname' => 'vhost_replication',
					'user' => 'vhost',
					'pass' => '1235',
				);
				
				$SlaveHostData = array(
					'host' => 'rasp2.dev',
					'dbname' => 'vhost_replication',
					'user' => 'vhost',
					'pass' => '1235',
				);
				
				$PDOOptions = array(
					PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES => false,
				);

				try {
					$MasterPDO = new PDO("mysql:host=" . $MasterHostData[ 'host' ] . ";dbname=" . $MasterHostData[ 'dbname' ] . ";charset=UTF8", $MasterHostData[ 'user' ], $MasterHostData[ 'pass' ], $PDOOptions );
					$SlavePDO = new PDO("mysql:host=" . $SlaveHostData[ 'host' ] . ";dbname=" . $SlaveHostData[ 'dbname' ] . ";charset=UTF8", $SlaveHostData[ 'user' ], $SlaveHostData[ 'pass' ], $PDOOptions );
				}
				catch( PDOException $Ex ) {
					throw new Exception( 'Database connection error' );
				}
				
				$RowValues = array(
					'row_time' => date( 'Y-m-d H:i:s' ),
					'row_code' => hash( 'md5', microtime() . rand( 1, 1000 ) ),
				);
				
				$MasterTotalRows = $MasterPDO->query( 'SELECT COUNT(*) FROM `vhost_codes`' )->fetchColumn();
				if ( $MasterTotalRows < 20 ) {
					$CodeQuery = $MasterPDO->prepare( 'INSERT INTO `vhost_codes` ( `row_time`, `row_code` ) VALUES( :row_time, :row_code )' );
					$CodeQuery->execute( $RowValues );
				}
				
				$SlaveRows = $SlavePDO->query( 'SELECT * FROM `vhost_codes`' )->fetchAll();

				$Response = array(
					'status' => 'ok',
					'error' => '',
					'data' => $SlaveRows
				);
				
				break;
				
				

			case 'refresh_codes':
				
				$SlaveHostData = array(
					'host' => 'rasp2.dev',
					'dbname' => 'vhost_replication',
					'user' => 'vhost',
					'pass' => '1235',
				);
				
				$PDOOptions = array(
					PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES => false,
				);

				try {
					$SlavePDO = new PDO("mysql:host=" . $SlaveHostData[ 'host' ] . ";dbname=" . $SlaveHostData[ 'dbname' ] . ";charset=UTF8", $SlaveHostData[ 'user' ], $SlaveHostData[ 'pass' ], $PDOOptions );
				}
				catch( PDOException $Ex ) {
					throw new Exception( 'Database connection error' );
				}
				
				$SlaveRows = $SlavePDO->query( 'SELECT * FROM `vhost_codes`' )->fetchAll();

				$Response = array(
					'status' => 'ok',
					'error' => '',
					'data' => $SlaveRows
				);
				
				break;
				
				
			case 'clear_codes':
				
				$MasterHostData = array(
					'host' => 'rasp1.dev',
					'dbname' => 'vhost_replication',
					'user' => 'vhost',
					'pass' => '1235',
				);
				
				$PDOOptions = array(
					PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES => false,
				);

				try {
					$MasterPDO = new PDO("mysql:host=" . $MasterHostData[ 'host' ] . ";dbname=" . $MasterHostData[ 'dbname' ] . ";charset=UTF8", $MasterHostData[ 'user' ], $MasterHostData[ 'pass' ], $PDOOptions );
				}
				catch( PDOException $Ex ) {
					throw new Exception( 'Database connection error' );
				}
				
				$RowValues = array(
					'row_time' => date( 'Y-m-d H:i:s' ),
					'row_code' => hash( 'md5', microtime() . rand( 1, 1000 ) ),
				);
				
				$MasterPDO->query( 'DELETE FROM `vhost_codes`' );

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
