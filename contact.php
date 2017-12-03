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
	</head>
		<body>
		<?php get_home_banner(); ?>
		<div id="darkframe"> <!-- css division "darkframe" - this is the blue border around the content -->
		<?php get_main_menu(); ?>
<!--Sidebar Code-->
<?php include("sidebar.php");?>
<!-- Main Content Starts Below-->
				<div class="content"> <!-- css division "content" -->
				<h2>Contact Us</h2> <!-- Header 2 style -->
				<!-- paragraph -->
				<p>
				<!-- Address with link to Google Maps -->
				<a href="https://maps.google.com/maps?q=419+South+Marion+Street,+Athens,+AL&daddr=419+S+Marion+St,+Athens,+AL+35611&hl=en&safe=strict&hnear=419+S+Marion+St,+Athens,+Alabama+35611&t=m&geocode=%3BCRcHfh36VeuXFe3-EgIdy-zQ-im5UdqSaItiiDGYGqDdFVcFPA&z=14" target="_blank"> 419 South Marion Street<br>Athens, AL 35611<br></a>
				<!-- Email address with link to open a new outgoing email -->
				<a href="mailto:unitedway44@unitedwayalc.com?" title="unitedway44@unitedwayalc.com">unitedway44@unitedwayalc.com</a><br>
				<!-- Phone number with link to call from a smartphone  -->
				Phone: <a href="tel:2562332323">256-233-2323</a><br/>
				Fax: <a href="tel:2562332323">256-232-2373</a><br/><br/>
				<!-- Embedded Google Map showing the location of the United Way -->
				<iframe width="425" height="350" class="right" src="https://maps.google.com/maps?safe=strict&amp;q=419+South+Marion+Street,+Athens,+AL&amp;ie=UTF8&amp;hl=en&amp;hq=&amp;hnear=419+S+Marion+St,+Athens,+Alabama+35611&amp;ll=34.799341,-86.971189&amp;spn=0.011154,0.024698&amp;t=m&amp;z=14&amp;output=embed"></iframe><br></p>
				<hr> <!-- horizontal bar -->
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" -->
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
		<script src="js/bootstrap.js"></script>
</html>
