<?php

	try {

		$Data = array();

		$MasterHostData = array(
			'host' => 'rasp1.dev',
			'dbname' => 'vhost_replication',
			'user' => 'vhost',
			'pass' => '1235',
		);
		
		$PDOOptions = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		);
		
		$GearmanSettings = array(
			'host' => '10.0.1.112',
			'port' => '4730',
			'mysql_host' => 'rasp1.dev',
			'mysql_port' => '3306',
			'mysql_user' => 'gearman',
			'mysql_pass' => '1235',
			'mysql_db' => 'gearman',
			'mysql_table' => 'queue',
		);
		
		try {  
			$MasterPDO = new PDO("mysql:host=" . $MasterHostData[ 'host' ] . ";dbname=" . $MasterHostData[ 'dbname' ] . ";charset=UTF8", $MasterHostData[ 'user' ], $MasterHostData[ 'pass' ], $PDOOptions );
		} catch( PDOException $Ex ) {
			CommonFunctions::showErrorPage( $Ex->getMessage() );
		}
		
		$CodesQuery = $MasterPDO->prepare( 'SELECT * FROM `vhost_codes`' );
		$CodesQuery->execute();
		$Codes = $CodesQuery->fetchAll();
		
		$GearmanRunCommand = sprintf(
			'gearmand --queue-type=MySQL --mysql-host=%s --mysql-port=%s --mysql-user=%s --mysql-password=%s --mysql-db=%s --mysql-table=%s',
			$GearmanSettings[ 'mysql_host' ],
			$GearmanSettings[ 'mysql_port' ],
			$GearmanSettings[ 'mysql_user' ],
			$GearmanSettings[ 'mysql_pass' ],
			$GearmanSettings[ 'mysql_db' ],
			$GearmanSettings[ 'mysql_table' ]
		);
		
		$Data = array( 
			'page_title' => 'Jobserver',
			'codes' => $Codes,
			'server_name' => $_SERVER[ 'SERVER_NAME' ],
			'master_host' => $MasterHostData[ 'host' ],
			'gearman_run_command' => $GearmanRunCommand,
			'gearman_settings' => $GearmanSettings,
			'template_path' => '/tpl/jobservertemplate',
		);
		
		include_once PATH_TPL_DIR . '/jobservertemplate/index.tpl';

	} catch( Exception $Ex ) {
		
		CommonFunctions::showErrorPage( $Ex->getMessage() );
		
	}
