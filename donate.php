<?php

	require_once("./inc/functions.php");

?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Donate Page -->
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
				<div class="content"> <!-- css division "content" -->
					<h1>Make A Donation</h1> <!-- Header 1 style -->
					<!-- paragraph -->
					<p>LIVE UNITED. It's a credo. A mission. A goal. A constant reminder that when we reach
					  out a hand to one, we influence the condition of all. We build the strength of our
					  neighborhoods. We bolster the health of our communities. And we change the lives of
					  those who walk by us every day.</p>
					<!-- paragraph -->
					<p>If you would like to make a donation to benefit the United Way of Athens and Limestone County,
					please select the 'Donate' button to make a secure donation through PayPal. </p>
					<!-- PayPal generated code for a "Donate" button - links to a PayPal donate page -->
					<form action="https://www.paypal.com/cgi-bin/webscr" target="_blank" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="5P7FCDNCSBR4W">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1" style="border: none;">
					</form>
					<br>
					<hr>
					<h1>Donate Items</h1>
					<p>If you have any items you would like to donate we can help with that. A disaster can leave people without the basic materials they need, however YOU CAN HELP!! Below is a link that will take you to our donations form, where you can select what type of items
					you wish to donate. <br> <br>
					Fill out the donations form here:<br><a class="button" href="forms/welcome3.php" target="_blank">Donation Form </a></p>
					<hr> <!-- horizontal bar -->

					<h1>Thank you!</h1> <!-- Header 1 style -->
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" -->
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
		<script src="js/bootstrap.js"></script>
</html>
