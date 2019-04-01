<?php

	error_reporting( E_ALL );
	ini_set( 'display_errors', 'on' );
	
	define( 'PATH_SYSTEM_DIR', dirname( __FILE__ ) );
	define( 'PATH_ROOT_DIR', dirname( __FILE__ ) . '/..' );
	define( 'PATH_CLASSES_DIR', dirname( __FILE__ ) . '/../classes' );
	define( 'PATH_CONTROLLERS_DIR', dirname( __FILE__ ) . '/../controllers' );
	define( 'PATH_TPL_DIR', dirname( __FILE__ ) . '/../tpl' );
	
	include_once PATH_SYSTEM_DIR . '/config.php';
	include_once PATH_CLASSES_DIR . '/CommonFunctions.php';
	include_once PATH_SYSTEM_DIR . '/router.php';

	
