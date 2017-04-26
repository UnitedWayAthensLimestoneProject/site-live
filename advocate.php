<?php 

	require_once("./inc/functions.php"); 
	
?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Advocate Page -->
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
<!--Sidebar Code-->	
			<br> 
			<div id="wrapper2"> <!-- css division "wrapper2" -->
				<div id = "sideQuote"><br><br> <!-- css division "sidQuote" --> 
                    <div class="cycle-slideshow" data-cycle-fx="fadeout" data-cycle-timeout="10000" data-cycle-slides="li" data-cycle-random="true" data-cycle-loop="100" data-index=1> <!-- using Cylce2, slideshow of photos -->
					   <ul>
							<li><img src="images/sidebar1.jpg" alt='sidebar1' height='130' width='200' /></li>
							<li><img src="images/sidebar2.jpg" alt='sidebar2' height='130' width='200' /></li>
							<li><img src="images/sidebar3.jpg" alt='sidebar3' height='130' width='200' /></li>
							<li><img src="images/sidebar4.jpg" alt='sidebar4' height='130' width='200' /></li>
							<li><img src="images/sidebar5.jpg" alt='sidebar5' height='130' width='200' /></li>
							<li><img src="images/sidebar6.jpg" alt='sidebar6' height='130' width='200' /></li>
							<li><img src="images/sidebar7.jpg" alt='sidebar7' height='130' width='200' /></li>
							<li><img src="images/sidebar8.jpg" alt='sidebar8' height='130' width='200' /></li>
					   </ul> 
					</div>
					<div class="spacer heightThirteen"></div> <!-- css division "heightThirteen" for sidebar spacing-->
					<div class="sideQuote center spacer"> <!-- css division "heightThirteen" for sidebar divider -->
					<div class="cycle-slideshow" data-cycle-fx="fadeout" data-cycle-timeout="10000" data-cycle-slides="li" data-cycle-loop="100" data-index=2> <!-- using Cylce2, slideshow of quotes -->
						<ul>
							<li><p class="left">“We make a living by what we get,<br>&nbsp;we make a life by what we give.”</p><p>–Winston Churchill</p></li>
							<li><p class="left">“You really can change the world if you care enough.”</p><p>–Marion Wright Edelman</p></li>
							<li><p class="left">“Never doubt that a small group<br>&nbsp;of thoughtful, committed citizens<br>&nbsp;can change the world.
					   			<br>&nbsp;Indeed it is the only<br>&nbsp;thing that ever has.”<br></p><p>–Margaret Mead</p></li>
					   		<li><p class="left">“The best way to find yourself<br>&nbsp;is to lose yourself in the service<br>&nbsp;of others.”</p><p>–Ghandi</p></li>
					   		<li><p class="left">“No act of kindness,<br>&nbsp;no matter how small,<br>&nbsp;is ever wasted.”</p><p>–Aesop</p></li>
					   		<li><p class="left">“Nobody can do everything,<br>&nbsp;but everyone can do<br>&nbsp;something.”</p><p>–Author unknown</p></li>
					   		<li><p class="left">“Service to others is the rent<br>&nbsp;you pay for your room<br>&nbsp;here on earth.”</p><p>–Mohammed Ali</p></li>
					   		<li><p class="left">“The best and most beautiful<br>&nbsp;things in the world<br>&nbsp;cannot be seen<br>&nbsp;or even touched<br>&nbsp;- they must be felt<br>&nbsp;with the heart.”</p><p>–Helen Keller</p></li>
						</ul>	  
					</div><br><br>                       			
                </div></div>  <!-- close css division "sidQuote" --> 	
<!-- Main Content Starts Below-->				
				<div id="content"> <!-- css division "content" -->
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
</html>