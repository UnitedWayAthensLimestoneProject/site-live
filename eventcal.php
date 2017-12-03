<?php 

	require_once("./inc/functions.php"); 
	
?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Volunteer Event Calendar Page -->
<!-- Used for the registration of events by volunteers -->

<html lang="en">
	<head> <!-- header -->
		<title>United Way of Athens-Limestone County</title> <!-- Website Title -->
		<meta charset = "utf-8" />
		<link rel="shortcut icon" href="images/uw_icon.ico" type="image/ico" /> <!-- Website Icon -->
		<link href="/inc/css/style.css" type="text/css" rel="stylesheet"> <!-- include the css style sheet style.css -->		
		<script src="/inc/js/jquery/jquery.min.js"></script>	<!-- include jQuery -->			
		<script src="/inc/js/jquery/jquery.cycle2.min.js"></script> <!-- include Cycle2 http://jquery.malsup.com/cycle2/ -->		
		<script src="/inc/js/jquery/jquery.cycle2.ie-fade.min.js"></script> <!-- include support for older versions of IE-->
	</head>
		<body>
		<?php get_home_banner(); ?>
		<div id="darkframe"> <!-- css division "darkframe" - this is the blue border around the content -->		
		<?php get_main_menu(); ?>
<!-- Main Content Starts Below-->								
				<div class="content"> <!-- css division "content" -->
						<div id = "wrapper1">
						          <h1>Volunteer Event Calendar</h1> <!-- Header 1 style -->
						          <iframe src="https://www.google.com/calendar/embed?title=United%20Way%20Athens-Limestone%20County%20Events&amp;height=600&amp;wkst=1&amp;bgcolor=%23ff9900&amp;src=unitedwayalc%40gmail.com&amp;color=%2329527A&amp;ctz=America%2FChicago"
						           style="border:none" width="880" height="700"></iframe> <!-- Google generated code for the Google Calendar (Event Calendar) -->
				</div> <!-- close css division "wrapper1" -->
			</div>  <!-- close css division "content" --> 
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->  			
		</body>
</html>