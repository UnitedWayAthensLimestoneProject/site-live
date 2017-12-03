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
				<h1>Get Involved</h1> <!-- Header 1 style -->
				<p><img src="images/united_kid.png" alt="Get Involved" class="center"></p> <!-- picture -->

				<h2>GIVE AN HOUR. GIVE A SATURDAY. GIVE YOUR BEST.</h2> <!-- Header 2 style -->
				<!-- paragraph -->
				<p>The United Way is working to advance the common good by focusing on education, income and health: the building blocks for a good life. But we can't do it alone. We need the heads, hands and hearts of committed people like you to help us.
				<br><br>Whether it is important to you to solve a community problem, advance a worthy cause or to develop as a person, volunteering offers many benefits in appreciation for the gift of your time and expertise.</p>
				<ul> <!-- unordered list -->
					<li><span>Make important networking contacts</span></li>
					<li><span>Learn or develop skills</span></li>
					<li><span>Teach your skills to others</span></li>
					<li><span>Enhance your résumé</span></li>
					<li><span>Gain work experience</span></li>
					<li><span>Build self-esteem and self-confidence</span></li>
					<li><span>Improve your health</span></li>
					<li><span>Meet new people</span></li>
					<li><span>Feel needed and valued</span></li>
					<li><span>Express gratitude for help you may have received in the past from an organization</span></li>
					<li><span>Communicate to others that you are ambitious, enthusiastic and care about the community</span></li>
					<li><span>Make a difference in someone’s life</span></li>
					<li><span>Improve the likelihood that children will volunteer as an adult</span></li>
				</ul>
				<!-- paragraph -->
				<p>Put your talents to work for your community. Volunteer!<br>
				<br>Sign up now to volunteer with the United Way of Athens-Limestone County:<br> <a class="button" href="forms/safety_brief.php" target="_blank">Disaster Volunteer Registration Form </a></p>	<!-- Link to the Volunteer registration form -->

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
