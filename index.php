<?php

	try {
		
		include_once dirname( __FILE__ ) . '/sys/init.php';
		
	} catch ( Exception $Ex ) {
		
		echo $Ex->getMessage();
		exit;

	}
