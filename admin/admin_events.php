<?php

	require_once 'scripts/authorize.php';
	require_once 'scripts/database_connection.php';
	require_once 'scripts/view.php';
	require_once 'scripts/functions.php';

	// Start session to enable user authorization and control.
	//session_start();

	// set time-out period (in seconds)
	//$inactive = 600;
 
	// check to see if $_SESSION["timeout"] is set
/*	if (isset($_SESSION["timeout"])) 
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
 
	$_SESSION["timeout"] = time();*/
	
	// Authorize users to access page. Function is found in authorize.php.
	// Current user groups are Administrators, emails, and Agencies
	// authorize_user(); will allow anyone that is logged in to access the page
	//authorize_user(array("Administrators"));
	

	
	if (isset($_POST['form_id']) || isset($_GET['edit_event'])) {
		
		$searchform = $_POST['form_id'];
		
		if ($searchform == 'submit_form_search_for_event') {
			$searchforvol = 1;
			$searchdate = mysql_real_escape_string(trim($_POST['searchdate']));
			$searchevent = mysql_real_escape_string(trim($_POST['searchevent']));
			$searchlocation = mysql_real_escape_string(trim($_POST['searchlocation']));
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_event, #form_edit_event ').hide();
			$(' #form_search_by_event ').show();
			
			$('#form_search_by_event').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #editvoltable ');
					} else {
						error.insertAfter(element);
					}
				},
				messages: {
					event_id: {
						required: "<br>Select a row to edit."
					}
				}
			});
		});
EOD;
		} else if (($searchform == 'submit_form_search_by_event') || isset($_GET['edit_event'])) {
			$searchbyvol = 1;
			
			if(isset($_GET['edit_event']))
			{
				$searchvolid = $_GET['edit_event'];
			} else {
				$searchvolid = $_POST['event_id'];
			}
			
			$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_for_event, #form_search_by_event, #editvoltable ').hide();
			$(' #form_edit_event ').show();
			
			$( 'input#active, input#inactive' ).button();
			$( 'div#activeinactive' ).buttonset();
		
			if ($( '#active' ).attr('checked') == 'checked') {
				$( '#active' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
				$( '#inactive' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
			} else {
				$( '#active' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
				$( '#inactive' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
			};
		
			$( '#active' ).click(function() {
				$( '#active' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
				$( '#inactive' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
			});
		
			$( '#inactive' ).click(function() {
				$( '#active' ).button( {
					icons : { secondary : 'ui-icon-bullet' }
				});
				$( '#inactive' ).button( {
					icons : { secondary : 'ui-icon-check' }
				});
			});
		});
		
		$(function() {
			$( "input#dob" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: "c-100:c",
				onClose: function( selectedDate ) {
					$( "#dob" ).focus();
				}
			});
	    });
EOD;
			
		}

	} else {
		
		$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_search_by_event, #form_edit_event ').hide();
			$(' #form_search_for_event ').show();
			$(' #searchdate ').focus();
			
			$('#form_search_for_event').submit(function()
				{
					return true;
					if( $('#searchdate').val() == "" && $('#searchevent').val() == "" && $('#searchlocation').val() == "")
					{
						$('#buttons').prepend('<label class="error">You must fill in at least one event item! <br>&nbsp;</label>');
						return false;
					}
					else
					{
						return true;
					}
				});
		
		});
EOD;
		
	

	$javascript .= "
	
	$(function () {    
    $('#editvoltable').w2grid({ 
        name: 'grid', 
		header: 'Events',
        show: { 
            toolbar: true,
            footer: true,
			header: true,
            toolbarEdit: true,
            toolbarAdd: true
        },
        searches: [                
            { field: 'event_date', caption: 'Date', type: 'text' },
            { field: 'event_event', caption: 'Event', type: 'text' },
            { field: 'event_location', caption: 'Location', type: 'text' },
        ],
        columns: [                
            { field: 'event_date', caption: 'Date', size: '20%', sortable: true, attr: 'align=center' },
            { field: 'event_event', caption: 'Event', size: '30%', sortable: true, attr: 'align=center' },
            { field: 'event_location', caption: 'Location', size: '50%', sortable: true, attr: 'align=center' },
         ],
        onAdd: function (event) {
			location.href = 'admin_new_event.php';
        },
        onEdit: function (event) {
			location.href = 'admin_events.php?edit_event='+event.recid;
        },
        onDelete: function (event) {
            console.log('delete has default behaviour');
        },
        onSave: function (event) {
            w2alert('save');
        },
        records: [
		";
		
		try {
			$sql = "SELECT DISTINCT event_id, " .
				   "event_date, " .
				   "event_event, " .
				   "event_location " .
				   "FROM event_forms " .
				   "ORDER BY event_date";
		
			$result = mysql_query($sql)
				or handle_error("an error occurred while searching for events", mysql_error());
			
			$num_of_rows = mysql_num_rows($result);

		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to search for events.",
				"Error searching for events: " . $exc->getMessage());
		}
		
		while ($row = mysql_fetch_array($result))
		{
			$javascript .= "{ recid: ".$row['event_id'].", event_date: '".$row['event_date']."', event_event: '".$row['event_event']."', event_location: '".$row['event_location']."' },
			";
		}

$javascript .= "		
        ]
    });    
});";
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminEvent",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();
?>
		
		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Event Administration</h2>
				<p>Allows Administrators to edit event information.</p>
			</div>	
			
			<div id="editvoltable"></div>
			
			<center>
			<form name="form_search_for_event" id="form_search_for_event" method="post" style="margin:25px 10px" 
				action="admin_events.php">
			</form>
			</center>
			
			<form name="form_search_by_event" id="form_search_by_event" method="post" style="margin:25px 10px" 
				action="admin_events.php">
			</form>
			
			<form name="form_edit_event" id="form_edit_event" class="appnitro" method="POST" action="scripts/process_admin_event.php">
				<?php
					if ($searchbyvol == 1) {
						$searchbyvol = 0;
					
						$event_query = "SELECT * " .
								 	"  FROM event_forms " .
								 	" WHERE event_id = " . $searchvolid;
								 
						$event_data = mysql_query($event_query)
						 	or handle_error("an error occurred while searching for event", mysql_error());
						
					 	$event_row = mysql_fetch_array($event_data);
					 }
				?>
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
					<li class="buttons">
						<input type="hidden" name="form_id" value="submit_event_form">
						<input type="hidden" name="submit_event_id" value="<?php echo $event_row['event_id']; ?>">					
						<input type="submit" name="submitAdminVol" id="submitApproveVol" class="button_text" value="Update">
						<input type="submit" name="submitAdminVol" id="submitDeleteVol" class="button_text" value="Delete">					
						<input type='reset' name='clearEditevent' id='clearEditevent' class='button_text' value='Cancel' onclick='window.location = window.location.pathname'>
					</li>
				</ul>
			</form>
		
		</div>
		<div class="footer">
			Designed by Athens State University
		</div>
	</div>
	</div>
</body>
</html>