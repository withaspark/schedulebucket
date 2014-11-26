<?php
include("../connect_2db.php");

$folder = filter_var(preg_replace("/\W-/",".",$_GET['folder']), FILTER_SANITIZE_SPECIAL_CHARS);
$check = mysql_fetch_array(mysql_query("SELECT nameshort FROM units WHERE nameshort='$folder' LIMIT 1",$dbh));

if ($check['nameshort'] != "")
	echo "found";
else
	echo "good";
?>
