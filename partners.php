<?php 

	require_once("./inc/functions.php"); 
	
?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Partners Page -->
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
					<br><br><p class="center">Does your agency have a<br>project United Way<br>could assist with?</p><p class="center"><a href="http://opportunity.unitedwayathenslimestone.com/welcome.html" target="_blank">Register here</a></p>                      			
                <br><br></div></div>  <!-- close css division "sidQuote" --> 			
<!-- Main Content Starts Below-->	
				<div id="content"> <!-- css division "content" -->
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
</html>