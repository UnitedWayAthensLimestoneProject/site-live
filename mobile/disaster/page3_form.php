<?php
session_start();
// Checking second page values for empty, If it finds any blank field then redirected to second page.
if (isset($_POST['pre_add_st1'])){
 if (empty($_POST['pre_add_st2'])
 || empty($_POST['pre_add_city'])
 || empty($_POST['pre_add_state'])
 || empty($_POST['pre_add_zip'])
 || empty($_POST['post_add_st1'])
 || empty($_POST['post_add_st2'])
 || empty($_POST['post_add_city'])
 || empty($_POST['post_add_state'])
 || empty($_POST['post_add_zip'])
 || empty($_POST['health'])
 || empty($_POST['household_income'])){ 
 $_SESSION['error_page2'] = "Mandatory field(s) are missing, Please fill it again"; // Setting error message.
 header("location: page2_form.php"); // Redirecting to second page. 
 } else {
 // Fetching all values posted from second page and storing it in variable.
 foreach ($_POST as $key => $value) {
 $_SESSION['post'][$key] = $value;
 }
 }
} else {
 if (empty($_SESSION['error_page3'])) {
 header("location: page1_form.php");// Redirecting to first page.
 }
}
?>
<!DOCTYPE HTML>
<html>
 <head>
 <title>Disaster Relief Form - United Way of Athens/Limstone County</title>
 <link rel="stylesheet" href="style.css" />
 </head>
 <body>
 <div class="container">
 <div class="main">
 <h2>Disaster Relief Form Part 3 of 4</h2><hr/>
 <span id="error">
 <?php
 if (!empty($_SESSION['error_page3'])) {
 echo $_SESSION['error_page3'];
 unset($_SESSION['error_page3']);
 }
 ?>
 </span>
 <form action="page4_form.php" method="post">
 <label>Type of Dwelling :<span>*</span></label>
 <select name="dwelling">
 <option value="single_family">Single Family</options>
 <option value="apt/condo">Apt/Condo</options>
 <option value="mobile_home">Mobile Home</options>
 </select><br><br>

	<label class ="description" for ="owner_renter_info">Are you an owner or renter?<span>*</span></label><br>

	<input  type ="radio" name="owner_renter_info" value="owner"  />
	<label class ="choice" for ="owner">Owner</label>

	<input type="radio" value="renter" name="owner_renter_info" />
	<label class="choice" for="renter">Renter</label><hr>

	<label>If Renter:</label><br><br>
	<label class="description" for="landlord_first_name">Landlord First Name</label>
	<input name="landlord_first_name" size ="26" maxlength="30" type ="text" class ="text"/>

	<label class="description" for="landlord_last_name">Landlord Last Name</label>
	<input name="landlord_last_name" size ="26" maxlength="30" type ="text" class ="text"/>

	<label class="description" for="monthly_rent">Monthly Rent</label>
	$<input name="monthly_rent" size ="26" maxlength="30" type ="text" class ="text"/><br><br><hr>


<label class="description" for="monthly_utilities">Monthly Utilities ( owners and renters):</label>
$<input name="monthly_utilities" size ="26" maxlength="30" type ="text" class ="text"/><br>
 <label>How is this dwelling used?<span>*</span></label>
 <select name="dwelling_use">
 <option value="primary_dwelling">Primary Home</options>
 <option value="secondary_dwelling">Secondary Home</options>
 <option value="business">Business</options>
 </select><br>


 <input type="reset" value="Reset" />
 <input name="submit" type="submit" value="Submit" />
 </form>
 </div> 
 </div>
 </body>
</html>