<?php


function get_main_menu()
{
	$page = basename($_SERVER['PHP_SELF']);
	echo '<nav class="navbar navbar-default">
				  <div class="container-fluid">
				    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1" aria-expanded="false" style="float: left;"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
				     	</div>
				    <!-- Collect the nav links, forms, and other content for toggling -->
				    <div class="collapse navbar-collapse" id="defaultNavbar1">
				      <ul class="nav navbar-nav">
				        <li class='; if($page == "home.php"){echo '"active"';} echo'><a href="home.php">Home</a></li>
				        <li class="dropdown '; if($page == "mission.php" || $page == "vision.php" || $page == "staff.php" || $page == "directors.php" || $page == "contact.php"){echo 'active';} echo'"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About<span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li class='; if($page == "mission.php"){echo '"active"';} echo'><a href="mission.php">Our Mission</a></li>
				            <li class='; if($page == "vision.php"){echo '"active"';} echo'><a href="vision.php">Our Vision</a></li>
				            <li class='; if($page == "staff.php"){echo '"active"';} echo'><a href="staff.php">Staff</a></li>
				            <li class='; if($page == "directors.php"){echo '"active"';} echo'><a href="directors.php">Board of Directors</a></li>
				            <li class='; if($page == "contact.php"){echo '"active"';} echo'><a href="contact.php">Contact Us</a></li>
									</ul>
								</li>
			            <li class="dropdown '; if($page == "calendar.php" || $page == "dayofcaring.php" || $page == "stuffthebus.php" || $page == "retiredrec.php" || $page == "toysfortots.php"){echo 'active';} echo'"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Events<span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li class='; if($page == "calendar.php"){echo '"active"';} echo'><a href="calendar.php">Events Calendar</a></li>
				            <li class='; if($page == "dayofcaring.php"){echo '"active"';} echo'><a href="dayofcaring.php">Day of Caring</a></li>
				            <li class='; if($page == "stuffthebus.php"){echo '"active"';} echo'><a href="stuffthebus.php">Stuff the Bus</a></li>
				            <li class='; if($page == "retiredrec.php"){echo '"active"';} echo'><a href="retiredrec.php">Retired Educator Recognition</a></li>
				            <li class='; if($page == "toysfortots.php"){echo '"active"';} echo'><a href="toysfortots.php">Toys for Tots</a></li>
			              </ul>
			            </li>
			            <li class='; if($page == "partners.php"){echo '"active"';} echo'><a href="partners.php">Partners</a></li>
			            <li class="dropdown '; if($page == "media.php"){echo 'active';} echo'"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Media<span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li><a href="https://www.facebook.com/United-Way-Athens-Limestone-131401963542374/?ref=ts" target = "_blank">Facebook</a></li>
				            <li><a href="https://twitter.com/uwlimestone" target = "_blank">Twitter</a></li>
										<li><a href="https://www.instagram.com/unitedwayalc/" target = "_blank">Instagram</a></li>
										<li><a href="https://www.youtube.com/channel/UCXHE9e7AyeOJmiWXnV5zzSQ/featured" target = "_blank">YouTube</a></li>
							<li class='; if($page == "media.php"){echo '"active"';} echo'><a href="media.php">Videos</a></li>
			              </ul>
			            </li>
			            <li class="dropdown '; if($page == "students.php" || $page == "athens.php" || $page == "calhoun.php"){echo 'active';} echo'"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Students<span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li class='; if($page == "students.php"){echo '"active"';} echo'><a href="students.php">Student Home</a></li>
				            <li class='; if($page == "athens.php"){echo '"active"';} echo'><a href="athens.php">Athens State</a></li>
							<li class='; if($page == "calhoun.php"){echo '"active"';} echo'><a href="calhoun.php">Calhoun</a></li>
			              </ul>
			            </li>
			            <li class="dropdown '; if($page == "volunteer.php" || $page == "disaster_volunteer.php" || $page == "group.php" || $page == "front_desk.php"){echo 'active';} echo'"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Get Involved<span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li class='; if($page == "volunteer.php"){echo '"active"';} echo'><a href="volunteer.php">Community Volunteer Registration</a></li>
				            <li class='; if($page == "disaster_volunteer.php"){echo '"active"';} echo'><a href="disaster_volunteer.php">Disaster Volunteer Registration</a></li>
							<li class='; if($page == "group.php"){echo '"active"';} echo'><a href="group.php">Group Volunteer Registration</a></li>
		              		<li class='; if($page == "front_desk.php"){echo '"active"';} echo'><a href="front_desk.php">Volunteer Front Desk Program</a></li>
		              		<li><a style="background-color:#f57814" href="donate.php">DONATE</a></li>
			              </ul>
			            </li>
			             <li class="dropdown '; if($page == "disaster_relief.php" || $page == "disaster_volunteer.php" || $page == "damage_report.php"){echo 'active';} echo'"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Disaster Assistance<span class="caret"></span></a>
				          <ul class="dropdown-menu">
				            <li class='; if($page == "disaster_relief.php"){echo '"active"';} echo'><a href="disaster_relief.php">Disaster Relief Form</a></li>
				            <li class='; if($page == "disaster_volunteer.php"){echo '"active"';} echo'><a href="disaster_volunteer.php">Disaster Volunteer Registration</a></li>
							<li class='; if($page == "damage_report.php"){echo '"active"';} echo'><a href="damage_report.php">Damage Report Form</a></li>
		              		<li><a style="background-color:#f57814" href="donate.php">DONATE</a></li>
			              </ul>
			            </li>
										<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Search<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<form class="navbar-form" role="search" action="https://google.com/search" method="get" target="_blank">
										<div class="input-group">
										<input type="hidden" name="sitesearch" value="http://www.unitedwayathenslimestone.com/" />
										<input type="text" name="q" class="form-control" placeholder="Search..." />
											<span class="input-group-btn">
                        <button type="submit" name="sa" class="btn btn-default">
                            <span class="glyphicon glyphicon-search">
															<span class="sr-only">Search...</span>
														</span>
                        </button>
                    </span>
										</div>
									</ul>
									</li>
									</li>
			          </ul>
			        </div>
				    <!-- /.navbar-collapse -->
			      </div>
				  <!-- /.container-fluid -->

			  </nav>
';

return;

}

