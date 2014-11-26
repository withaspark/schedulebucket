<?php
/*********************************************
   This function opens the associated database for this account
*/
include("../../connect_2db.php");
$group = $_GET['gid'];


/***********************************************
/ Reorder tasks
***********************************************/
if (isset($_GET['to_order'])) {
	$ctr = 0;
	$rows = explode(",",$_GET['to_order']);
	$status = explode("_",$_GET['to']);
		$cid = $status[1];
		$status = $status[2] + 1;

	while (isset($rows[$ctr])) {
		$rows[$ctr] = intval($rows[$ctr]);
			$tid = $rows[$ctr];
		$ctr_plus = $ctr + 1;
		$query = "UPDATE tasks SET cid=".$cid.",task_order=".$ctr_plus.",status=".$status." WHERE gid=$group AND tid=$tid";
		mysql_query($query);
		$ctr++;
	}
}


/***********************************************
/ Reorder rows
***********************************************/
elseif (isset($_GET['row_order'])) {
	$ctr = 0;
	$rows = explode(",",$_GET['row_order']);

	while (isset($rows[$ctr])) {
		$rows[$ctr] = intval($rows[$ctr]);
			$cat_order = $rows[$ctr];
		$ctr_plus = $ctr + 1;
		$query = "UPDATE categories SET cat_order=".$ctr_plus." WHERE gid=$group AND cid=$cat_order";
		mysql_query($query);
		$ctr++;
	}
}





/***********************************************
/ Change account settings
***********************************************/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Schedule Bucket | Processing</title>
</head>
<body>



<pre>process.php

<?php
echo "\nQuery: ";
echo $query;

echo "\nRequest: ";
print_r($_GET);
print_r($_POST);
?></pre>


</body>
</html>
