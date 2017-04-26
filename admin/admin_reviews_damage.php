<?php 
	
	require_once 'scripts/authorize.php';
	require_once 'scripts/database_connection.php';
	require_once 'scripts/view.php';
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
	authorize_user(array("Administrators", "Agencies"));
	
	// Add any page specific javascript here.
	if (isset($_POST['form_id'])) {
		
		$searchform = $_POST['form_id'];
		
		if ($searchform == 'submit_form_list_damage') {
			$searchforopp = 1;
			$searchoppid = $_POST['opp_id'];
	$javascript = <<<EOD
	$(document).ready(function() {
	
		$(' #form_list_damage ').hide();
		$(' #form_process_damage ').show();
		
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
		
		$( '#form_process_damage' ).submit(function() 
		{
			return true;
		});
		
		$('#form_process_damage').validate( {
				errorPlacement: function(error, element) {
		       if ( element.is(":radio") || element.is(":checkbox")) {
		          error.appendTo( '#skilllabel' );
		        } else {
		          error.insertAfter(element);
		        } 
		    }
				});
		
		$(function() {
			$(' #startTime ').timepicker({ 'timeFormat' : 'h:i A' })
			$(' #endTime ').timepicker({ 'timeFormat' : 'h:i A' })
		});
	});
	
	$(function() {
		$( "input#dateOfRequest" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "c-1:c+1",
			onClose: function( selectedDate ) {
				$( "#dateOfRequest" ).focus();
			}
		});		
		$( "#startDate" ).datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
				$( "#endDate" ).datepicker( "option", "minDate", selectedDate );
				$( "#endDate" ).focus();
			}
	    });
		$( "#endDate" ).datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
		        $( "#startDate" ).datepicker( "option", "maxDate", selectedDate );
		        $( "#startHour" ).focus();
			}
	    });
	    

	});
EOD;

		}
	} else {
	
		$javascript = <<<EOD
		$(document).ready(function() {
	
			$(' #form_process_damage ').hide();
			$(' #form_list_damage ').show();
		
			$('#form_list_damage').validate( {
				errorPlacement: function(error, element) {
					if ( element.is(":radio") || element.is(":checkbox")) {
						error.insertAfter(' #editopptable ');
					} else {
						error.insertAfter(element);
					}
				},
				messages: {
					opp_id: {
						required: "<br>Select a row to edit."
					}
				}
			});
		});
EOD;
	$javascript .= "
	
	$(function () {    
    $('#editvoltable').w2grid({ 
        name: 'grid', 
		header: 'Damages for Review',
		multiSelect : false,
        show: { 
            toolbar: true,
            footer: true,
			header: true,
            toolbarAdd: true,
			toolbarEdit: true,
            toolbarDelete: true
        },
		buttons: {
			add: { caption: 'Approve', disabled: true   }
		},
        searches: [                
            { field: 'first_name', caption: 'First Name', type: 'text' },
            { field: 'last_name', caption: 'Last Name', type: 'text' },
            { field: 'email_address', caption: 'Email', type: 'text' },
            { field: 'home_phone', caption: 'Home Phone', type: 'text' },
            { field: 'cell_phone', caption: 'Cell Phone', type: 'text' },
        ],
        columns: [                
            { field: 'first_name', caption: 'First Name', size: '30%', sortable: true, attr: 'align=right' },
            { field: 'last_name', caption: 'Last Name', size: '30%', sortable: true, attr: 'align=right' },
            { field: 'email_address', caption: 'Email', size: '40%', sortable: true, attr: 'align=center' },
            { field: 'home_phone', caption: 'Home Phone', size: '120px', sortable: true, attr: 'align=center' },
            { field: 'cell_phone', caption: 'Cell Phone', size: '120px', sortable: true, attr: 'align=center' },
         ],
        onAdd: function (event) {
			location.href = 'scripts/process_admin_damage_reviews.php?action=approve&id='+this.getSelection();
        },
        onEdit: function (event) {
			location.href = 'admin_damage.php?edit_damage='+event.recid;
        },
        onDelete: function (event) {
			if(event.force==true){
				location.href = 'scripts/process_admin_damage_reviews.php?action=delete&id='+this.getSelection();
			}
		},
		onSelect: function(event) {
			event.onComplete = function() {
				if(this.getSelection().length==1) {
					this.toolbar.enable('w2ui-add');
				} else {
				console.log('disable');
					this.toolbar.disable('w2ui-add');
				}
			}
		},
		onUnselect: function(event) {
			event.onComplete = function() {
				if(this.getSelection().length==1) {
					this.toolbar.enable('w2ui-add');
				} else {
					this.toolbar.disable('w2ui-add');
				}
			}
		},
       records: [
		";
		
		$where = "admin_review is null or admin_review = 0";
		
		try {
			$sql = "SELECT DISTINCT damage_id, " .
				   "				first_name, " .
				   "				last_name, " .
				   "				email, " .
				   "				home_phone, " .
				   "				cell_phone " .
				   "		   FROM damage " .
				   "		  WHERE " . $where .
				   "	   ORDER BY first_name, " .
				   "	 		    last_name";
		
			$result = mysql_query($sql)
				or handle_error("an error occurred while searching for damages", mysql_error());
			
			$num_of_rows = mysql_num_rows($result);

		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to search for damages.",
				"Error searching for damages: " . $exc->getMessage());
		}
		
		while ($row = mysql_fetch_array($result))
		{
			$javascript .= "{ recid: ".$row['damage_id'].", first_name: '".$row['first_name']."', last_name: '".$row['last_name']."', email_address: '".$row['email']."', home_phone: '".$row['home_phone']."', cell_phone: '".$row['cell_phone']."' },
			";
		}

$javascript .= "		
        ]
    });    
});";
	}
	
	page_start("United Way of Athens/Limestone County EMD Admin Page", $javascript, "adminReviewDamage",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);
			   
	admin_menu();
?>

		<div id="admin_form_container">
			<div class="form_description" align="center">
				<h2>Admin Review of New Damage Reports</h2>
				<p>Gives Administrators the ability to approve/disapprove agency damage.
				<br>(NOTE: Only damage requiring review will appear here.)
				</p>
			</div>
			

			<div id="editvoltable"></div>
			
		</div>
		<div class="footer">
			Designed by Athens State University
		</div>
	</body>
</html>