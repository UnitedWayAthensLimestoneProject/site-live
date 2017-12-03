<?php

	require_once 'scripts/database_connection.php';		// provides database connection
	require_once 'scripts/view.php';					// provides page header and menu

	// request error message, null if not.
	$error_message = $_REQUEST['error_message'];

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
			header("Location: login.php");
		}
	}

	$_SESSION["timeout"] = time();

	// If the user is logged in, the user_id in the session will be set
	if (!isset($_SESSION['user_id'])) {

		// See if a login form was submitted with a username for login
		if (isset($_POST['username'])) {
			// Try and log the user in
			$username = mysql_real_escape_string(trim($_REQUEST['username']));
			$password = mysql_real_escape_string(trim($_REQUEST['password']));

			// Look up the user
			$query = sprintf("SELECT user_id, username FROM users " .
							 " WHERE username = '%s' AND " .
							 "       password = '%s' AND " .
							 "		 active = 1;",
							 //$username, $password);
							 $username, crypt($password, $username));	// change back for live deployment

			$results = mysql_query($query);

			// if user is found, assign user_id and username to SESSION variables and
			// then send to appropriate page.
			if (mysql_num_rows($results) == 1) {
				$result = mysql_fetch_array($results);
				$user_id = $result['user_id'];
				$_SESSION['user_id'] = $user_id;
				$_SESSION['username'] = $username;
				session_regenerate_id();

				if (user_in_group($user_id, "Administrators")) {
					// if user is from an Agency, send to Agency Oppurtunity page.
					header("Location: admin.php");
				} elseif (user_in_group($user_id, "Agencies")) {
					// if user is from an Agency, send to Agency Oppurtunity page.
					header("Location: agency_opp.php");
				} else {
					// if user is an Administrator or Volunteer, send to Register Volunteer page.
					header("Location: register_volunteer.php");
				}
				exit();
			} else {
				// If user not found, issue an error
				$error_message = "Your username/password combination was invalid.";
			}
		}

		// Add any page specific javascript here.
		// Set focus in the username textbox.
		$javascript = <<<EOD
		$(document).ready(function() {
			$(':text:first').focus();
		});
EOD;

		// Still in the "not signed in" part of the if statement.
		// Start the page, and pass along any error message set earlier
		// Creates the Banner and Menus/Tabs based on the type of user logged in. Function is
		// 		located in view.php
		// Format is 'page_start("<page_title>", <embedded_javascript_from_above>, "<selected_tab>",
		//		<success_message>, <error_message>);
		// The selected_tab must be setup in the uw.css file around line 165.
		// If there's no embedded javascript, change $javascript to NULL, below.
		page_start("United Way of Athens/Limestone County EMD Login Page", $javascript, NULL,
				   NULL, $error_message);
?>

		<div id="form_container">

			<form id="form_login" class="appnitro" method="post"
				action="<?php echo $_SERVER['PHP_SELF']; ?>" >
				<center>
				<div class="form_description">
					<h2>United Way of Athens/Limestone County EMD</h2>
					<p>&nbsp;</p>
				</div>
				</center>
				<fieldset style="width:260px">
					<legend>Please login to access this site:</legend>
					<br>
					<label for="username">Username:</label>
					<input id="username" name="username" type="text" class="center_text" size="20" value="" />
					<br><br>
					<label for="password">Password:</label>
					<input id="password" name="password" type="password" class="center_text" size="20" />
					<br>
					<br>
					<center>
					<input type="submit" id="btnAdmin" value="Log In" />
					</center>
				</fieldset>
			</form>
		</div>
		<div class="footer">
			Designed by Athens State University
		</div>
	</div>
</body>
</html>

<?php
	} else {
		// Now handle the case where they're logged in
		// redirect to another page
		if (user_in_group($_SESSION['user_id'], "Agencies")) {
			// if user is from an Agency, send to Agency Oppurtunity page.
			header("Location: agency_opp.php");
		} else {
			// if user is an Administrator or Volunteer, send to Register Volunteer page.
			header("Location: register_volunteer.php");
		}
	}
?>
