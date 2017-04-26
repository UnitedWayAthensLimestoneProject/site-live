<?php

function load_headers() {

	echo('
		<title>United Way of Athens-Limestone County</title> <!-- Website Title -->
		<link rel="shortcut icon" href="../images/uw_icon.ico" type="image/ico" /> <!-- Website Icon -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="inc/js/w2ui-1.4.2/w2ui-1.4.2.min.css" />
		<link rel="stylesheet" href="inc/css/menu.css">
		<script src="inc/js/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="inc/js/w2ui-1.4.2/w2ui-1.4.2.js"></script>
		<script src="inc/js/menu.js"></script>
	');
	
}


function main_menu() {

	echo('
	<br><br><br><br><br>
	<nav id="menu">

		<ul>

			<li><center><a href="index.php"><img src="inc/images/home.png" border=0 width="40"><br>Home</a></center></li>

			<li><center><a href="volunteer.php"><img src="inc/images/volunteer.gif" border=0 width="40"><br>Volunteer</a></center></li>

			<li><center><a href="donate.php"><img src="inc/images/give.gif" border=0 width="40"><br>Donate</a></center></li>
						
			<li><center><a href="javascript:show_full_menu();"><img src="inc/images/menu.png" border=0 width="40"><br>More</a></center></li>

		</ul>

	</nav>

	<nav id="full_menu">

		<ul>

			<li><center><a href="index.php"><img src="inc/images/home.png" border=0 width="40"><br>Home</a></center></li>

			<li><center><a href="about.php"><img src="inc/images/about.png" border=0 width="40"><br>About</a></center></li>

			<li><center><a href="contact.php"><img src="inc/images/contact2.png" border=0 width="40"><br>Contact</a></center></li>
			
			<li><center><a href="events.php"><img src="inc/images/events2.png" border=0 width="40"><br>Events</a></center></li>

			<li><center><a href="volunteer.php"><img src="inc/images/volunteer.gif" border=0 width="40"><br>Volunteer</a></center></li>
			
			<li><center><a href="disaster.php"><img src="inc/images/weather-icon.png" border=0 width="40"><br>Disasters</a></center></li>

			<li><center><a href="donate.php"><img src="inc/images/give.gif" border=0 width="40"><br>Donate</a></center></li>

			<li><center><a href="https://www.youtube.com/user/unitedwayalc"><img src="inc/images/youtube.gif" border=0 width="40"><br>Youtube</a></center></li>
			
			<li><center><a href="https://www.facebook.com/pages/United-Way-Athens-Limestone/131401963542374"><img src="inc/images/facebook.jpg" border=0 width="40"><br>Facebook</a></center></li>

			<li><center><a href="javascript:hide_full_menu();"><img src="inc/images/menu.png" border=0 width="40"><br>Less</a></center></li>

		</ul>

	</nav>
	');

}



?>