<?php

	require_once 'scripts/authorize.php';
	require_once 'scripts/database_connection.php';
	require_once 'scripts/view.php';
	require_once 'scripts/functions.php';

	// Start session to enable user authorization and control.
	session_start();

	// set time-out period (in seconds)
	$inactive = 600;

	// check to see if $_SESSION["timeout"] is set
	if (isset($_SESSION["timeout"]))
	{
		// calculate the session's "time to live"
		$sessionTTL = time() - $_SESSION["timeout"];
		if ($sessionTTL > $inactive)
		{
			session_destroy();
			$msg = "Your session has timed out due to inactivity. Please log in again to continue.";
			header("Location: login.php?error_message=" . $msg);
			exit();
		}
	}

	$_SESSION["timeout"] = time();

	// Authorize users to access page. Function is found in authorize.php.
	// Current user groups are Administrators, Volunteers, and Agencies
	// authorize_user(); will allow anyone that is logged in to access the page
	authorize_user(array("Administrators"));


	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "searchAll",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

         admin_menu();
?>

<div id="admin_form_container">
  <div class="form_description" align="center">
    <h2>Admin - Mass Email to Volunteers</h2>
    <p></p>
  </div>
	<div class="adminDefaults">
  
<?php

function printStuff($array) {
	$emailString = "";
	foreach( $array as $stuff ) {
	    if( is_array( $stuff ) ) {
	        foreach( $stuff as $thing ) {
	            if ($thing != '')
								$emailString .= $thing . ", ";
	        }
					//removes last comma and space
					$emailString = substr($emailString, 0, -1);
					$emailString = substr($emailString, 0, -1);
					echo $emailString;
	    } else {
	        echo "Error....";
	    }
	}
}

require_once 'scripts/app_config.php';

$conn = mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD)
	or handle_error("an error occurred while attempting to connect to the database", mysql_error());

mysql_select_db(DATABASE_NAME)
	or handle_error("Error selecting the database ", mysql_error());

	//--------------------------------------

?>

<p>Results:</p> <br>
<input type="text" value="<?php printStuff($_POST); ?>" class="resizedTextbox"/>
<br><br>

<?php

$query = "SELECT * FROM volunteers ORDER BY last_name ASC";
$result = mysql_query($query);

echo "<div class='scroll'>";
echo "<form action='' method='post'>";
echo "<table border='1' class='tb'>";
echo "<tr><td></td><td>First Name</td><td>Last Name</td><td>Email Address</td><td>Home Phone</td><td>Cell Phone</td><tr>";
while ($row = mysql_fetch_assoc($result)) {
	echo "<tr class='tb'><td><input type='checkbox' name='selected[]' value='{$row['email_address']}' style='width:17px;height:17px'/></td><td>{$row['first_name']}</td><td>{$row['last_name']}</td><td>{$row['email_address']}</td><td>{$row['home_phone']}</td><td>{$row['cell_phone']}</td><tr>";
}
echo "</table>";
echo "</div>"; //end scroll class
echo "<br>";
echo "<input id='btnAdmin' type='submit'/>";
echo "</form>";

mysql_free_result($result);

 ?>
 </div>
</div>
<div class="footer">
  Designed by Athens State University
</div>
</body>
</html>
