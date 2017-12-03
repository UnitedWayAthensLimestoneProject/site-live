<?php	
	// Set up debug mode
	define("DEBUG_MODE", true);

	// Site root
	define("SITE_ROOT", "/var/chroot/home/content/70/9561270/html");
	
	// Database connection constants
	define("DATABASE_HOST", "localhost");
	define("DATABASE_USERNAME", "uwalc2");
	define("DATABASE_PASSWORD", "UW@cs452");
	define("DATABASE_NAME", "uwalc2");
	
	define("EMAIL_SENDER_NAME","United Way");
	define("EMAIL_SENDER_ADDRESS","no-reply@unitedwayathenslimestone.com");

	// Error reporting
	if (DEBUG_MODE) {
		error_reporting(E_ERROR);
	} else {
		// Turn off all error reporting
		error_reporting(0);
	}

	function debug_print($message) {
		if (DEBUG_MODE) {
			echo $message;
		}
	}

	function handle_error($user_error_message, $system_error_message) {
		session_start();
		$_SESSION['error_message'] = $user_error_message;
		$_SESSION['system_error_message'] = $system_error_message;		
		header("Location: " .get_web_path(SITE_ROOT). "/admin/scripts/show_error.php");			
		exit();
	}
	
	function get_web_path($file_system_path) {		
		$main_part = str_replace('/var/chroot/home/content/70/9561270/html', '', $file_system_path);
		$full = "{$main_part}";				
		return $full;
	}
?>
