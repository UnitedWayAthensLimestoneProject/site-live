<?php
session_start();
// Checking first page values for empty,If it finds any blank field then redirected to first page.
if (isset($_POST['first_name'])){
 if (empty($_POST['first_name'])
 || empty($_POST['last_name'])
 || empty($_POST['email'])
 || empty($_POST['dob'])
 || empty($_POST['home_phone'])
 || empty($_POST['cell_phone'])
 || empty($_POST['interview'])){ 
 // Setting error message
 $_SESSION['error'] = "Mandatory field(s) are missing, Please fill it again";
 header("location: page1_form.php"); // Redirecting to first page 
 }
}

else {
 foreach ($_POST as $key => $value) {
 $_SESSION['post'][$key] = $value;
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
 <h2>Disaster Relief Form Part 2 of 4</h2><hr/>
 <span id="error">
<?php
// To show error of page 2.
if (!empty($_SESSION['error_page2'])) {
 echo $_SESSION['error_page2'];
 unset($_SESSION['error_page2']);
}
?>
 </span>
 <form action="page3_form.php" method="post">

		<label class = "description" for="address"> Pre-Disaster Address</label>
		<label for ="pre_add_st1"> Street Address (line 1)</label>
		<input name="pre_add_st1" size ="87" maxlength ="30" type ="text" class ="text" />
		<br>
		<label for ="pre_add_st2">Street Address (line 2) </label>
		<input name= "pre_add_st2" size="87" maxlength ="30" type ="text" class ="text"/>
		<br>
		<label for ="pre_add_city"> City </label>
		<input name ="pre_add_city" size ="25" maxlength ="30" type ="text" class ="text"/>
		<br>
		<label for ="pre_add_state">State</label>
		<input name="pre_add_state" size="2" maxlength ="2" type ="text" value="AL" class ="center_text"/>
		<br>
		<label for ="pre_add_zip"/> Postal&#47; Zip Code </label>
		<input name ="pre_add_zip" size ="5" maxlength ="5" type ="text" class ="text" placeholder="#####"/>
		

<br><br><hr>
		<label class = "description" for="address2"> Post Disaster-Address</label>
		<label for ="post_add_st1"> Street Address (line 1)</label>
		<input name="post_add_st1" size ="87" maxlength ="30" type ="text" class ="text" />
		<br>
		<label for ="post_add_st2">Street Address (line 2) </label>
		<input name= "post_add_st2" size="87" maxlength ="30" type ="text" class ="text"/>
		<br>
		<label for ="post_add_city"> City </label>
		<input name ="post_add_city" size ="25" maxlength ="30" type ="text" class ="text"/>
		<br>
		<label for ="post_add_state">State</label>
		<input name="post_add_state" size="2" maxlength ="2" type ="text" value="AL" class ="center_text"/>
		<br>
		<label for ="post_add_zip"/> Postal&#47; Zip Code </label>
		<input name ="post_add_zip" size ="5" maxlength ="5" type ="text" class ="text" placeholder="#####"/>

<br><br><hr>

<label class ="description" for ="health">Do you have any health limitations?</label><br>
			
	<input  type ="radio" id ="health_limits_yes" name ="health_limits" value ="1" title ="*PLEASE SELECT A HEALTH OPTION" required />
	<label class ="choice "  for ="health_limits_yes">Yes</label>

	<input type="radio" id="health_limits_no" name="health_limits" value ="0" />
	<label class="choice " for="health_limits_no" >No</label><br>
	<label>If Yes:</label><br><br>


	<label class ="description" for="health_limits_comment">Please explain your health limitations here:</label>		
	<textarea id ="health_limits_comment" name ="health_limits_comment" rows ="4" cols ="35" maxlength ="250" placeholder="Enter limatations here..."></textarea><br><br>
 
 <label>Annual Household Income :<span>*</span></label>
 <select name="household_income">
 <option value="$0-$9,999">$0 to $9,999</options>
 <option value="10,000-29,999">$10,000 to $29,999</options>
 <option value="30,000-49,999">$30,000 to $49,000</options>
 <option value="50,000-69999">$50,000 to $69,000</options>
 <option value="70,000-89,999">$70,000 to $89,999</options>
 <option value="90,000-over">$90,000 and over</options>
 </select><br>


 <input type="reset" value="Reset" />
 <input type="submit" value="Next" />
 </form>
 </div>
 </div>
 </body>
</html>
