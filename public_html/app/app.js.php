<?php
$group = intval($_GET['gid']);
$cid = intval($_GET['cid']);
$tid = intval($_GET['tid']);

if ($_GET['tid'] != "")
	$scrollTo = "#task_".$tid;
elseif ($_GET['cid'] != "")
	$scrollTo = "#cat_".$cid;


$length_of_tasks = 200;					// Sets maxlength of tasks


// Hide if not requested by app
$base_url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'].'app/';
if (strpos($base_url)) {
	// Add headers for type detection
	header("Content-type: text/javascript");
	header("X-Content-Type-Options: nosniff");

?>
<!-- 
$(document).ready(function(){




/**************************************************
/ Tasks
/*************************************************/
// Makes tasks sortable
$(".sortable").sortable({
	connectWith:	['.sortable'],
	over: function () {
		$(this).parent().addClass("shaderow")
	},
	out: function () {
		$(this).parent().removeClass("shaderow")
	},
	activate : function (event,ui) {
		document.getElementById('script_feedback_task').value = "task="+ui.item.attr("id");
		document.getElementById('script_feedback_from').value = "from="+ui.item.parent().attr("id")
	},
	update : function (event,ui) {
		var call;
		var task = document.getElementById('script_feedback_task');
		var from = document.getElementById('script_feedback_from');
		var to = document.getElementById('script_feedback_to');
		var order = document.getElementById('script_feedback_order');
		var order_text;

		message_box("Task order saved!","green");
		to.value = "to=" + $(this).attr("id");
		order_text = "to_order=" + $(this).sortable('serialize');
		while (order_text.indexOf("&task[]=") >= 0)
			order_text = order_text.replace("&task[]=", ",");
		order_text = order_text.replace("task[]=", "");
		order.value = order_text;

		call = "gid=" + "<?php echo $group; ?>&" + task.value + "&" + from.value + "&" + to.value + "&" + order.value;
		submit_process(call);
	}
});

// Allows adding of new tasks on clicking add task
$('.add_task').click(function(event,ui) {
	var caller = $(this).parent().parent().attr("id")
	document.getElementById('new_task_input').value = "";
	document.getElementById('new_task_caller').value = caller.replace("cat_","");

	$(".swatch").css('border','');

	$('#add_new_task').dialog('open');
	char_count('new_task_input','<?=$length_of_tasks?>','add_task_counter');
});

$('#add_new_task').dialog({
	bgiframe: true,
	modal: true,
	autoOpen: false,
	width: 500,
	height: 500,
	buttons: {
		'Create Task': function() {
			if (char_count('new_task_input','<?=$length_of_tasks?>','add_task_counter')) {
				$('#add_new_task_form').submit();
				$(this).dialog('close');
			}
		},
		'Cancel': function() {
			$(this).dialog('close');
		}
	}
});

// Allows editing and deleting of tasks on clicking edit task
$('.task').dblclick(function(event,ui) {
	var caller = $(this).attr("id");
	var color = $(this).attr("class").replace("task","");

	document.getElementById('edit_task_caller').value = caller.replace("task_","");
	document.getElementById('edit_task_input').value = $(this).attr("name");
	color = color.substring(color.indexOf("color"),color.indexOf("color")+7);
	document.getElementById('edit_task_color').value = color;
	setTimeout("$('#edit_task_input').focus()",100);
	setTimeout("$('#edit_task_input').select()",100);
	$('#edit_task').dialog('open');
	$(".swatch").css('border','');
	$("#"+color).css('border','#999 solid 3px');
	char_count('edit_task_input','<?=$length_of_tasks?>','edit_task_counter');
});
$('#edit_task').dialog({
	bgiframe: true,
	modal: true,
	autoOpen: false,
	width: 500,
	height: 500,
	buttons: {
		'Save Task': function() {
			if (char_count('edit_task_input','<?=$length_of_tasks?>','edit_task_counter')) {
				$('#edit_task_form').submit();
				$(this).dialog('close');
			}
		},
		'Delete': function() {
			$('#confirm_task_delete').dialog('open');
		},
		'Cancel': function() {
			$(this).dialog('close');
		}
	}
});
	$('.swatch').click(function (event,ui) {
		$('.swatch').css('border','');
		// For edit task dialog
		document.getElementById('edit_task_color').value = $(this).attr('id');
		// For add new task dialog
		document.getElementById('new_task_color').value = $(this).attr('name');
		$(this).css('border','#999 solid 3px');
	});
$('#confirm_task_delete').dialog({
	bgiframe: true,
	modal: true,
	autoOpen: false,
	width: 400,
	height: 150,
	buttons: {
		'Delete': function() {
			var edit_task_input = document.getElementById('edit_task_input');
			var edit_task_caller = document.getElementById('edit_task_caller');

			if ($('#confirm_task_delete').dialog('open')) {
				// Auto close under dialog for editing task
				$('#edit_task').dialog('close');
				$('#edit_task_input').hide();
				edit_task_input.value = "[DELETE tid=" + edit_task_caller.value + "]";
				$('#edit_task_form').submit();
			}
			$(this).dialog('close');
		},
		'Cancel': function() {
			$(this).dialog('close');
		}
	}
});





/**************************************************
/ Categories
/*************************************************/
// Makes categories (rows) sortable
$(".sortrow").tableDnD({
	onDragClass: "shaderow",
	onDrop: function(table,row) {
		var row_order = $.tableDnD.serialize();
		var call;

		row_order = strip_unwanted_calendar(row_order);
		message_box("Category order saved!","green");
		call = "gid=" + "<?php echo $group; ?>&" + "row_order=" + row_order;
		submit_process(call);
	}
});

// Allows adding of new categories
$('#cat_new_add').click(function() {
	var call;

	if ($('#cat_new_add').html().indexOf("+") >= 0) {
		$('#cat_new').fadeTo(500,0.1);
		$('#cat_new').addClass('shaderow');
		setTimeout("$('#cat_new_add').html(\"<form action='' method='post'><input type='text' name='new_cat' id='new_cat_input' class='text' maxlength='30' value='New category...' /> &nbsp; &nbsp; &nbsp; <input type='submit' value='Create Category' class='button' style='display: inline;' /></form>\");",500);
//		setTimeout("change_cat_row();",500);
		$('#cat_new').fadeTo(1000,1);
	}

	setTimeout("$('#new_cat_input').focus()",500);
	setTimeout("$('#new_cat_input').select()",500);
});
	// Changes #cat_new_box text
	//function change_cat_row() {
	//	$('#cat_new_add').html("<form action='' method='post'><input type='text' name='new_cat' id='new_cat_input' class='text' maxlength='20' value='New category...' /> <input type='submit' value='Create' /></form>");
	//}

// Allows editing and deleting of categories on clicking edit category
$('.edit_cat').click(function(event,ui) {
	var caller = $(this).parent().parent().attr("id")
	document.getElementById('edit_cat').innerHTML = document.getElementById('edit_cat').innerHTML;
	document.getElementById('edit_cat_caller').value = caller.replace("cat_","");
	document.getElementById('edit_cat_input').value = $(this).parent().attr("name");
		setTimeout("$('#edit_cat_input').focus()",100);
		setTimeout("$('#edit_cat_input').select()",100);
	$('#edit_cat').dialog('open');
});
$('#edit_cat').dialog({
	bgiframe: true,
	modal: true,
	autoOpen: false,
	width: 400,
	height: 100,
	buttons: {
		'Save': function() {
			$('#edit_cat_form').submit();
			$(this).dialog('close');
		},
		'Delete': function() {
			var edit_cat_input = document.getElementById('edit_cat_input');
			var edit_cat_caller = document.getElementById('edit_cat_caller');

			$('#confirm_delete').dialog('open');
		},
		'Cancel': function() {
			$(this).dialog('close');
		}
	}
});
$('#confirm_delete').dialog({
	bgiframe: true,
	modal: true,
	autoOpen: false,
	width: 400,
	height: 150,
	buttons: {
		'Delete': function() {
			var edit_cat_input = document.getElementById('edit_cat_input');
			var edit_cat_caller = document.getElementById('edit_cat_caller');

			if ($('#confirm_delete').dialog('open')) {
				// Auto close under dialog for edit category
				$('#edit_cat').dialog('close');
				$('#edit_cat_input').hide();
				edit_cat_input.value = "[DELETE cid=" + edit_cat_caller.value + "]";
				$('#edit_cat_form').submit();
			}
			$(this).dialog('close');
		},
		'Cancel': function() {
			$(this).dialog('close');
		}
	}
});

													<?php
// Highlight category where name was changed
if (isset($cid)) { ?>
	$('#cat_<?=$cid?>').addClass('shaderow');
	$('#cat_<?=$cid?>').effect('pulsate');
	setTimeout("$('#cat_<?=$cid?>').removeClass('shaderow');",3000);
	<?php
}

// Highlight new tasks and edited tasks
if (isset($tid)) { ?>
	$('#task_<?=$tid?>').addClass('shaderow');
	$('#task_<?=$tid?>').effect('pulsate');
	setTimeout("$('#task_<?=$tid?>').removeClass('shaderow');",3000);
	<?php
}

// Scroll to elements of concern
if (isset($scrollTo)) { ?>
	var scroll_offset = $('<?=$scrollTo?>').offset().top - 100;
	$('html').animate({'scrollTop': scroll_offset}, 2000);
	<?php
}	?>



// Strips string to prepare as url query
function strip_unwanted_calendar(inputstring) {
	var string = inputstring.replace("calendar[]=&", "");
	while (string.indexOf("&calendar[]=") >= 0)
		string = string.replace("&calendar[]=", ",");
	string = string.replace("calendar[]=", "");
	while (string.indexOf("cat_") >= 0)
		string = string.replace("cat_", "");
	string = string.replace(",new", "");
	return string;
}



/**************************************************
/ Settings
/*************************************************/
$('#settings_link').click(function(event,ui){
	$('#settings').dialog('open');
	return false;
});
$('#settings').dialog({
	bgiframe: true,
	modal: true,
	autoOpen: false,
	width: 500,
	height: 400,
	buttons: {
		'Save': function() {
			$('#settings_form').submit();
			$(this).dialog('close');
		},
		'Cancel': function() {
			$(this).dialog('close');
		}
	}
});



/**************************************************
/ AJAX
/*************************************************/
function submit_process(call) {
	var url = "../process.php?" + call;

	show_loading('start');
	if (window.XMLHttpRequest) { // Firefox
		request = new XMLHttpRequest();
	}
	if (window.ActiveXObject) { // IE
		request = new ActiveXObject("Microsoft.XMLHTTP");  // Internet Explorer 
	} 
	request.open("GET",url,true);
	request.send(call);
	request.onreadystatechange = function() {
  		if(request.readyState == 4) {
	  		//document.getElementById('ajax').innerHTML = request.responseText;
  		}
	};
	show_loading('end');
	return false;
}



/**************************************************
/ Feedback
/*************************************************/
// Controls feedback box
$('#response_box').css('opacity','.1');
function message_box(message,color) {
	if (color == "green")
		color = "#DAE8DC";
	else if (color == "red")
		color = "#F9C8C8";
	else if (color == "yellow")
		color = "#F8F9C8";
	else
		color = "#eee";

	message = '&#10003; ' + message;

	$('#response_box').css('background-color',color);
	$('#response_box').html(message).fadeTo(500,1, function() {
		setTimeout("$('#response_box').fadeTo(700,.1);",700);
		setTimeout("$('#response_box').html(' &nbsp; ');",1000);
		setTimeout("$('#response_box').css('background-color','');",1500);
	});
}

// Controls max length fields and shows length of current text
function char_count(field,maxlength,counter) {
	var field_id = document.getElementById(field);
	var counter_id = document.getElementById(counter);
	var return_status = false;

	if (field_id.value.length > maxlength) {
		counter_id.innerHTML = (field_id.value.length - maxlength) + " too many characters";
		$('#' + field).addClass('shaderow');
	}
	else {
		$('#' + field).removeClass('shaderow');
		counter_id.innerHTML = (maxlength - field_id.value.length);
		return_status = true;
	}

	return return_status;
}
	// For edit task field
	$('#edit_task_input').keyup(function(event) {
		char_count('edit_task_input','<?=$length_of_tasks?>','edit_task_counter');
	});
	$('#new_task_input').keyup(function(event) {
		char_count('new_task_input','<?=$length_of_tasks?>','add_task_counter');
	});

/**************************************************
/ Miscellaneous
/*************************************************/
// Cursor styles
$('#cat_new_add').hover(function() {
	$('#cat_new_add').css("cursor","pointer");
});
$('.first_col').hover(function() {
	$('.first_col').css("cursor","move");
});
$('.task').hover(function() {
	$('.task').css("cursor","move");
});
function show_loading(action) {
	if (action == "start")	$('*').css("cursor","progress");
	else 							setTimeout("$('*').css('cursor','');",300);
}





});
 // -->
<?php
}
else {
?>



<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Schedule Bucket Basic Javascript</title>
	<meta name="robots" content="noindex, nofollow">
	<link rel="stylesheet" href="app.css.php" type="text/css" />
	<link rel="icon" href="../misc/favicon.png" />

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
		<img src="../misc/logo.png" id="logo" class="float-left" title="Schedule Bucket Logo" alt="Schedule Bucket" />
		<div class="clear"> </div>
		<div class="centered">
		<h1>Schedule Bucket Basic Javascript</h1>

		<p class="centered">Copyright &copy;2009 <a href="http://withaspark.com/">Stephen Parker</a>. All rights reserved</p>
		<p class="centered">You are not authorized to view this script.</p>

		</div>
	</div>

<?php include("analytics.php"); ?>

</body>
</html>



<?php
}
?>
