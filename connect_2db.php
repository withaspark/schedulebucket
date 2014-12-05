<?php
	$dbh = mysql_connect ('localhost', 'sb-webuser', 'db-password') or
	die('Cannot connect to database. Please try again later.');
	mysql_select_db('schedulebucket', $dbh);

	try {
		$dbhPDO = new PDO('mysql:host=localhost;dbname=schedulebucket', 'sb-webuser', 'db-password');
	}
	catch (PDOException $exception) {
		echo 'Error: ' . $exception->getMessage() . '<br/>';
		die('Cannot connect to database. Please try again later.');
	}
?>
