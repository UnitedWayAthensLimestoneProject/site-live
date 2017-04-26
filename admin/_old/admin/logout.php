<?php

	// start session, for user authorization.
	session_start();
		
	// delete SESSION variables
	unset($_SESSION['user_id']);
	unset($_SESSION['username']);
	
	session_destroy();

	// redirect to the login page
	header('Location: login.php');
	exit();
	
?>
