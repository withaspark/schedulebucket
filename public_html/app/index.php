<?php
/*********************************************
	This function opens the associated database for this account
*/
include("../../connect_2db.php");

$group_name = filter_var($_GET['group'], FILTER_SANITIZE_SPECIAL_CHARS);
$group_info = @mysql_fetch_array(mysql_query("SELECT gid,name FROM units WHERE nameshort='$group_name' LIMIT 1"));
	$group = $group_info['gid'];
	$group_name = $group_info['name'];



/***********************************************
/ Add new task
***********************************************/
if (isset($_POST['new_task_name']) && $_POST['new_task_name'] != "" && isset($_POST['caller'])) {
	$cid = intval($_POST['caller']);
	$name = filter_var($_POST['new_task_name'], FILTER_SANITIZE_SPECIAL_CHARS);
	$color = filter_var($_POST['color'], FILTER_SANITIZE_SPECIAL_CHARS);

	$tid = mysql_fetch_array(mysql_query("SELECT tid FROM tasks ORDER BY tid DESC LIMIT 1"));
		$tid = $tid['tid'] + 1;
		$tid_carry = $tid;
	$order = mysql_fetch_array(mysql_query("SELECT task_order FROM tasks WHERE gid=$group AND cid=$cid ORDER BY task_order DESC LIMIT 1"));
		$order = intval($order['task_order']) + 1;
	$status = 1;

	if ($color == "color1")
		$color = "";

	// If want to add to top of list
	if (false) {
		$order = 1;
		// Increment all existing tasks so can make first
		$query = "UPDATE tasks SET task_order=task_order+1 WHERE gid=$group AND cid=$cid";
		mysql_query($query);
	}

	// Add new task as first in list
	$query = "INSERT INTO tasks (tid,gid,status,cid,task_order,description,color) VALUES ($tid,$group,$status,$cid,$order,'$name','$color')";
	mysql_query($query);
}
/***********************************************
/ Add new category
***********************************************/
// If user entered new category to be added
elseif (isset($_POST['new_cat']) && $_POST['new_cat'] != "") {
	$cid = mysql_fetch_array(mysql_query("SELECT cid FROM categories ORDER BY cid DESC LIMIT 1"));
		$cid = $cid['cid'] + 1;
		$cid_carry = $cid;
	$order = mysql_fetch_array(mysql_query("SELECT cat_order FROM categories WHERE gid=$group ORDER BY cat_order DESC LIMIT 1"));
		$order = $order['cat_order'] + 1;
	$name = filter_var($_POST['new_cat'], FILTER_SANITIZE_SPECIAL_CHARS);
	$status = 1;
	$query = "INSERT into categories (cid,gid,name,cat_order,status) VALUES ($cid,$group,'$name',$order,$status)";
	mysql_query($query);
}
/***********************************************
/ Rename category or delete category
***********************************************/
elseif (isset($_POST['edit_cat_name'])) {
	$cid = intval(substr($_POST['caller'],0,6));
		$cid_carry = $cid;
	$new_name = filter_var($_POST['edit_cat_name'], FILTER_SANITIZE_SPECIAL_CHARS);

	// If deleting category
	if (strpos($new_name,"DELETE") > 0 && strpos($new_name,"cid=") > 0) {
		$query = "DELETE FROM categories WHERE cid=".$cid;
		mysql_query("DELETE FROM tasks WHERE cid=".$cid);
	}
	// If renaming category
	else
		$query = "UPDATE categories SET name='".$new_name."' WHERE cid=".$cid." LIMIT 1";
	
	mysql_query($query);
}
/***********************************************
/ Renaming or deleting tasks
***********************************************/
elseif (isset($_POST['edit_task_name'])) {
	$tid = intval(substr($_POST['caller'],0,6));
		$tid_carry = $tid;
	$new_color = filter_var($_POST['color'], FILTER_SANITIZE_SPECIAL_CHARS);
	$new_name = filter_var($_POST['edit_task_name'], FILTER_SANITIZE_SPECIAL_CHARS);

	$query = "";
	// If deleting task
	if (strpos($new_name,"DELETE") > 0 && strpos($new_name,"tid=") > 0) {
		$query = "DELETE FROM tasks WHERE tid=".$tid;
	}
	// If renaming task
	else {
		if ($new_color == "color1")
			$new_color = "";
		$query = "UPDATE tasks SET description='$new_name',color='$new_color' WHERE tid=".$tid." LIMIT 1";
	}	
	mysql_query($query);
}





/***********************************************
/ Get categories and tasks for table
***********************************************/
$categories = mysql_query("SELECT cid,status,name FROM categories WHERE gid=$group ORDER BY cat_order");
$tasks = mysql_query("SELECT tid,tasks.cid,tasks.status,task_order,description,color FROM tasks INNER JOIN categories ON categories.cid=tasks.cid WHERE tasks.gid=$group ORDER BY categories.cat_order,tasks.status,task_order");

