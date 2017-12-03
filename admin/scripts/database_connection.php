<?php	
	require_once 'app_config.php';
	
	$conn = mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD)
		or handle_error("an error occurred while attempting to connect to the database", mysql_error());		
		
	mysql_select_db(DATABASE_NAME)
		or handle_error("Error selecting the database ", mysql_error());	
?>
