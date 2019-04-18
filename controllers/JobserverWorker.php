<?php
	$GearmanSettings = array(
		'host' => '10.0.1.112',
		'port' => '4730',
	);
	
	$GearmanWorker = new GearmanWorker();
	$GearmanWorker->addServers( sprintf( '%s:%s', $GearmanSettings[ 'host' ], $GearmanSettings[ 'port' ] ) );
	$GearmanWorker->addFunction( 'makeTheProcess', 'make_the_process' );
	
	while( $GearmanWorker->work() );
	
	function make_the_process( $JobData ) {
		$Data = @json_decode( $JobData->workload() );
		$Data = @get_object_vars( $Data );
		
		if ( empty( $Data[ 'id' ] ) ) {
			return false;
		}
		
		sleep( rand( 1, 5 ) );
		
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
			return false;
		}
		
		$UpdateQuery = $MasterPDO->prepare( 'UPDATE `vhost_codes` SET `row_code_processed`=:code WHERE id=:id' );
		$UpdateQuery->execute(
			array(
				'code' => hash( 'md5', microtime() . rand( 1, 1000 ) ),
				'id' => $Data[ 'id' ]
			)
		);
		
		return false;
	}
