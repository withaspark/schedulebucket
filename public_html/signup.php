<?php
$page = "signup";
$title = "Signup | ";



$created_group = 0;
$test_answer = 4;
// Create new group
if (isset($_POST['group']) && isset($_POST['address']) && isset($_POST['email']) && isset($_POST['test'])) {
if (
		$_POST['group'] != "" &&
			$_POST['group'] != "e.g., Haskell Law Group..." &&
		$_POST['address'] != "" &&
			$_POST['address'] != "e.g., haskellgroup..." &&
		$_POST['email'] != "" &&
			$_POST['email'] != "Your email..." &&
		$_POST['test'] != "" &&
			$_POST['test'] != "2 + 2 equals?..."
	) {

	$groupname = filter_var($_POST['group'], FILTER_SANITIZE_SPECIAL_CHARS);
		$groupname_search = array("&#39;",	"&#38;"	);
		$groupname_replace = array("'",		"&"		);
		$groupname = str_replace($groupname_search,$groupname_replace,$groupname);
	$address = filter_var(preg_replace("/\W-/",".",$_POST['address']), FILTER_SANITIZE_SPECIAL_CHARS);
	$link = 'https://'.$_SERVER['SERVER_NAME'].'/schedulebucket/app/'.$address;
	$email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
	$ipadd = filter_var($_SERVER['REMOTE_ADDR'],FILTER_SANITIZE_SPECIAL_CHARS);
	$test = intval($_POST['test']);

	if ($email && $test == $test_answer) {
		include("../connect_2db.php");

		$query = "INSERT INTO units (nameshort,name,created,email,ip) VALUES ('$address','$groupname',".time().",'$email','$ipadd')";
		mysql_query($query,$dbh);
		$groupid = mysql_insert_id($dbh);
		if ($groupid)
			$created_group = 1;
		else {
			// See if failed because address already taken
			$found = mysql_fetch_array(mysql_query("SELECT nameshort FROM units WHERE nameshort='$address' LIMIT 1",$dbh));
				$found = $found['nameshort'];
			if ($found == $address)
				$created_group = -2;
			else
				$created_group = -1;
		}
	}
	elseif ($test != $test_answer)
		$created_group = -3;
	else
		$created_group = -1;
}}



include("top.php");



// If creating group
if ($created_group == 1) {
	

?>

	<h1>Created Account</h1>
	<h3 class="centered">Your new account has been created!</h3>
	<br /><br />
	<p class="centered">You can find your Schedule Bucket at <a href="<?php echo $link; ?>"><?php echo $link; ?></a>.</p>

<?php
}

// If creating group failed
elseif ($created_group < 0) {
?>

	<h1>Created Account</h1>
	<h3 class="centered">Your new account could not be created!</h3>
	<br /><br />
	<?php
	if ($created_group == -2)
		echo "<p class='centered'>Your address is already taken. Please <a href='javascript:history.go(-1)'>try another</a>.</p>";
	elseif ($created_group == -3)
		echo "<p class='centered'>Your answer was incorrect. Please <a href='javascript:history.go(-1)'>try again</a>.</p>";
	else
		echo "<p class='centered'>Please try <a href='javascript:history.go(-1)'>signing up</a> again.</p>";

}

// Regular page
else {
?>

	<h1>Create Account</h1>
	<form action="signup.php" method="post">
		<table class="signup">
		<tr>
			<td class="field_label">Group Name:</td>
			<td class="field"><input type="text" name="group" id="group" value="e.g., Haskell Law Group..." class="text text-wide grey" maxlength="30" tabindex="1" /></td>
			<td id="group_feedback" class="field_feedback"> </td>
		</tr>

		<tr>
			<td class="field_label">Address:</td>
			<td class="field">
				<input type="text" name="address" id="address" value="e.g., haskellgroup..." class="text text-wide grey" maxlength="30" tabindex="3" />
				<br />&nbsp;&nbsp;<span id="group_link">https://<?php echo $_SERVER['SERVER_NAME']; ?>/schedulebucket/app/<span id="group_folder"> </span></span>
				<br /><div class="right"><a href="#" onclick="random_folder(); return false;">Make Random</a></div>
			</td>
			<td id="link_feedback" class="field_feedback"> </td>
		</tr>

		<tr>
			<td class="field_label">Email:</td>
			<td class="field"><input type="text" name="email" value="Your email..." class="text text-wide grey" maxlength="30" tabindex="4" /></td>
			<td id="email_feedback" class="field_feedback"> </td>
		</tr>

		<tr>
			<td class="field_label">Test:</td>
			<td class="field"><input type="text" name="test" id="test" value="2 + 2 equals?..." class="text text-wide grey" maxlength="5" tabindex="6" /></td>
			<td id="test_feedback" class="field_feedback"> </td>
		</tr>
		</table>

 		<p style="margin-top: 1.5em;"><input type="submit" id="submit_button" class="button centered" value="Create Account!" tabindex="7" /></p>
	</form>



	<script type="text/javascript"><!--
	$(document).ready(function(){
		// Control folder
		$('#address').keyup(function(event) {
			var add_field = document.getElementById('address');
			var group_folder = document.getElementById('group_folder');
			var folder = add_field.value;

			folder = folder.replace(/\W/g,'');
			check_folder(folder);

			if (add_field.value != "e.g., haskellgroup...") {
				add_field.value = folder.toLowerCase().substring(0,25);
				group_folder.innerHTML = folder.toLowerCase().substring(0,25);
				$('#group_folder').addClass('green').css('font-weight','bold');
			}
		});


		$('input, .select_input').focus(function(event,ui) {
			$(this).removeClass('grey');
			$(this).select();
		});

		$('#submit_button').click(function(event,ui) {
			var test_value = document.getElementById('test').value;
			if ($('#group_folder').hasClass('red') || test_value != "<?php echo $test_answer; ?>")		// Don't allow submit if bad form
				return false;
			else
				return true;
		});
	});



	function check_folder(folder) {
		var call = "folder=" + folder;
		var url = "check_folder.php?" + call;

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
	  			if (request.responseText == "found")
	  				$('#group_folder').addClass('red');
	  			else
	  				$('#group_folder').removeClass('red');
  			}
		};
	}



	function random_folder() {
		var add_field = document.getElementById('address');
		var group_folder = document.getElementById('group_folder');

		var possibles = "0123456789abcdef";
		var length = 15;
		var random_string = "";
		for (var i=0; i<length; i++) {
			var position = Math.floor(Math.random() * possibles.length);
			random_string += possibles.substring(position, position + 1);
		}

		add_field.value = random_string;
		$('#address').removeClass('grey');
		$('#group_folder').removeClass('red');
		group_folder.innerHTML = random_string;
		$('#group_folder').addClass('green').css('font-weight','bold');
	}
	// -->
	</script>

<?php
} // End regular page
?>


<?php
include("bottom.php");
?>
