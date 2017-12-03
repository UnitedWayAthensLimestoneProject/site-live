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
	page_start("Donation Form", $javascript, "addDonation", $_REQUEST['success_message'], $error_message);
	admin_menu();

	
?>
		
    <div id="admin_form_container">
<form action="scripts/add_donation.php" method="GET" id="donation_rport_form" class="appnitro"> 
		<div class="form_description">
			<h2>Donation of Goods Form</h2>
			<p>&#160;</p>
		</div>
	

	<ul>
	
	<li style ="width: 900px">
		<span>
			<label class="description" for="first_name">First Name</label>
			<input name="first_name" size ="26" maxlength="30" type ="text" class ="text required"/>
		</span>
		<span>
			<label class ="description" for ="middle_initial">M.I.</label>
			<input name="middle_initial" size ="1" maxlength="1" type ="text" class ="center_text"/>
		</span>
		<span>
			<label class ="description" for ="last_name"> Last Name</label>
			<input name ="last_name" size="26" maxlength ="30" type ="text" class= "text required"/>
			</span>
		<span style = "margin-left:10px">
			<label class = "description" for ="dob"> Date Of Birth </label>
			<input id ="dob" name ="dob" type="date" class ="text required"/>
		</span>
		<span class = "clear">
			<label class ="description" for ="email"> Email Address</label>
			<input name="email" id = "email" type ="email" size ="40" maxlength ="100" class ="text email" required placeholder="email@address.com" />
		</span>
		<span style ="margin-left:10px">
			<label class="description" for="home_phone_header">Home Phone </label>
			<input name ="home_phone" id="home_phone" size="15" maxlength="15" type ="text" class="text_phone" required placeholder="###-###-####"/>
		</span>
		<span style ="margin-left:10px">
			<label class ="description" for ="cell_phone">Cell Phone </label>
			<input name ="cell_phone" id="cell_phone" size="15" maxlength="15" type ="text" class="text_phone" placeholder="###-###-####"/>
		</span>
	</li>

	<div class="form_description">
		<p>&#160;</p>
		</div>
	<br>


<h3> Donation Items </h3>
<li>
<label class = "description" for="item_type"> Type of Items</label>
<span class ="left" style ="width:400px">
<input type="checkbox" name="household_items" value="1" title = "*PLEASE SELECT ITEM TYPE" required/> House Hold Items (Example: Full size bed, Gas Stove, or Chair)
</span>
</li>
<li>
<span class ="left" style ="width:350px">
<input type="checkbox" name="baby_items" value="1" title = "*PLEASE SELECT ITEM TYPE"/> Baby Items (Example:Diapers, Formula, Bottles)
</span>
</li>
<li>
<span class ="left" style ="width:350px">
<input type="checkbox" name="misc_items" value="1" title = "*PLEASE SELECT ITEM TYPE"/> Miscellaneous Items (Any thing that may be useful)
</span>
</li>
<li>
<span class ="left" style ="width:350px">
<input type="checkbox" name="bulk_items" value="1" title = "*PLEASE SELECT ITEM TYPE"/> Bulk Items (Any thing that you have bulk quantity of)
</span>

</li>

<li>
<span>
<label class = "description" for="item_desc"> Description of Items</label>
<textarea id="item_desc" name="item_desc" rows= "4" cols="50"></textarea>
</span>
</li>



<li>
<label class = "description" for="item_condition"> Condition of Items</label>
<span>
<input type="radio" id="new" name="item_condition" value="new" title = "*PLEASE TELL US THE CONDITION OF THE ITEMS" required />New
</span>
<span>
<input type="radio" id="used" name="item_condition" value="used" title = "*PLEASE TELL US THE CONDITION OF THE ITEMS" />Used
</span>
</li>

<li>
<div id ="hide_used_goods">
			<label class="description" for="used_item_condition">Condition of used items: </label>
			<span>
			<input type="radio" name= "used_item_condition" value="excellent"  /> Excellent
			</span>
			<span>
			<input type ="radio" name="used_item_condition" value="good"/> Good
			</span>
			<input type ="radio" name="used_item_condition" value="fair"/> Fair
			<span>
			<input type ="radio" name="used_item_condition" value="poor"/> Poor
			</span>
			</div>
</li>

<br>
<div class="form_description">
		<p>&#160;</p>
		</div>
<li>
<label class="description" for="can_deliver">Are you able to deliver your items if needed?  </label>
<span>
<input type ="radio" name="can_deliver" value="1" title = "*PLEASE LET US KNOW IF YOU CAN DELIVER THE ITEMS" required /> Yes
</span>
<span>
<input type ="radio" name="can_deliver" value="0" title = "*PLEASE LET US KNOW IF YOU CAN DELIVER THE ITEMS"/> No
</span>
</li>

<li>
<label class = "description" for="can_store">Are you able to store your items if needed?  </label>
<span>
<input type="radio" name="can_store" value="1" title ="*PLEASE LET US KNOW IF YOU CAN STORE ITEMS" required /> Yes
</span>
<span>
<input type="radio" name="can_store" value="0" title ="*PLEASE LET US KNOW IF YOU CAN STORE ITEMS" /> No
</span>
</li>
</tr>
<tr>
</table>
<li>
		<span>
			<label class = "description" for="address2"> If you are storing the items, please state the address of stored items below</label>
			<input name="address_stored_items_st1" size ="80" maxlength ="30" type ="text" class ="text" />
			<label for ="address_stored_items_st1"> Street Address (line 1)</label>
		</span>
		<span class ="clear">
			<input name= "address_stored_items_st2" size="80" maxlength ="30" type ="text" class ="text"/>
			<label for ="address_stored_items_st2">Street Address (line 2) </label>
			</span>
		<span class ="clear">
			<input name ="address_stored_items_city" size ="25" maxlength ="30" type ="text" class ="text"/>
			<label for ="address_stored_items_city"> City </label>
		</span>
		<span>
		<input name="address_stored_items_state" size="2" maxlength ="2" type ="text" value="AL" class ="center_text required"/>
		<label for ="address_stored_items_state">State</label>
		</span>
		<span>
			<input name ="address_stored_items_zip" size ="5" maxlength ="15" type ="text" class ="text" placeholder="#####"/>
				<label for ="address_stored_items_zip"/> Postal&#47; Zip Code </label>
		</span>
		</li>
<h2 id="val_label" align="center" > &nbsp; <br><br> </h2>

<li class="buttons">
				<img id="captcha" src="/inc/securimage/securimage_show.php" alt="CAPTCHA Image" />
                                                                   <object type="application/x-shockwave-flash"data="/inc/securimage/securimage_play.swf?audio_file=/inc/securimage/securimage_play.php&amp;
                                                                        bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" width="25" height="25">
                                                                   <param name="movie" value="/inc/securimage/securimage_play.swf?audio_file=/inc/securimage/securimage_play.php&amp;
                                                                        bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" />
                                                                   </object><br>
				<input type="text" name="captcha_code" size="15" maxlength="6" />
                                                                   <br> 
                                                                   <a href="#" onclick="document.getElementById('captcha').src = '/inc/securimage/securimage_show.php?' + Math.random(); 
				return false">[ Different Image ]</a>
			</li>
  <ul> 
          <li id="buttons" class="buttons"> <input name="form_id" type="hidden" value="submit_donations" /> <input name="submit" id="submitForm" class="button_text" type="submit" value="Submit" /> </li> 
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