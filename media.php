<?php

	require_once("./inc/functions.php");
	require_once("./scripts/database_connection.php");

?>
<!DOCTYPE html>
<!-- unitedwayathenslimestone.com - Media Page -->
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
	<!-- include the css style sheet style.css -->
	</head>
		<body>
		<?php get_home_banner(); ?>
		<div id="darkframe"> <!-- css division "darkframe" - this is the blue border around the content -->
		<?php get_main_menu(); ?>
<!--Sidebar Code-->
<?php include("sidebar.php");?>
<!-- Main Content Starts Below-->
				<div class="content"> <!-- css division "content" -->
		          <h1>Videos</h1><!-- Header 1 style -->
          
							<?php

							function convertURL($origURL) {
								if ($origURL == '') {
									return '';
								}
								if (strpos($origURL, 'www.youtube.com') == false) {
									return '';
								}
								preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $origURL, $matches);
								$id = $matches[1];
								$first = '<iframe width="580" height="385" src="https://www.youtube.com/embed/';
								$last = '" frameborder="0" allowfullscreen></iframe>';
								$embeded = $first . $id . $last;
								return $embeded;
							}

							$query = "SELECT * FROM vids";
							$result = mysql_query($query) or die(mysql_error());

							$titles = array();
							$urls = array();
							$desc = array();

							while ($row = mysql_fetch_assoc($result)) {
								array_push($titles, $row["title"]);
								array_push($urls, convertURL($row["youtubeURL"]));
								array_push($desc, $row["description"]);
							}

							for ($i = 0; $i < 10; $i++) {
								if (strpos($urls[$i], 'www.youtube.com') !== false) { ?>
									<h3><?php echo $titles[$i]; ?></h3>
									<?php echo $urls[$i]; ?>
									<p><?php echo $desc[$i]; ?></p>
									<hr>
									<br>
							<?php
								}
							}

							?>


					<hr> <!-- horizontal bar -->
				  <h1>Photos</h1> <!-- Header 1 style -->
				  <!--http://embedsocial.com/embed-gallery.php-->
				  <iframe src="http://embedsocial.com/facebook_album/album_photos/245161305499772" width="880" height="1500" style="border: none;"></iframe> <!-- Embedded Facebook Photo Album -->
				  <hr>	<!-- horizontal bar -->
				</div> <!-- close css division "content" -->
			</div>  <!-- close css division "wrapper2" -->
		<?php get_home_footer(); ?>
		</div> <!-- close css division "darkframe" - this is the blue border around the content -->
		</body>
		<script src="js/bootstrap.js"></script>
</html>
