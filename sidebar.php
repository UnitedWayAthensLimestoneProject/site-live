
<?php
	require_once("inc/functions.php");
?>

<div id="wrapper2"> <!-- css division "wrapper2" -->
	<div id="sideQuote"><br><br> <!-- css division "sidQuote" -->
              <div class="cycle-slideshow" data-cycle-fx="fadeout" data-cycle-timeout="10000" data-cycle-slides="li" data-cycle-random="false" data-cycle-loop="100" data-index=1> <!-- using Cylce2, slideshow of photos -->
			 <ul>
				<li><img src=<?php sidebarPath("sidebar1"); ?> alt='sidebar1'></li>
				<li><img src=<?php sidebarPath("sidebar2"); ?> alt='sidebar2'></li>
				<li><img src=<?php sidebarPath("sidebar3"); ?> alt='sidebar3'></li>
				<li><img src=<?php sidebarPath("sidebar4"); ?> alt='sidebar4'></li>
				<li><img src=<?php sidebarPath("sidebar5"); ?> alt='sidebar5'></li>
				<li><img src=<?php sidebarPath("sidebar6"); ?> alt='sidebar6'></li>
				<li><img src=<?php sidebarPath("sidebar7"); ?> alt='sidebar7'></li>
				<li><img src=<?php sidebarPath("sidebar8"); ?> alt='sidebar8'></li>
		   </ul>
		</div>
		<div class="spacer heightThirteen"></div> <!-- css division "heightThirteen" for sidebar spacing-->
		<div id="center spacer"> <!-- css division "heightThirteen" for sidebar divider -->
		<div class="cycle-slideshow" data-cycle-fx="fadeout" data-cycle-timeout="10000" data-cycle-slides="li" data-cycle-loop="100" data-index=2> <!-- using Cylce2, slideshow of quotes -->
			<ul>
				<li><p id="text1" class="left"><?php include("sidebarTxt/textChange1.txt"); ?></p></li>
				<li><p id="text2" class="left"><?php include("sidebarTxt/textChange2.txt"); ?></p></li>
				<li><p id="text3" class="left"><?php include("sidebarTxt/textChange3.txt"); ?></p></li>
		   	<li><p id="text4" class="left"><?php include("sidebarTxt/textChange4.txt"); ?></p></li>
		   	<li><p id="text5" class="left"><?php include("sidebarTxt/textChange5.txt"); ?></p></li>
		   	<li><p id="text6" class="left"><?php include("sidebarTxt/textChange6.txt"); ?></p></li>
		   	<li><p id="text7" class="left"><?php include("sidebarTxt/textChange7.txt"); ?></p></li>
		   	<li><p id="text8" class="left"><?php include("sidebarTxt/textChange8.txt"); ?></p></li>
			</ul>
		</div><br><br>
        </div></div>  <!-- close css division "sidQuote" -->
