
<?php

require_once("inc/functions.php");

?>

<!DOCTYPE html>

<html>

<head>

<?php load_headers(); ?>


</head>

<body>

	<center>
	
	<div id="main">
	<span>
		<center>
					<h1>Make A Donation</h1> <!-- Header 1 style -->
					<!-- paragraph -->
					<p>LIVE UNITED. It's a credo. A mission. A goal. A constant reminder that when we reach 
					  out a hand to one, we influence the condition of all. We build the strength of our 
					  neighborhoods. We bolster the health of our communities. And we change the lives of 
					  those who walk by us every day.</p>
					<br>
					<!-- PayPal generated code for a "Donate" button - links to a PayPal donate page -->
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="5P7FCDNCSBR4W">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!">
					</form>
					<br>
		</center>
	</span>
	</div>

	<?php main_menu(); ?>
	
	</center>

</body>

</html>