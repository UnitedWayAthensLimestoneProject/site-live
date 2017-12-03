<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					   "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Consent to Disclose Information- United Way of Athens/Limestone County</title>

	<link rel="stylesheet" type="text/css" href="../inc/css/uw.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../inc/css/print.css" media="print">
	<link rel="stylesheet" type="text/css" href="../inc/js/jquery/jquery-ui/smoothness/jquery-ui-1.10.3.custom.min.css">
	<script type="text/javascript" src="../inc/js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="../inc/js/jquery/query-ui.min.js"></script>
	<script type="text/javascript" src="../inc/js/jquery/jquery.validate.min.js"></script>
	   
	
<script type="text/javascript">
		$(document).ready(function() {
			$( '#agree' ).prop('checked', false);
			$( '#printsign' ).hide();
		
			$agree_btn = true;
			$( '#submitForm' ).attr('disabled', $agree_btn);
			
			$( '#agree' ).click(function() {
				$agree_btn = !$agree_btn;
				$( '#submitForm' ).attr('disabled', $agree_btn);
			});
			
			$('#print_btn').click(function() {
				$( '#printsign' ).show();
			
				window.print();
				
				$( '#printsign' ).hide();
			});
			
		});
		
	</script>

	
	<style type="text/css">
		form#form_code_of_conduct {
			margin:10px 50px 50px 50px;
		}
		
		table {
			margin:0 15px 25px 15px;
		}
		
		p, td {
			margin-top: 15px;
			font-family: "Times New Roman", Times, serif, Arial;
			font-size: large;
		}
		
		h1 {
			text-align: center;
			font-weight: bold;
			font-family: "Times New Roman", Times, serif, Arial;
			font-size: x-large;
		}
		
		h3 {
			margin-top: 15px;
			text-align: center;
			font-weight: bold;
			font-family: "Times New Roman", Times, serif, Arial;
			font-size: large;
		}
	</style>
	
</head>

<body>
	<div id="wrapper">
		<div class="banner"><img src="../images/uww-logo_2013.png" alt="United Way Logo" /></div>
		<div id="menu" align="center">
			<ul id="mainNav" class="center">
				<li>
				</li>
    		</ul>
  		</div>
		<br>
	

  		<div id="form_container">
		
			<form id="form_damage_consetn" method="POST" action="disaster_relief_form.php">
				<div style="text-align:right">
					<input type="button" id="print_btn" value="Print Form">
				</div>
	    <br>
         	<div style="text-align:center">
					<h1>UNITED WAY OF ATHENS &amp; LIMESTONE COUNTY<br>CONSENT TO DISCLOSURE OF INFORMATION</h1>
					<h3>Mission Statement</h3>
				</div>  
     <p>The mission of the United Way of Athens &amp; Limestone County is to increase the organized capacity of people to care for one another.</p>
     <h3>Consent to Disclosure</h3>
     	 
        <table id ="Damage_Report_Consent_Form">
		<tr>
		<td style="width:25px">1.</td>
		<td><p>By agreeing to this form, I hereby consent to disclosure of the information collected by 
		United Way of Athens Limestone County under my application to release to the agency or person that is relevant for the purpose of providing assistance for my disaster needs. </p>
		</td>
		</tr>
		<tr>
		<td style="width:25px">2.</td>
		<td> <p>By agreeing to this form, I hereby authorize the agency or person to release any information maintained by the agency or person relevant and necessary for the purpose of providing assistance 
		for my disaster caused needs. </p> 
		</td>
		</tr>
		<tr>
		<td style="width:25px">3.</td>
		<td> <p>I further understand that the release of information does not guarantee that assistance will be provided, but that without the information my case cannot be presented to agencies or persons 
		needed to help with clean up and recovery. </P>
		</td>
		</tr>
		</table>

		<ul>
					<li class="section_break">
					</li>
					<li id="damage_form_disclosure_agree">
					<span>
						<input type="checkbox" name="agree" id="agree" value="0" class="checkbox">
						<label class="choice" for="agree">I have read and agree to consent to disclosure of the information collected .</label>
						</span>
					</li>
					<li class="buttons">
						<input type="hidden" name="form_disclosure" value="disclosure_agree">
						<input id="submitForm" class="button_text" type="submit" name="submit" value="Continue" >
						<input class="button_text" type="button" id="cancel" value="Cancel" onclick="history.go(-1);">	
					</li>
					
				</ul>

		   </form>	
</div>		   
<div class="footer">
		Designed by Athens State University
	</div>
	</div>

</body>
</html>