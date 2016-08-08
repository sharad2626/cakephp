<?php

phpinfo();

exit;
	$dbhost    = 'localhost';
	$db_name   = 'cakephpdb';
	$userword  = 'cakephpdbusr';
	$password  = 'cakephpdbusr';

	
	$conn      = mysql_connect($dbhost, $userword,$password );
	
	if(!$conn)
	{
		die('Could not connect: ' . mysql_error());
	
	}else{
		echo 'Connected successfully';
	}


	$db_selected = mysql_select_db($db_name,$conn);
	
	if(!$db_selected){
	die ('Can\'t use foo : ' . mysql_error());

	}

	mysql_close($conn);



?>