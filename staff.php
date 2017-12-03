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
				<h2>Kay McFarlen</h2> <!-- Header 2 style -->
				<!-- paragraph -->
				<p>
				<!-- Staff member's role -->
				Executive Director</br>
				<!-- Email address with link to open a new outgoing email -->
				E-mail: <a href="mailto:unitedway44@unitedwayalc.com?" title="unitedway44@unitedwayalc.com">unitedway44@unitedwayalc.com</a><br>
				<!-- Phone number with link to call from a smartphone  -->
				Phone: <a href="tel:2562332323, 11">256-233-2323 ext: 11</a><br/>
				<hr class="barClass"> <!-- horizontal bar -->

				<h2>Diane Craig</h2> <!-- Header 2 style -->
				<!-- paragraph -->
				<p>
				<!-- Staff member's role -->
				Executive Administrative Assistant</br>
				<!-- Email address with link to open a new outgoing email -->
				E-mail: <a href="mailto:diannecraig@unitedwayalc.com?" title="diannecraig@unitedwayalc.com">diannecraig@unitedwayalc.com</a><br>
				<!-- Phone number with link to call from a smartphone  -->
				Phone: <a href="tel:2562332323, 10">256-233-2323 ext: 10</a><br/>
				<hr class="barClass"> <!-- horizontal bar -->

				<h2>Shelley Jones</h2> <!-- Header 2 style -->
				<!-- paragraph -->
				<p>
				<!-- Staff member's role -->
				Volunteer Administrative Manager</br>
				<!-- Email address with link to open a new outgoing email -->
				E-mail: <a href="mailto:shelleyjones@unitedwayalc.com?" title="shelleyjones@unitedwayalc.com">shelleyjones@unitedwayalc.com</a><br>
				<!-- Phone number with link to call from a smartphone  -->
				Phone: <a href="tel:2562332323, 15">256-233-2323 ext: 15</a><br/>
				<hr class="barClass"> <!-- horizontal bar -->

				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" -->
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
		<script src="js/bootstrap.js"></script>
</html>
