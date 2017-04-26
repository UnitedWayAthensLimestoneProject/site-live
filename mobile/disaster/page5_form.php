<!DOCTYPE HTML>
<html>
 <head>
 <title>PHP Multi Page Form</title>
 <link rel="stylesheet" href="style.css" />
 </head>
 <body>
 <div class="container">
 <div class="main">
 <h2>PHP Multi Page Form</h2>
 <?php
 session_start();
 if (isset($_POST['dwelling_insurance'])) {
 if (!empty($_SESSION['insurance_provider_name'])){
 if (empty($_POST['insurance_provider_phone'])
 || empty($_POST['damage_level'])
 || empty($_POST['housing_needs'])
 || empty($_POST['housing_need_type'])
 || empty($_POST['electricity'])
 || empty($_POST['dwelling_insurance'])){ 
 // Setting error for page 3.
 $_SESSION['error_page4'] = "Mandatory field(s) are missing, Please fill it again";
 header("location: page4_form.php"); // Redirecting to forth page.
 } else {
 foreach ($_POST as $key => $value) {
 $_SESSION['post'][$key] = $value;
 } 
 extract($_SESSION['post']); // Function to extract array.



 $connection = mysql_connect("localhost", "root", "");

 $db = mysql_select_db("phpmultipage", $connection); // Storing values in database.
 $query = mysql_query("insert into detail (first_name, last_name, email, dob, home_phone, cell_phone, interview_date, 
 	event_date, pre_add_st1, pre_add_st2, pre_add_city, pre_add_state, pre_add_zip, post_add_st1, post_add_st2, post_add_city, post_add_state, post_add_zip,
 	health, health_limits_comment, household_income, dwelling, owner_renter_info, landlord_first_name, landlord_last_name, monthly_rent, monthly_utlities,
 	dwelling_use, dwelling_insurance, insurance_proider_name, insurance_provider_phone, damage_level, electricity, housing_needs, housing_need_type) 
	values('$first_name', '$last_name', '$email', '$dob', '$home_phone', '$cell_phone', '$interview_date', '$event_date', '$pre_add_st1', '$pre_add_st2', '$pre_add_city', 
	'$pre_add_state', '$pre_add_zip', '$post_add_st1', '$post_add_st2', '$post_add_city', '$post_add_state', '$post_add_zip,health', '$health_limits_comment', 
	'$household_income', '$dwelling', '$owner_renter_info', '$landlord_first_name', '$landlord_last_name', '$monthly_rent', '$monthly_utlities', '$dwelling_use', 
	'$dwelling_insurance', '$insurance_proider_name', '$insurance_provider_phone', '$damage_level', '$electricity', '$housing_needs', '$housing_need_type')", $connection);
 

 if ($query) {
 echo '<p><span id="success">Form Submitted successfully..!!</span></p>';
 } else {
 echo '<p><span>Form Submission Failed..!!</span></p>';
 } 
 unset($_SESSION['post']); // Destroying session.
 }
 } else {
 header("location: page1_form.php"); // Redirecting to first page.
 }
 } else {
 header("location: page1_form.php"); // Redirecting to first page.
 }
 ?>
 </div>
 </div>
 </body>
</html>