$num_of_cols = 3;		// to do, in progress, done
$num_of_colors = 21;		// Number of colors for tasks

$num_of_cats = 0;
for ($ctr = 0; $cat_arr[$ctr] = mysql_fetch_array($categories); $ctr++) {
	$num_of_cats++;
}
$num_of_tasks = 0;
for ($ctr = 0; $tasks_arr[$ctr] = mysql_fetch_array($tasks); $ctr++) {
	$num_of_tasks++;
}








if ($group_name != "") {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $group_name; ?> | Schedule Bucket Basic | Modern Project Management</title>

	<meta name="robots" content="noindex, nofollow">
	<link rel="stylesheet" href="../app.css.php" type="text/css" />
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/black-tie/jquery-ui.css" type="text/css" />

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/jquery-ui.min.js"></script>
	<script type="text/javascript" src="//tablednd.googlecode.com/svn/trunk/js/jquery.tablednd.js"></script>
	<link rel="icon" href="../../misc/favicon.ico" />
</head>
<body>
	<div id="top">
		<div class="pagewidth">
			<span class="float-left" style="font-size: 36px; width: 625px;"><?php echo $group_name; ?></span>
					<p class="clear"></p>
				</div>
	</div>
	<div id="main">
		<div class="pagewidth">
			<div id="response_box"><br /></div>

			<table id="calendar" class="sortrow">
				<tr class="nodrag nodrop"><th class="first_col"><h3 class="centered">Category</h3></th><th><h3 class="centered">To Do</h3></th><th><h3 class="centered">In Progress</h3></th><th><h3 class="centered">Complete</h3></th></tr>


<?php
				// When category == and status ==
				$row_ctr = 0;
				$task_ctr = 0;

				// Loop through rows
				while ($row_ctr < $num_of_cats) {
					$status_ctr = 0;
					$this_category = $cat_arr[$row_ctr];
?>
				<!-- Row: "<? echo $this_category['name']; ?>" -->
				<tr id="cat_<?php echo $this_category['cid']; ?>">
					<td class='first_col' name="<?php echo $this_category['name']; ?>"><?php echo $this_category['name']; ?>
						<div class='edit_cat'>&#10003; Edit category</div>
						<div class='add_task'>+ Add new task</div>
					</td>
<?php
					// Loop through status fields in category
					while ($status_ctr < $num_of_cols) {
?>
					<td>
						<ul class='sortable todo_col' id="cat_<?php echo $this_category['cid'].'_'.$status_ctr; ?>">
<?php
						if ($tasks_arr[$task_ctr]['cid'] == $this_category['cid']) {
							// Loop through tasks in status and category
							while ($tasks_arr[$task_ctr]['status'] == ($status_ctr + 1)  && $tasks_arr[$task_ctr]['cid'] == $this_category['cid']) {
								$this_tid = $tasks_arr[$task_ctr]['tid'];
								$this_color = $tasks_arr[$task_ctr]['color'];
								$this_description = $tasks_arr[$task_ctr]['description'];
									$this_description = str_replace("&#13;&#10;","\n",$this_description);
								$this_description_title = str_replace("\n"," ",$this_description);
								$this_short = substr($this_description,0,60);
									$this_short = str_replace("\n"," ",$this_short);
									if(strlen($this_short) > 50)
										$this_short = $this_short."...";
?>
							<li id="task_<?php echo $this_tid; ?>" class="task <?php echo $this_color; ?>" name="<?php echo $this_description; ?>" title="<?php echo $this_description_title; ?>"><?php echo $this_short; ?>
							</li>
<?php
								$task_ctr++;
							}
						}
?>
						</ul>
					</td>
<?php
						$status_ctr++;
					}
?>
					</tr>
<?php
					$row_ctr++;
				}
?>

				<!-- Row: "Add New Category" -->
				<tr id="cat_new" class="nodrag nodrop"><td id="cat_new_add" class="first_col" colspan="5">+ Add New Category <?php if ($num_of_cats == 0) echo "&nbsp;&nbsp;&nbsp;&larr; Start Here!"; ?></td></tr>
			</table>

			<div id="edit_cat" title="Edit category" style="display: none;">
				<form action="" method="post" id="edit_cat_form">
					<input type="text" name="edit_cat_name" id="edit_cat_input" class="text" maxlength="30" style="width: 98%;" />
					<input type="hidden" name="caller" id="edit_cat_caller" />
				</form>
			</div>



			<div id="add_new_task" title="Add new task" style="display: none;">
				<div class="float-right" id="add_task_counter" style="font-size: 16px; font-weight: bold; margin-bottom: 8px;"></div>
				<form action="" method="post" id="add_new_task_form">
					<textarea name="new_task_name" id="new_task_input" class="text" style="height: 10em; width: 98%;"></textarea>
					<input type="hidden" name="caller" id="new_task_caller" />
					<br />
					<?php
					for ($color_ctr = 1; $color_ctr <= $num_of_colors; $color_ctr++) {
						echo "<span class='swatch color".$color_ctr."' name='color".$color_ctr."'> </span>";
					}
					?>
					<input type="hidden" name="color" id="new_task_color" />
				</form>
			</div>
			<div id="edit_task" title="Edit task" style="display: none;">
				<div class="float-right" id="edit_task_counter" style="font-size: 16px; font-weight: bold; margin-bottom: 8px;"></div>
				<form action="" method="post" id="edit_task_form">
					<textarea name="edit_task_name" id="edit_task_input" class="text" style="height: 10em; width: 98%;"></textarea>
					<input type="hidden" name="caller" id="edit_task_caller" />
					<br />
					<?php
					for ($color_ctr = 1; $color_ctr <= $num_of_colors; $color_ctr++) {
						echo "<span class='swatch color".$color_ctr."' id='color".$color_ctr."'> </span>";
					}
					?>
					<input type="hidden" name="color" id="edit_task_color" />
				</form>
			</div>



			<div id="confirm_delete" title="Confirm delete category" style="display: none;">
				Are you sure you wish to delete this category and all tasks assigned to it?
			</div>
			<div id="confirm_task_delete" title="Confirm delete task" style="display: none;">
				Are you sure you wish to delete this task?
			</div>



			<div id="settings" title="Settings" style="display: none;">
				<h3>Account Settings</h3>

				<h4>This setting</h4>
				<p>Some options.</p>

				<h4>That setting</h4>
				<p>Some more options.</p>

				<form action="" method="post" id="settings_form">
				</form>
			</div>



			<input type="hidden" style="width: 80%;" id="script_feedback_task" />
			<input type="hidden" style="width: 80%;" id="script_feedback_from" />
			<input type="hidden" style="width: 80%;" id="script_feedback_to" />
			<input type="hidden" style="width: 80%;" id="script_feedback_order" />

			<!--
			<div id="ajax" style="margin-top: 2em;">
				<pre><?php /*echo "_GET: "; print_r($_GET); echo "_POST: "; print_r($_POST);*/ ?></pre>
			</div>
			-->

			<script type="text/javascript" src="../app.js.php?gid=<?php echo $group; ?>&cid=<?php echo $cid_carry; ?>&tid=<?php echo $tid_carry; ?>"></script>
		</div>
	</div>

	<script type="text/javascript"><!--
	$(document).ready(function(){
<?php
	// If no tasks, highlight add new category
	if ($num_of_cats == 0)
		echo "	$('#cat_new_add').addClass('shaderow'); $('#cat_new_add').effect('pulsate');";
//		echo "		highlight('#cat_new_add');";
?>

	function clear_box(element,text) {
		var el = document.getElementById(element);
		if (el.value == text)
			el.value = "";
		else if (el.value != "") {
			el.focus();
			el.select();
		}
	}
	function refill_box(element,text) {
		var el = document.getElementById(element);
		if (el.value == "")
			el.value = text;
	}


	});
	// --></script>


<?php

	require("../bottom.php");

}
// Page to show if can't find group
else {
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Schedule Bucket Basic | Page Not Found</title>
	<meta name="robots" content="noindex, nofollow">
	<link rel="stylesheet" href="app.css.php" type="text/css" />
	<link rel="stylesheet" href="../app.css.php" type="text/css" />
	<link rel="icon" href="../../misc/favicon.ico" />

	<style type="text/css">
	#billboard {
		width: 500px;
		margin: 125px auto 0px auto;
		border: #ddd solid 10px;
		overflow: hidden !important;
		background-color: #fff;
		padding: 25px 35px;
	}
	#billboard div.centered { padding: 50px 0px; }
	</style>
</head>
<body>
	<div id="billboard">
		<img src="../../misc/logo.png" id="logo" class="float-left" title="Schedule Bucket Logo" alt="Schedule Bucket" />
		<div class="clear"> </div>
		<div class="centered">
		<h1>Page Not Found</h1>

		<p class="centered">The page you are looking for can't be found.
			<br />Please check the address you typed for any errors.
		</p>
		<p class="centered"><a href="../../">Click here</a> to return to Schedule Bucket.
		</p>
		</div>
	</div>

<?php include("analytics.php"); ?>

</body>
</html>
<?php
}
?>
