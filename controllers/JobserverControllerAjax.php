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
				
				$PDOOptions = array(
					PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES => false,
				);

				try {
					$MasterPDO = new PDO("mysql:host=" . $MasterHostData[ 'host' ] . ";dbname=" . $MasterHostData[ 'dbname' ] . ";charset=UTF8", $MasterHostData[ 'user' ], $MasterHostData[ 'pass' ], $PDOOptions );
				} catch( PDOException $Ex ) {
					throw new Exception( 'Database connection error' );
				}
				
				$RowValues = array(
					'row_time' => date( 'Y-m-d H:i:s' ),
					'row_code' => hash( 'md5', microtime() . rand( 1, 1000 ) ),
					'row_code_processed' => null,
				);
				
				$MasterTotalRows = $MasterPDO->query( 'SELECT COUNT(*) FROM `vhost_codes`' )->fetchColumn();

				if ( $MasterTotalRows < 20 ) {
					$CodeQuery = $MasterPDO->prepare( 'INSERT INTO `vhost_codes` ( `row_time`, `row_code`, `row_code_processed` ) VALUES( :row_time, :row_code, :row_code_processed )' );
					$CodeQuery->execute( $RowValues );
					$RowValues[ 'id' ] = $MasterPDO->lastInsertId();
				}
				

				$GearmanSettings = array(
					'host' => '10.0.1.112',
					'port' => '4730',
				);
				$GearmanClient = new GearmanClient();
				$GearmanClient->addServers( sprintf( '%s:%s', $GearmanSettings[ 'host' ], $GearmanSettings[ 'port' ] ) );

				$GearmanClient->doBackground( 'makeTheProcess', json_encode( $RowValues ) );

				$Response = array(
					'status' => 'ok',
					'error' => '',
					'data' => $RowValues
				);
				
				break;
				
				

			case 'refresh_codes':
				
				$MasterHostData = array(
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
				}
				catch( PDOException $Ex ) {
					throw new Exception( 'Database connection error' );
				}
				
				$Codes = $MasterPDO->query( 'SELECT * FROM `vhost_codes`' )->fetchAll();
				
				$Response = array(
					'status' => 'ok',
					'error' => '',
					'data' => $Codes
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
				
				
			case 'check_job_accomplishment':
				if ( ! isset( $_REQUEST[ 'row_id' ] ) ) {
					throw new Exception( 'Wrong data' );
				}
				
				$RowId = ( int ) $_REQUEST[ 'row_id' ];
				
				if ( ! isset( $_REQUEST[ 'row_id' ] ) ) {
					throw new Exception( 'Wrong data' );
				}
				
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
				} catch( PDOException $Ex ) {
					throw new Exception( 'Database connection fail' );
				}
				
				$CodesQuery = $SlavePDO->prepare( 'SELECT * FROM `vhost_codes` WHERE id=:id' );
				$CodesQuery->execute( array( 'id' => $RowId ) );
				$Codes = $CodesQuery->fetchAll();
				
				if ( ! empty( $Codes ) ) {
					$Codes = array_pop( $Codes );
				}
				

				if ( ! empty( $Codes[ 'row_code_processed' ] ) ) {
					$Response = array(
						'status' => 'ok',
						'error' => '',
						'data' => array(
							'row_id' => $Codes[ 'id' ],
							'row_code_processed' => $Codes[ 'row_code_processed' ],
						),
					);
					
					break;
				}

				$Response = array(
					'status' => 'error',
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
