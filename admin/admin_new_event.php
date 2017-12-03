<?php 
	
	require_once 'scripts/database_connection.php';
	require_once 'scripts/view.php';
	require_once 'scripts/authorize.php';
	require_once 'scripts/functions.php';
	
	// request error message, null if not.
	$error_message = $_REQUEST['error_message'];

	// Start session to enable user authorization and control.
	session_start();

	// set time-out period (in seconds)
	$inactive = 600;
 
	// check to see if $_SESSION["timeout"] is set
	if (isset($_SESSION["timeout"])) 
	{
		// calculate the session's "time to live"
		$sessionTTL = time() - $_SESSION["timeout"];
		if ($sessionTTL > $inactive) 
		{
			session_destroy();
			$msg = "Your session has timed out due to inactivity. Please log in again to continue.";
			header("Location: login.php?error_message=" . $msg);
			exit();
		}
	}
 
	$_SESSION["timeout"] = time();
	
	// Authorize users to access page. Function is found in authorize.php.
	// Current user groups are Administrators, Volunteers, and Agencies
	// authorize_user(); will allow anyone that is logged in to access the page
	//authorize_user(array("Volunteers", "Administrators"));
	
	// Add any page specific javascript here.
	$javascript = <<<EOD
		$(document).ready(function() {
			$('#hide_used_goods').hide();

			$('#new').click (function() {
				$('#hide_used_goods').hide();
				$('#hide_used_goods').val('');
			});

			$('#used').click (function() {
				$('#hide_used_goods').show();
				$('#hide_used_goods').focus();
			});
			$('#donations_form').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.appendTo( '#val_label' );
					} else {
						error.insertAfter(element);
					} 
				}
			});
			
            $('#donations_form').validate();
			
			

			datePickerProperties = {
				changeMonth: true,
				changeYear: true,
				yearRange: "c-100:c"
            };

			$("input#dob").datepicker(datePickerProperties);

			$( '#home_phone' ).mask('(999) 999-9999');
			$( '#cell_phone' ).mask('(999) 999-9999');
			$( '#insurance_provider_phone' ).mask('(999) 999-9999');
			
			
		

			
			$('#donations_form').submit(function()
				{
					if( $('#home_phone').val() == "" && $('#cell_phone').val() == "")
					{
						$('#phone').append('<label class="error" id="error">You must fill in a number. <br>&nbsp;</label>');
						$('input.text_phone').addClass('text_phone_invalid');
						$('input.text_phone').keypress(function()
						{
							$('input.text_phone').removeClass('text_phone_invalid');
							$('#error').remove();
						});
						return false;
					}
					else
					{
						return true;
					}
				});
		
		});

EOD;

	
	// Creates the Banner and Menus/Tabs based on the type of user logged in. Function is
	// 		located in view.php
	// Format is 'page_start("<page_title>", <embedded_javascript_from_above>, "<selected_tab>",
	//		<success_message>, <error_message>);
	// The selected_tab must be setup in the uw.css file around line 165.
	// If there's no embedded javascript, change $javascript to NULL, below.
	page_start("Event Form", $javascript, "addEvent", $_REQUEST['success_message'], $error_message);
	admin_menu();

	
?>
		
    <div id="admin_form_container">
<form action="scripts/add_event.php" method="GET" id="submit_event_form" class="appnitro"> 
		<div class="form_description">
			<h2>Add New Event</h2>
			<p>&#160;</p>
		</div>
	
	<ul>
		<ul>
			<li style="width:650px">
				<span>
					<label class="description" for="event_date">Date</label>
					<input name="event_date" size="26" maxlength="10" type="date" value="<?php echo $event_row['event_date']; ?>">
				</span>
				<span>
					<label class="description" for="event_event">Event</label>
					<input name="event_event" size="50" maxlength="200" type="text" value="<?php echo $event_row['event_event']; ?>">
				</span>
				<span>
					<label class="description" for="event_location">Location</label>
					<input name="event_event" size="50" maxlength="50" type="text" value="<?php echo $event_row['event_location']; ?>">
				</span>
		</ul>
		<ul><li style="height:50px"></li></ul>

	<ul> 
        <li id="buttons" class="buttons"> <input name="form_id" type="hidden" value="submit_event_form" /> <input name="submit" id="submitForm" class="button_text" type="submit" value="Submit" /> </li> 
    </ul> <br><br>
</form>
</div>
	<div class="footer">
		Designed by Athens State University
	</div>
	</div>
</body>
</html>

</html>