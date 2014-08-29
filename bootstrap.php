<?php
//check running via command line
( PHP_SAPI === 'cli' ) || die( 'This script can only be accessed via command line' );

//register autoloader
spl_autoload_register( function( $class ){
	$file = './models/' . $class . '.php';
	
	if ( !file_exists( $file ) ) return;
	
	include( $file );
} );

//define constants
define( 'REQUEST_TIME', $_SERVER['REQUEST_TIME'] );
?>