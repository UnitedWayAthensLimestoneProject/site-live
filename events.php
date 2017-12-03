<?php 

	require_once("./inc/functions.php"); 
	
?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Events Page -->

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
				<div class="content">  <!-- css division "content" -->
								  <h1>Event Calendar</h1> <!-- Header 1 style -->
								  <!-- paragraph -->
								  <p>Check out our calendar for all of our currently scheduled events.
								  <br><br><a class="button" href="calendar.php" title="Event Calendar"><img src="images/dateTime_55.png" alt="Event Calendar" style="border: none;" class="center" /><br>Go to Calendar</a></p> <!-- picture / link to Event Calendar -->
								  <hr> <!-- horizontal bar -->
						          
						          <h1>Day of Caring</h1> <!-- Header 1 style -->
						          <!-- paragraph -->
						          <p>We support an annual day of volunteering in September. This day of community
						          activity allows businesses, agencies, industries, and individuals to leave their
						          normal work day to work on community service projects.
						          <br><br><img src="images/DayOfCaring.gif" alt="Day of Caring" width="200" height="100" class="center"/></p> <!-- picture -->
						          <hr> <!-- horizontal bar -->
						          
						          <h1>Stuff the Bus</h1> <!-- Header 1 style -->
						          <!-- paragraph -->
						          <p>We are collecting new and gently used books for K-12 children. We will give the
						          books to local schools to use for incentives or as tools or library books. Donate
						          books at our office or one of several area locations!
						          <br><br><img src="images/bus.jpg" alt="Stuff the Bus" width="200" height="100" class="center"/></p> <!-- picture -->
						          <hr> <!-- horizontal bar -->
						          
						          <h1>Retired Educator Recognition</h1> <!-- Header 1 style -->
						          <!-- paragraph -->
						          <p>Nominate a favorite teacher from your childhood to be recognized at our Day of 
						          Caring Celebration on September 12. Click the link below, fill out the form, and email it to us.<br>
						          <br><a href="Retired_Educator_Recognition_Form.docx" title="Retired_Educator_Recognition_Form"><img src="images/doc_65.png" alt="Retired_Educator_Recognition_Form" style="border: none;" class="img" /></a> <!-- link to Retired Educator form -->
						          <a href="mailto:unitedway44@unitedwayalc.com?subject=Retired%20Educator%20Form" title="unitedway44@unitedwayalc.com"><img src="images/mail_55.png" alt="unitedway44@unitedwayalc.com" style="border: none;" class="img" /></a></p> <!-- link to open a new outgoing email -->
						          <hr> <!-- horizontal bar -->
						          
						          <h1>Toys for Tots</h1> <!-- Header 1 style -->
						          <!-- paragraph -->
						          <p>We join with the United States Marine Corps in helping our community provide
						          toys for children whose families may not be able to provide Christmas presents 
						          for them.
						          <br><br><img src="images/tft_promo_icon.gif" alt="Toys for Tots" width="200" height="100" class="center"/></p> <!-- picture -->
						          <hr> <!-- horizontal bar -->
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" --> 
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content --> 			
		</body>
</html>