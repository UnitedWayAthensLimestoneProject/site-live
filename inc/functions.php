<?php


function get_main_menu()
{

	echo '<!--Navigation Bar Code-->
	<ul class="dropmenu">
	  <li class="dropdown">
		<a href="home.php">Home</a></li>
	  <li class="dropdown">
		<a href="#" class="dropbtn">About</a>
		<div class="dropdown-content">
		  <a href="mission.php">Our Mission</a>
		  <a href="vision.php">Our Vision</a>
		  <a href="staff.php">Staff</a>
		  <a href="directors.php">Board of Directors</a>
		  <a href="contact.php">Contact Us</a>
		</div>
	  </li>
	  <li class="dropdown">
		<a href="#" class="dropbtn">Events</a>
		<div class="dropdown-content">
		  <a href="calendar.php">Events Calendar</a>
		  <a href="dayofcaring.php">Day of Caring</a>
		  <a href="stuffthebus.php">Stuff the Bus</a>
		  <a href="retiredrec.php">Retired Educator Recognition</a>
		  <a href="toysfortots.php">Toys for Tots</a>
		</div>
	  </li>
	  <li class="dropdown">
		<a href="partners.php">Partners</a></li>
	  <li class="dropdown">
		<a href="#" class="dropbtn">Media</a>
		<div class="dropdown-content">
		  <a href="https://www.facebook.com/United-Way-Athens-Limestone-131401963542374/?ref=ts" target = "_blank">Facebook</a>
		  <a href="https://twitter.com/uwlimestone" target = "_blank">Twitter</a>
		  <a href="media.php">Videos</a>
		</div>
	  </li>
	  <li class="dropdown">
		<a href="#" class="dropbtn">Student United Way</a>
		<div class="dropdown-content">
		  <a href="students.php">Student Home</a>
		  <a href="athens.php">Athens State</a>
		  <a href="calhoun.php">Calhoun</a>
		</div>
	  </li>
	  <li class="dropdown">
		<a href="#" style="background-color:#f57814" class="dropbtn">Get Involved</a>
		<div class="dropdown-content">
		  <a href="volunteer.php">Community Volunteer Registration Form</a>
		  <a href="disaster_volunteer.php">Disaster Volunteer Registration Form</a>
		  <a href="group.php">Group Volunteer Registration Form</a>
		  <a href="front_desk.php">Volunteer Front Desk Program</a>
		  <a  style="background-color:#f57814" href="donate.php">DONATE</a>
		</div>
	  </li>
	  <li class="dropdown">
		<a href="#" class="dropbtn">Disaster Assistance</a>
		<div class="dropdown-content">
		  <a href="disaster_relief.php">Disaster Relief Form</a>
		  <a href="damage_report.php">Damage Report Form</a>
		  <a  style="background-color:#f57814" href="donate.php">DONATE</a>
		</div>
	  </li>
	</ul>
';

return;

}

function get_home_banner()
{

echo '		<div id = "wrapper"> <!-- css division "wrapper" -->
			<div id = "banner">  <!-- css division "banner" -->
			<a href = "home.php"><img src="images/uwbanner2.jpg" alt="United Way of Athens-Limestone County" style="border: none;" ></a> <!-- Banner Picture is a link to the Home page -->
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
		      <a href="students.php">Student United Way</a> <!-- link to Student page -->
		      <a href="media.php">Media</a> <!-- link to Media page -->
		      <a href="volunteer.php">Get Involved</a> <!-- link to Volunteer page -->
			  <a href="disaster_assistance.php">Disaster Assistance </a> <!-- link to disaster assistance page -->
		      <a href="donate.php">Donate</a> <!-- link to Donate page -->
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
			<a href="http://www.youtube.com/watch?v=y_hEa8_mSh8" target="_blank"><img src="images/youtube.gif" alt="YouTube" width="50" style="border: none;" class="img" /></a> <!-- link to YouTube page -->
			</p>
		  </div> <!-- close css division "footer" -->	
';

return;

}

function is_mobile()
{
	$useragent=$_SERVER['HTTP_USER_AGENT'];

	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){

		//header('Location: /mobile');
		header('Location: http://m.unitedwayathenslimestone.com');
	
	}

}


is_mobile();

?>