function get_home_banner()
{

echo '		<div id = "wrapper"> <!-- css division "wrapper" -->
			<div id = "banner">  <!-- css division "banner" -->
			<a href = "home.php"><img src="images/uwbanner2.jpg" alt="United Way of Athens-Limestone County"></a> <!-- Banner Picture is a link to the Home page -->
			</div> <!-- close css division "banner" -->
		</div>
';

return;
}

function get_home_footer()
{

echo '<!-- Footer with info and links -->
		 <div id="footer"> <!-- css division "footer" -->
		  	<p>
		      <a href="home.php">Home</a> <!-- link to Home page -->
		      <a href="mission.php">About</a> <!-- link to Mission page -->
		      <a href="calendar.php">Events</a> <!-- link to Events page -->
		      <a href="partners.php">Partners</a> <!-- link to Partners page -->
		      <a href="students.php">Students</a> <!-- link to Student page -->
		      <a href="media.php">Media</a> <!-- link to Media page -->
		      <a href="volunteer.php">Get Involved</a> <!-- link to Volunteer page -->
			  <a href="disaster_assistance.php">Disaster Assistance </a> <!-- link to disaster assistance page -->
		      <a href="donate.php">Donate</a> <!-- link to Donate page -->
					<!-- For testing purposes, changing address of admin page to local machine -->
			  <!-- <a href="http://www.unitedwayathenslimestone.com/admin/login.php">Admin</a> <!-- link to Admin page -->
				<a href="admin/login.php">Admin</a>
		    </p>
		    <!-- Street Address & link to Google Maps -->
			<p><a href="https://maps.google.com/maps?q=419+South+Marion+Street,+Athens,+AL&daddr=419+S+Marion+St,+Athens,+AL+35611&hl=en&safe=strict&hnear=419+S+Marion+St,+Athens,+Alabama+35611&t=m&geocode=%3BCRcHfh36VeuXFe3-EgIdy-zQ-im5UdqSaItiiDGYGqDdFVcFPA&z=14" target="_blank"> 419 South Marion Street	 |  Athens, AL 35611</a></p>
			<!-- Phone number & link to call if viewing with a smart phone -->
			<p><a href="tel:2562332323">256-233-2323</a></p>
			<p> <!-- Links and Icons -->
			<a href="donate.php"><img src="images/give.gif" alt="Give" width="50" style="border: none;" class="img" /></a> <!-- link to Donate page -->
			<a href="advocate.php"><img src="images/advocate.gif" alt="Advocate" width="50" style="border: none;" class="img" /></a> <!-- link to Advocate page -->
			<a href="volunteer.php"><img src="images/volunteer.gif" alt="Volunteer" width="50" style="border: none;" class="img" /></a> <!-- link to Volunteer page -->
			<a href="http://www.unitedway.org" target="_blank"><img src="images/uw_icon.png" alt="LIVE UNITED" width="50" style="border: none;" class="img" /></a> <!-- link to unitedway.org -->
			<a href="https://www.facebook.com/pages/United-Way-Athens-Limestone/131401963542374?ref=ts" target="_blank"><img src="images/facebook.jpg" alt="Facebook" width="50" style="border: none;" class="img" /></a> <!-- link to Facebook page -->
			<a href="https://twitter.com/UWlimestone" target="_blank"><img src="images/twitter.gif" alt="Twitter" width="50" style="border: none;" class="img" /></a> <!-- link to Twitter page -->
			<a href="https://www.youtube.com/channel/UCXHE9e7AyeOJmiWXnV5zzSQ/featured" target="_blank"><img src="images/youtube.gif" alt="YouTube" width="50" style="border: none;" class="img" /></a> <!-- link to YouTube page -->
			</p>
		  </div> <!-- close css division "footer" -->
';
return;
}

//looks for "sidebar1" image (can be any image file type)
//returns name of file if found, returns dne.jpg if not found
function sidebarPath($name)
{
	//define('ROOT_PATH', dirname(__DIR__) . '/');
	if (!defined('ROOT_PATH')) define('ROOT_PATH', dirname(__DIR__) . '/');
	$dir = ROOT_PATH.'sidebarImgs';
	$filesAry = scandir($dir);

	foreach ($filesAry as $file) {
		if(strpos($file, $name) !== false) {
			$fpath = '/sidebarImgs/' . $file;
			echo $fpath;
			return;
		}
	}

	echo "/sidebarImgs/dne.jpg";
}

?>
