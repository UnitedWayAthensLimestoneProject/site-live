<?php

	require_once("./inc/functions.php");

?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Partners Page -->
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
				<h1>Programs funded by the United Way of Athens-Limestone Country.</h1> <!-- Header 1 style -->
					<button type="button" onclick="window.open('http://www.redcrossrelief.org/')"> 	<img class = "half" src="images/rc_icon.png" alt="RedCross"/><br/></button> <!-- button with link and picture -->
					<button type="button" onclick="window.open('http://casalimestonecounty.org/services.html')"><img class = "half" src="images/casa_icon.png" alt="CASA"/><br/></button> <!-- button with link and picture -->
					<br/>
					<button type="button" onclick="window.open('http://www.learn-to-read.org/')"> 	<img class = "half" src="images/l2r_icon.png" alt="READ"/><br/></button> <!-- button with link and picture -->
					<button type="button" onclick="window.open('http://www.csna.org/')"><img class = "half" src="images/crisis_icon.png" alt="CrisisServices"/><br/></button> <!-- button with link and picture -->
					<br/>
					<button type="button" onclick="window.open('http://www.aces.edu/main/submenus/resourceareas/4-H-youth.tmpl')"> <img class = "half" src="images/4h_icon.png" alt="4h"/><br/></button> <!-- button with link and picture -->
					<button type="button" onclick="window.open('http://www.mhcnca.org/')">			<img class = "half" src="images/mhc_icon.png" alt="MentalHealth"/><br/></button> <!-- button with link and picture -->
					<br/>
					<button type="button" onclick="window.open('http://girlscoutsnca.org/')">		<img class = "half" src="images/gs_icon.png" alt="Girl Scouts"/><br/></button> <!-- button with link and picture -->
					<button type="button" onclick="window.open('http://www.al-rsvp.com/')">			<img class = "half" src="images/rsvp_icon.png" alt="RSVP"/><br/></button> <!-- button with link and picture -->
					<br/>
					<button type="button" onclick="window.open('http://bgcnal.com/')">				<img class = "half" src="images/bgc_icon.png" alt="Boys and Girls Club"/><br/></button> <!-- button with link and picture -->
					<button type="button" onclick="window.open('http://www.habitatalc.org')">		<img class = "half" src="images/habitat_icon.png" alt="Habitat for Humanity"/><br/></button> <!-- button with link and picture -->
					<br/>
					<button type="button" onclick="window.open('http://salvationarmyusa.org/')">	<img class = "half" src="images/sa_icon.png" alt="Salvation Army"/><br/></button>	<!-- button with link and picture -->
					<button type="button" onclick="window.open('http://www.scouting.org/')">		<img class = "half" src="images/bsa_icon.png" alt="BSA"/><br/></button> <!-- button with link and picture -->
					<br/>
					<button type="button" onclick="window.open('http://www.athenslimestonehospice.org/')"> <img class = "half" src="images/hospice_icon.png" alt="Hospice"/><br/></button> <!-- button with link and picture -->
					<button type="button" onclick="window.open('http://www.uso.org/')">				<img class = "half" src="images/uso_icon.png" alt="USO"/><br/></button> <!-- button with link and picture -->

					<button type="button" onclick="window.open('https://www.frcmo.org/')">				<img class = "half" src="images/frc_icon.png" alt="Family Resource Center"/><br/></button> <!-- button with link and picture -->
					<hr> <!-- horizontal bar -->
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" -->
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
	<script src="js/bootstrap.js"></script>
</html>
