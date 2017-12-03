<?php
	
	//Need to build a database to connect this to
	require_once 'scripts/authorize.php';
	require_once 'scripts/database_connection.php';
	require_once 'scripts/view.php';
	require_once 'scripts/functions.php';

	
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
	// Current user groups are Administrators, emails, and Agencies
	// authorize_user(); will allow anyone that is logged in to access the page
	authorize_user(array("Administrators"));
	
		//Query Database for any current entries
	
	$query = "SELECT * FROM calendar ";
	$query .= "ORDER BY date DESC";
	$event_set = mysql_query($query);

	
	function mysql_prep($string)
	{
		global $connection;
		
		$escaped_string = mysql_real_escape_string($connection, $string);
		return $escaped_string;
	}

	page_start("United Way of Athens/Limestone County EMD Admin Page", NULL, "viewEvent",
			   $_REQUEST['success_message'], $_REQUEST['error_message']);

	admin_menu();

?>

<div id="admin_form_container">

	<div class="form_description" align="center">
				<h2>Event Administration</h2>
				<p>Allows Administrators to view current events.</p>
	</div>
		
    <div class="adminDefaults" >
			
			<?php
							$event_set;
							if (mysql_num_rows($event_set) > 0)	
							{ 
					
								while ($row = mysql_fetch_assoc($event_set))
								{ ?>  <!-- Run this code while the number of events is greater than 0 -->

						          <table>
								  <tr>	<!-- Starts Head of table -->
								    <th>Date</th>
								    <th>Event</th>
								    <th>Location</th>
								    <th>Actions</th>
								  </tr>
								  <tr>
								    <td> <?php 
								 $time = $row['time'];
								 $date = $row['date'];
								 $datetime = date("m-d-Y g:i A", strtotime("$date $time"));
								 
								 echo htmlentities($datetime);?></td>
								    <td> <?php echo htmlentities($row['event']);?> </td>
								    <td><?php echo htmlentities($row['location']); ?></td>
								    <td>
								    	<a href = "edit_event.php?id=<?php echo urlencode($row["id"]); ?>">Edit</a>
								    	&nbsp;<a href = "delete_event.php?id=<?php echo urlencode($row["id"]); ?>">Delete</a>
								    </td>
								  </tr>
								   
								</table>

								<?php 
								}
							}

							else
							{
								?>
								<div id = "eventDefaults">	<!-- If no events this message occurs -->
								No Current Events
								<?php
							} 
							
							?>
                <br>	
						
                <a href="create_event.php">Create New Event</a>			
													
                </div>          
      </div>
      
      
      
      <div class="footer">
			Designed by Athens State University
		</div>
      
    </div>
		</div>
	

<body>
</body>
</html>