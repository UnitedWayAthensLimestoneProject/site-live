<?php	
	require_once 'app_config.php';
	require_once 'database_connection.php';	
	
	session_start();
	
	function authorize_user($groups = NULL) {
		
		// No need to check groups if there aren't cookies set
		if ((!isset($_SESSION['user_id'])) || (!strlen($_SESSION['user_id']) > 0)) {
			header('Location: login.php?error_message=You must login to access this site.');
			exit();
		}
		
		// If no groups passed in, the authorization above is enough
		if ((is_null($groups)) || (empty($groups))) {
			return;
		}
		
		// Set up the query string
		$query_string = "SELECT ug.user_id" .
						"  FROM user_groups ug, groups g" .
						" WHERE g.group_name = '%s'" .
						"   AND g.group_id = ug.group_id" .
						"   AND ug.user_id = " . mysql_real_escape_string($_SESSION['user_id']);
						
		// Run through each group and check membership
		foreach ($groups as $group) {
			$query = sprintf($query_string, mysql_real_escape_string($group));
			$result = mysql_query($query);
			
			if (mysql_num_rows($result) == 1) {
				// If we got a result, the user should be allowed access.
				// Just return so the script will continue to run
				return;
			}
		}
		
		// If we got here, no matches were found for any group.
		// The user isn't allowed access
		handle_error("You are not authorized to see this page.");
		exit();
	}
	
	function user_in_group($user_id, $group) {
		$query_string = "SELECT ug.user_id" .
						"  FROM user_groups ug, groups g" .
						" WHERE g.group_name = '%s'" .
						"   AND g.group_id = ug.group_id" .
						"   AND ug.user_id = %d";
						
		$query = sprintf($query_string, mysql_real_escape_string($group), 
                         mysql_real_escape_string($user_id));
		$result = mysql_query($query);

		if (mysql_num_rows($result) == 1) {
			return true;
		} else {
			return false;
		}
	}
			
?>