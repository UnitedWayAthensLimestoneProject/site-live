<?php
	
	require_once 'database_connection.php';
	require_once 'functions.php';
	
	$processType = mysql_real_escape_string($_REQUEST['action']);
	$donation_id = mysql_real_escape_string($_REQUEST['id']);
	
	if ($processType == 'approve') {
	
	try {
				
		$update_sql = "UPDATE donation SET admin_review = 1 WHERE donation_id = {$donation_id}";
				  
		mysql_query($update_sql)
				or handle_error("an error occurred while updating donation", mysql_error());
	
	} catch (Exception $exc) {
		handle_error("something went wrong while attempting to save agency donation.",
					 "Error saving donation: " . $exc->getMessage());
	}
	// Redirect to view donation page
	$msg = "The donation has been successfully approved and updated.";
	header("Location: /admin/admin_reviews_donation.php?success_message=" . $msg);
	exit();
	
	} else if ($processType == 'delete') {
	
	try {

		$delete_opp_query = "DELETE FROM donation WHERE donation_id = {$donation_id}";
			
		mysql_query($delete_opp_query)
				or handle_error("an error occurred while deleting the donation", mysql_error());
				
		} catch (Exception $exc) {
			handle_error("something went wrong while attempting to delete donation.",
						 "Error deleting donation: " . $exc->getMessage());
		}
		
		// Redirect to view donation info
		$msg = "The donation has been successfully deleted.";
		header("Location: /admin/admin_reviews_donation.php?success_message=" . $msg);
		exit();
	}
		
	$msg = "Unable to Process.";
	header("Location: /admin/admin_reviews_donation.php?success_message=" . $msg);
		
	exit();
?>