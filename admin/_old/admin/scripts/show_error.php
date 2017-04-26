<?php

	require_once 'app_config.php';
	
	session_start();
	
	if (isset($_SESSION['error_message'])) {
		$error_message = preg_replace('/\\\\/', '', $_SESSION['error_message']);
	} else {
		$error_message = "something went wrong, and that's how you ended up here";
	}
	
	if (isset($_SESSION['system_error_message'])) {
		$system_error_message = preg_replace("/\\\\/", '', 
								$_SESSION['system_error_message']);
	} else {
		$system_error_message = "No system-level error message was reported.";
	}

?>

<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>United Way VMS</title>
	<link rel="stylesheet" type="text/css" href="../css/uw.css" media="all">
</head>

<body>
	<div id="wrapper">
		<div class="banner"><img src="../images/uww-logo_2013.png" /></div>
		<div id="menu" align="center">
			<ul id="mainNav" align="center">
			</ul>
		</div>
		
		<div id="form_container">
			<div class="form_description">
				<p>&nbsp;</p>
				<h2>We're really sorry...<br><br></h2>
				<p class="error_message">...but something's gone wrong. Apparently, <span 
				class="error_message"><?php echo $error_message; ?>.</span></p>
				<p>&nbsp;</p>
				<?php
					debug_print("<hr />");
					debug_print("<p><br>The following sytem-level message was received: 
						<b>($system_error_message)</b><br><br></p>");
				?>
			</div>
		</div>
		<div class="footer">Designed by Athens State University
		</div>
	</div>
</body>
</html>