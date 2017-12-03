<?php
	require_once("./inc/functions.php");
?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Volunteer Page -->
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
				<h1>Volunteer Front Desk Program</h1> <!-- Header 1 style -->
				<!-- paragraph -->
				<p>RSVP members volunteer as receptionists for our front desk in the lobby of
				United Way. The program has enhanced the way United Way interacts with the
			  public as they enter the facility.</br></br> Please Contact Shelley Jones at:</br><a href="tel:2562332323">256-233-2323</a> </br> or </br> <a href="mailto:shelleyjones@unitedwayalc.com?" title="shelleyjones@unitedwayalc.com">shelleyjones@unitedwayalc</a><br></p>
			  <hr> <!-- horizontal bar -->

				<h2>United Way Gear Shop</h2> <!-- Header 2 style -->
				<!-- paragraph -->
				<p><a href="http://www.liveunitedgear.com/" target="_blank"><img src="images/gearshop.jpg" alt="Get Gear" width="150" height="75" style="border: none;"></a> <!-- picture with link to liveunitedgear.com -->
				</p>
				<hr> <!-- horizontal bar -->
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" -->
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
		<script src="js/bootstrap.js"></script>
</html>
