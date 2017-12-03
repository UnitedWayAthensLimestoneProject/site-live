<?php

	require_once("./inc/functions.php");

?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Students Page -->
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
						<h1>Student United Way</h1> <!-- Header 1 style -->
				          <!-- paragraph -->
				          <p>Student United Way is a local student organization, each club is reflective of its local
				          United Way, campus, and community but it also is part of a national movement of young
				          people working and learning together and meets national standards accordingly.</p>
				          <img src="images/studentUW.jpg" alt="Student United Way" class="center"/> <!-- picture -->
				          <!-- paragraph -->
				          <p>Through Student United Way, students will learn new skills gain experience, and grow
				          as leaders as they work to advance the common good in your community and on campus.</p>
				          <!-- paragraph -->
				          <p>By representing both students and United Way, the students will have the opportunity
				          to help bridge the "town/gown" divide that separates many campuses and their communities.</p>
				          <!-- paragraph -->
				          <p>United Way is one of the largest non-profit organizations in the world, with 1250+
				          organizations in the United States and affiliates in 46 countries globally. United Way can
				          be a lifetime network and opportunity to get involved.</p>
				          <hr> <!-- horizontal bar -->

						  <h2>Follow the National Student United Way Movement</h2> <!-- Header 2 style -->
							<ul><p> <!-- unordered list -->
								<a href="http://unway.3cdn.net/4b147d35886d54eae4_09m6byr8n.pdf" target="_blank">Review the Student United Way Annual Report 2010-2011.</a><br> <!-- Student United Way hyperlink -->
								<a href="https://www.facebook.com/studentuw" target="_blank">Join Student United Way on Facebook.</a><br> <!-- Student United Way hyperlink -->
							</p></ul>
							<hr> <!-- horizontal bar -->
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" -->
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
		<script src="js/bootstrap.js"></script>
</html>
