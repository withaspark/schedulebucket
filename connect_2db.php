<?php
	$dbh = mysql_connect ("localhost", "sb-webuser", "db-password") or
   	die ('Cannot connect to database. Please try again later.');
	mysql_select_db ("schedulebucket", $dbh);
?>
