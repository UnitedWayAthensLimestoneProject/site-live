<?php

	require_once("./inc/functions.php");

?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Mission Page -->
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
				<div class="content""> <!-- css division "content" -->
			          <h1>Our Mission</h1> <!-- Header 1 style -->
			          <!-- paragraph -->
			          <p>United Way of Athens-Limestone County secures resources to include financial support, volunteers and in kind donations of goods and services.
			          	We accomplish this by providing high quality community services through collaborations and partnerships aligned with our vision.</p>
			          	<hr> <!-- horizontal bar -->
			          <h1>Our Values</h1> <!-- Header 1 style -->
			          <ul> <!-- unordered list -->
					      <li><span>Trust and integrity through transparency</span></li>
					      <li><span>Respect and dignity</span></li>
					      <li><span>Innovative leadership</span></li>
					      <li><span>Accountability</span></li>
					      <li><span>Stewardship to our donors</span></li>
					      <li><span>Responsive to community</span></li>
				      </ul>
				      <hr> <!-- horizontal bar -->
				      <h1>Our Goals</h1> <!-- Header 1 style -->
				      <!-- paragraph -->
				      <p>In 2008, United Way initiated a 10-year program designed to achieve the following goals by 2018:</p>
						<ul> <!-- unordered list -->
					      <li><span>Improve education, and cut the number of high school dropouts &ndash; 1.2 million students, every year &ndash; in half.</span></li>
					      <li><span>Help people achieve financial stability, and get 1.9 million working families &ndash; half the number of lower-income
					      	families who are financially unstable &ndash; on the road to economic independence.</span></li>
					      <li><span>Promote healthy lives, and increase by one-third the number of youth and adults who are healthy and avoid risky behaviors.</span></li>
				       </ul>
					  <!-- paragraph -->
					  <p>Our goals are ambitious, but with your help, and by utilizing our core strengths &ndash; a national network,
					  committed partners, and public engagement capacity &ndash; we can achieve them.</p>
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" -->
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
		<script src="js/bootstrap.js"></script>
</html>
