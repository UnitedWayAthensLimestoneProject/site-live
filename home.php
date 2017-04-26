<?php 

	require_once("./inc/functions.php"); 
	
?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Home Page -->
<html lang="en">
	<head> <!-- header -->
		<title>United Way of Athens-Limestone County</title> <!-- Website Title -->
		<meta charset = "utf-8" />
		<link rel="shortcut icon" href="../images/uw_icon.ico" type="image/ico" /> <!-- Website Icon -->
		<link href="/inc/css/style.css" type="text/css" rel="stylesheet"> <!-- include the css style sheet style.css -->		
		<script src="/inc/js/jquery/jquery.min.js"></script>	<!-- include jQuery -->			
		<script src="/inc/js/jquery/jquery.cycle2.min.js"></script> <!-- include Cycle2 http://jquery.malsup.com/cycle2/ -->		
		<script src="/inc/js/jquery/jquery.cycle2.ie-fade.min.js"></script> <!-- include support for older versions of IE-->
	</head> <!-- close header -->
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
							<li><p class="left">&ldquo;We make a living by what we get,<br>&nbsp;we make a life by what we give.&rdquo;</p><p>&ndash;Winston Churchill</p></li>
							<li><p class="left">&ldquo;You really can change the world if you care enough.&rdquo;</p><p>&ndash;Marion Wright Edelman</p></li>
							<li><p class="left">&ldquo;Never doubt that a small group<br>&nbsp;of thoughtful, committed citizens<br>&nbsp;can change the world.
					   			<br>&nbsp;Indeed it is the only<br>&nbsp;thing that ever has.&rdquo;<br></p><p>&ndash;Margaret Mead</p></li>
					   		<li><p class="left">&ldquo;The best way to find yourself<br>&nbsp;is to lose yourself in the service<br>&nbsp;of others.&rdquo;</p><p>&ndash;Ghandi</p></li>
					   		<li><p class="left">&ldquo;No act of kindness,<br>&nbsp;no matter how small,<br>&nbsp;is ever wasted.&rdquo;</p><p>&ndash;Aesop</p></li>
					   		<li><p class="left">&ldquo;Nobody can do everything,<br>&nbsp;but everyone can do<br>&nbsp;something.&rdquo;</p><p>&ndash;Author unknown</p></li>
					   		<li><p class="left">&ldquo;Service to others is the rent<br>&nbsp;you pay for your room<br>&nbsp;here on earth.&rdquo;</p><p>&ndash;Mohammed Ali</p></li>
					   		<li><p class="left">&ldquo;The best and most beautiful<br>&nbsp;things in the world<br>&nbsp;cannot be seen<br>&nbsp;or even touched<br>&nbsp;- they must be felt<br>&nbsp;with the heart.&rdquo;</p><p>&ndash;Helen Keller</p></li>
						</ul>	  
					</div><br><br>                      			
                </div></div>  <!-- close css division "sidQuote" -->
<!-- Main Content -->		
			
				<div id="content"> <!-- css division "content" -->
					<h1>United Way of Athens-Limestone County</h1> <!-- Header 1 style -->
					<!-- paragraph -->
			          <p>Welcome to the United Way Athens-Limestone County! United Way is a non-profit organization throughout
					     the country that operates on fundraising and support from volunteers. Here at United Way, we envision
						 a world where all individuals and families achieve their human potential through education, income
						 stability, and healthy lives.</p>
						 <img src="images/UW_Athens3b.jpg" alt="Athens United Way" width="600" class="center"/> <!-- picture -->
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
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
</html>