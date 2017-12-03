<?php 

	require_once("./inc/functions.php"); 
	
?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Advocate Page -->
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
			<br> 
			<div id="wrapper2"> <!-- css division "wrapper2" -->
				<div id = "sideQuote"><br><br> <!-- css division "sidQuote" --> 
                    <div class="cycle-slideshow" data-cycle-fx="fadeout" data-cycle-timeout="10000" data-cycle-slides="li" data-cycle-random="true" data-cycle-loop="100" data-index=1> <!-- using Cylce2, slideshow of photos -->
					   <ul>
							<li><img src="images/sidebar1.jpg" alt='sidebar1'/></li>
							<li><img src="images/sidebar2.jpg" alt='sidebar2'/></li>
							<li><img src="images/sidebar3.jpg" alt='sidebar3'/></li>
							<li><img src="images/sidebar4.jpg" alt='sidebar4'/></li>
							<li><img src="images/sidebar5.jpg" alt='sidebar5'/></li>
							<li><img src="images/sidebar6.jpg" alt='sidebar6'/></li>
							<li><img src="images/sidebar7.jpg" alt='sidebar7'/></li>
							<li><img src="images/sidebar8.jpg" alt='sidebar8'/></li>
					   </ul> 
					</div>
					<div class="spacer heightThirteen"></div> <!-- css division "heightThirteen" for sidebar spacing-->
					<div id="center spacer"> <!-- css division "heightThirteen" for sidebar divider -->
					<div class="cycle-slideshow" data-cycle-fx="fadeout" data-cycle-timeout="10000" data-cycle-slides="li" data-cycle-loop="100" data-index=2> <!-- using Cylce2, slideshow of quotes -->
						<ul>
							<li><p class="left">&ldquo;We make a living by what we get, we make a life by what we give.&rdquo;</p><p>&ndash;Winston Churchill</p></li>
							<li><p class="left">&ldquo;You really can change the world if you care enough.&rdquo;</p><p>&ndash;Marion Wright Edelman</p></li>
							<li><p class="left">&ldquo;Never doubt that a small group of thoughtful, committed citizens can change the world. Indeed it is the only thing that ever has.&rdquo;<br></p><p>&ndash;Margaret Mead</p></li>
					   		<li><p class="left">&ldquo;The best way to find yourself is to lose yourself in the service of others.&rdquo;</p><p>&ndash;Ghandi</p></li>
					   		<li><p class="left">&ldquo;No act of kindness, no matter how small, is ever wasted.&rdquo;</p><p>&ndash;Aesop</p></li>
					   		<li><p class="left">&ldquo;Nobody can do everything, but everyone can do something.&rdquo;</p><p>&ndash;Author unknown</p></li>
					   		<li><p class="left">&ldquo;Service to others is the rent you pay for your room here on earth.&rdquo;</p><p>&ndash;Mohammed Ali</p></li>
					   		<li><p class="left">&ldquo;The best and most beautiful things in the world cannot be see or even touched - they must be felt with the heart.&rdquo;</p><p>&ndash;Helen Keller</p></li>
						</ul>	  
					</div><br><br>                      			
              </div></div>  <!-- close css division "sidQuote" -->	
<!-- Main Content Starts Below-->				
				<div class="content"> <!-- css division "content" -->
					<h1>Advocate</h1> <!-- Header 1 style -->
					<!-- paragraph -->
					<p>You can make change happen with your voice:</p> 
					<ul> <!-- unordered list -->
						<li><span>Get informed.</span></li>
						<li><span>Find your voice.</span></li>
						<li><span>Tell your friends.</span></li>
					</ul>
				    <!-- paragraph -->
				    <p>Spread the word, further the mission and see the amazing process of change in action.</p>
					<!-- paragraph -->
					<p>United Way needs people who are passionate about education, income, health and want to raise awareness about the most critical needs in our community.<br>
				    We invite you to be part of the change. Together, united, we can inspire hope and create opportunities for a better tomorrow.</p>
					<hr> <!-- horizontal bar -->
					
					<h2>Ways You Can Advocate and LIVE UNITED:</h2> <!-- Header 2 style -->
					<ul style="font-size: 14px"> <!-- unordered list -->
						<span>Tell your friends about United Way of Athens-Limestone County and what we do.</span></br></br>
						<span>Get informed. Make it a point to learn about and discuss local issues with friends and family, then decide how you'll get involved.</span></br></br>
						<span>If you're passionate about education, income and health issues in our community, make some noise. Write a letter to the editor or comment on a local blog.</span></br></br>
						<span>Wear your LIVE UNITED T-Shirt.</span></br></br>
						<span>Send an e-mail or make a call to your elected officials about issues that you care about.</span></br></br>
						<span>Vote</span></br></br>
						<span>Friend us on <a href="https://www.facebook.com/pages/United-Way-Athens-Limestone/131401963542374?ref=ts" target="_blank">Facebook</a>.</span></br></br> <!-- Link to Facebook -->
						<span>Follow us on <a href="https://twitter.com/UWlimestone" target="_blank">Twitter</a>.</span></br></br> <!-- Link to Twitter -->
						<span>Connect. Join a neighborhood association or simply introduce yourself to a neighbor you haven't met.</span></br></br>
						<span>Get Involved. Sign up as a <a href="volunteer.php" target="_blank">volunteer</a>.</span></br></br> <!-- Link to Volunteer Page -->
					</ul>
					<hr> <!-- horizontal bar -->
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" --> 
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
		<script src="js/bootstrap.js"></script>
</html>