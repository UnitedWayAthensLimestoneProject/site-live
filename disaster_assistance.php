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
				<h1>Disaster Assistance</h1> <!-- Header 1 style -->
				
				
				<h2>If you have been affected by a disaster we are here to help!</h2> <!-- Header 2 style -->
				<!-- paragraph -->
			    <p> <img src="images/helping_hand1.png" alt="Disaster Assistance" class="center"></p>
				<p>Disasters can happen at any moment, in any form. Severe storms, flooding, tornadoes, fire and many other disasters can leave communities and families devastated. In the event of a disaster we are here to help. If you have been affected by a disaster and need assistance, please click the link below to fill out a disaster relief form. <br></p>
				
				
				<p>
				<br>Fill out the disaster relief form here to receive assistance:<br> <a class="button" href="forms/welcome1.php" target="_blank">Disaster Relief Form </a></p>	<!-- Link to the Volunteer registration form -->			
				<hr> 
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" --> 
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
		<script src="js/bootstrap.js"></script>
</html>