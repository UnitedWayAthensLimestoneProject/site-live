<?php 

	require_once("./inc/functions.php"); 
	
?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - About Page -->
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
					<h1>Our Vision</h1> <!-- Header 1 style -->
			          <!-- paragraph -->
			          <p>United Way of Athens-Limestone County will be a leader in our community
			          where all individuals and families achieve their potential through education
			          which leads to financial stability, and healthier lifestyles.</p>	
			          <img src="images/UW_Athens2.jpg" alt="Athens United Way" class="center"/> <!-- picture -->
			          <hr> <!-- horizontal bar -->	          
			          
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
					      <li><span>Improve education, and cut the number of high school dropouts — 1.2 million students, every year — in half.</span></li>
					      <li><span>Help people achieve financial stability, and get 1.9 million working families — half the number of lower-income 
					      	families who are financially unstable — on the road to economic independence.</span></li>
					      <li><span>Promote healthy lives, and increase by one-third the number of youth and adults who are healthy and avoid risky behaviors.</span></li>
				       </ul>
					  <!-- paragraph -->
					  <p>Our goals are ambitious, but with your help, and by utilizing our core strengths — a national network, 
					  committed partners, and public engagement capacity — we can achieve them.</p>
					  <hr>	<!-- horizontal bar -->		 
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" --> 
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
		<script src="js/bootstrap.js"></script>
</html>