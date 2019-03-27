<?php

	try {

		$Data = array();

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
			CommonFunctions::showErrorPage( $Ex->getMessage() );
		}


		$CodesQuery = $SlavePDO->prepare( 'SELECT * FROM `vhost_codes`' );
		$CodesQuery->execute( array() );
		$Codes = $CodesQuery->fetchAll();

		
		$Data = array( 
			'page_title' => 'Replication',
			'server_name' => $_SERVER[ 'SERVER_NAME' ],
			'template_path' => '/tpl/replicationtemplate',
			'codes' => $Codes,
			'slave_host' => $SlaveHostData[ 'host' ],
			'master_host' => $MasterHostData[ 'host' ],
		);
		
		include_once PATH_TPL_DIR . '/replicationtemplate/index.tpl';

	} catch( Exception $Ex ) {
		
		CommonFunctions::showErrorPage( $Ex->getMessage() );
		
	}
