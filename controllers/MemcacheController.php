<?php

	try {

		$StartTime = microtime();

		$Data = array();

		$MemcacheHandler = new Memcache();
		$MemcacheHandler->addServer( 'rasp1.dev', 11211 );
		$MemcacheHandler->addServer( 'rasp2.dev', 11211 );
		
		$Codes = $MemcacheHandler->get( 'memcache_codes' );

		$CacheIsFound = true;
		
		$MasterHostData = array(
			'host' => 'rasp1.dev',
			'dbname' => 'vhost_replication',
			'user' => 'vhost',
			'pass' => '1235',
		);

		if ( ! $Codes ) {
			$CacheIsFound = false;

			$PDOOptions = array(
				PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES => false,
			);

			try {  
				$MasterPDO = new PDO("mysql:host=" . $MasterHostData[ 'host' ] . ";dbname=" . $MasterHostData[ 'dbname' ] . ";charset=UTF8", $MasterHostData[ 'user' ], $MasterHostData[ 'pass' ], $PDOOptions );
			}  
			catch( PDOException $Ex ) {
				CommonFunctions::showErrorPage( $Ex->getMessage() );
			}


			$CodesQuery = $MasterPDO->prepare( 'SELECT * FROM `vhost_codes`' );
			$CodesQuery->execute( array() );
			$Codes = $CodesQuery->fetchAll();

			$MemcacheHandler->set( 'memcache_codes', $Codes, MEMCACHE_COMPRESSED, 0 );
		}
		
		$Data = array( 
			'page_title' => 'Memcache',
			'server_name' => $_SERVER[ 'SERVER_NAME' ],
			'template_path' => '/tpl/memcachetemplate',
			'codes' => $Codes,
			'master_host' => $MasterHostData[ 'host' ],
			'exec_time' => microtime() - $StartTime,
			'cache_is_found' => $CacheIsFound ? 'Yes' : 'No',
		);
		
		include_once PATH_TPL_DIR . '/memcachetemplate/index.tpl';

	} catch( Exception $Ex ) {
		
		CommonFunctions::showErrorPage( $Ex->getMessage() );
		
	}
