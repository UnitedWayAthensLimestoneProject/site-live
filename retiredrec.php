<?php

	require_once("./inc/functions.php");

?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Events Page -->

<html lang="en">
	<head> <!-- header -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>United Way of Athens-Limestone County</title>
	<!-- Website Title -->
	<meta charset = "utf-8" />
	<link rel="shortcut icon" href="file:///C|/wamp64/www/images/uw_icon.ico" type="image/ico" />
	<!-- Website Icon -->
	<script src="inc/js/jquery/jquery.min.js"></script>
	<!-- include jQuery -->
	<script src="inc/js/jquery/jquery.cycle2.min.js"></script>
	<!-- include Cycle2 http://jquery.malsup.com/cycle2/ -->
	<script src="inc/js/jquery/jquery.cycle2.ie-fade.min.js"></script>
	<link href="inc/css/bootstrap-3.3.7.css" rel="stylesheet" type="text/css">
	<link href="inc/css/style.css" type="text/css" rel="stylesheet">
	<!-- include the css style sheet style.css -->
	</head>
		<body>
		<?php get_home_banner(); ?>
		<div id="darkframe"> <!-- css division "darkframe" - this is the blue border around the content -->
		<?php get_main_menu(); ?>
<!--Sidebar Code-->
<?php include("sidebar.php");?>
<!-- Main Content Starts Below-->
				<div class="content">  <!-- css division "content" -->
								  <h1>Retired Educator Recognition</h1> <!-- Header 1 style -->
						          <!-- paragraph -->
						          <p>Nominate a favorite teacher from your childhood to be recognized at our Day of
						          Caring Celebration on September 12. Click the link below, fill out the form, and email it to us.<br>
						          <br><a href="Retired_Educator_Recognition_Form.docx" title="Retired_Educator_Recognition_Form"><img src="images/doc_65.png" alt="Retired_Educator_Recognition_Form" style="border: none;" class="img" /></a> <!-- link to Retired Educator form -->
						          <a href="mailto:unitedway44@unitedwayalc.com?subject=Retired%20Educator%20Form" title="unitedway44@unitedwayalc.com"><img src="images/mail_55.png" alt="unitedway44@unitedwayalc.com" style="border: none;" class="img" /></a></p> <!-- link to open a new outgoing email -->
						          <hr> <!-- horizontal bar -->
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" -->
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
		<script src="js/bootstrap.js"></script>
</html>
