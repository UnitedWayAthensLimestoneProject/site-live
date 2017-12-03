<?php

	require_once("inc/functions.php");

?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Home Page -->
<html lang="en"><head>
	<!-- header -->
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

	</head> <!-- close header -->
		<body>
		<?php get_home_banner() ?>
		<div id="darkframe"> <!-- css division "darkframe" - this is the blue border around the content -->		
		<?php get_main_menu(); ?>
<!--Sidebar Code-->
<?php include("sidebar.php");?>
<!-- Main Content -->

				<div class="content""> <!-- css division "content" -->
					<h1>United Way of Athens-Limestone County</h1> <!-- Header 1 style -->
					<!-- paragraph -->
			          <p>Welcome to the United Way Athens-Limestone County! United Way is a non-profit organization throughout
					     the country that operates on fundraising and support from volunteers. Here at United Way, we envision
						 a world where all individuals and families achieve their human potential through education, income
						 stability, and healthy lives.</p>
						 <img src="images/UW_Athens3b.jpg" alt="Athens United Way" class="center"/> <!-- picture -->
			          <hr> <!-- horizontal bar -->
			        <h1>Advancing the Common Good</h1> <!-- Header 1 style -->
			        <!-- paragraph -->
				      <p>Everyone deserves opportunities to have a good life: a quality education that leads to a stable job, enough income to support a family through retirement, and good health.</p>
				      <!-- paragraph -->
				      <p>That’s why United Way’s work is focused on the building blocks for a good life:</p>
						<ul> <!-- unordered list -->
					      <li><span><b>Education</b> – Helping Children and Youth Achieve Their Potential</span></li>
					      <li><span><b>Income</b> – Promoting Financial Stability and Independence</span></li>
					      <li><span><b>Health</b> – Improving People’s Health</span></li>
				       </ul>
				       <!-- paragraph -->
					  <p>Advancing the common good is less about helping one person at a time and more about changing systems to help all of us. We are all connected and interdependent. We all win when a child succeeds in school, when families are financially stable, when people are healthy.</p>
					  <!-- paragraph -->
					  <p>United Way’s goal is to create long-lasting changes by addressing the underlying causes of these problems. Living united means being a part of the change. It takes everyone in the community working together to create a brighter future.
					  	<br>Give. Advocate. Volunteer. LIVE UNITED.</p>
					  	<hr> <!-- horizontal bar -->
				</div> <!-- close css division "content" -->
		  </div>  <!-- close css division "wrapper2" -->
		<?php get_home_footer(); ?>
		<!-- Footer with info and links -->

		</body>
		<script src="js/bootstrap.js"></script>
</html>
