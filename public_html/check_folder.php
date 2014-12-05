<?php
include("../connect_2db.php");

$folder = filter_var(preg_replace("/\W-/",".",$_GET['folder']), FILTER_SANITIZE_SPECIAL_CHARS);
$statement = $dbhPDO->prepare("SELECT nameshort FROM units WHERE nameshort=? LIMIT 1");
$statement->execute(array($folder));
$check = $statement->fetch();

if ($check['nameshort'] != "")
	echo "found";
else
	echo "good";
?>
