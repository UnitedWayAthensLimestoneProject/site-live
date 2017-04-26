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
	authorize_user(array("Volunteers", "Administrators"));
	
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
	page_start("Email Form", $javascript, "addEmail", $_REQUEST['success_message'], $error_message);
	admin_menu();

	
?>
		
    <div id="admin_form_container">
<form action="scripts/add_email.php" method="GET" id="submit_email_form" class="appnitro"> 
		<div class="form_description">
			<h2>Add New Email Recipient</h2>
			<p>&#160;</p>
		</div>
	

	<ul>
	
				<?php
					 	
					 	try {
							$action_sql = "SELECT * FROM email_action";
						
							$action_result = mysql_query($action_sql)
								or handle_error("an error occurred while searching for actions associated with the email", mysql_error());
								
							$num_of_rows = mysql_num_rows($action_result);
							
							
						} catch (Exception $exc) {
							handle_error("something went wrong while attempting to search for actions associated with the email.",
								"Error searching for actions associated with the email: " . $exc->getMessage());
						}
					 
				?>
				<ul>
					<li style="width:650px">
						<span>
							<label class="description" for="email_display_name">Display Name</label>
							<input name="email_display_name" size="26" maxlength="30" type="text" placeholder="Name">
						</span>
						<span>
							<label class="description" for="email_address">Email.</label>
							<input name="email_address" size="50" maxlength="100" type="email" class="text" placeholder="email@address.com">
						</span>
						<span>
							<label class="description" for="email_action_id">Action</label>
							
							<select name="email_action_id" required="required">
						<?php
							while($action = mysql_fetch_array($action_result)) {
								echo '<option value="'. $action['email_action_id'] . '"';
								echo '>' . $action['email_action_description']. "</option>\n";
							}
						?>
						</select>
						</span>
				</ul>
				<ul><li style="height:50px"></li></ul>

  <ul> 
          <li id="buttons" class="buttons"> <input name="form_id" type="hidden" value="submit_email_form" /> <input name="submit" id="submitForm" class="button_text" type="submit" value="Submit" /> </li> 
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