	<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	$GLOBALS['config']=array(
		'appName' 		=> 'TheDummy',
		'appDomain' 	=>'thedummy.com',
		'path' 			=> array(
								'app'	=>'app/',
								'core'	=>'core/',
								'index'	=>'index.php'
							),
		'defaults'		=> array(
								'controller'=>'main',
								'method'	=>'index'
							),
		'routes'		=>array(),
		'database'		=>array(
								'hostname'	=>'localhost',
								'username'	=>'root',
								'password'	=>'',
								'database'	=>''
							)
		);
	require_once $GLOBALS['config']['path']['core'].'autoload.php';

	new router();
?>