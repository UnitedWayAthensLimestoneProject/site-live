
<?php

require_once("inc/functions.php");

?>

<!DOCTYPE html>

<html>

<head>

<?php load_headers(); ?>

<script>
$(function () {
    $('#disaster_form').w2form({ 
        name   : 'disaster_form',
        header : 'Disaster Relief Form',
        url    : 'inc/scripts/add_disaster.php',
		style  : 'width:100%;max-width:500px;min-width:300px',
        fields: [
            { field: 'first_name', type: 'text', required: true,  html: { caption: 'First Name', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 0 } },
            { field: 'middle_initial', type: 'text', required: true,  html: { caption: 'M.I.', group: '', attr: 'maxlength="1"', span: 5, text: '', page: 0 } },
            { field: 'last_name', type: 'text', required: true,  html: { caption: 'Last Name', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 0 } },
            { field: 'dob', type: 'date', required: true,  html: { caption: 'Date Of Birth', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 0 } },
            { field: 'email', type: 'email', required: true,  html: { caption: 'Email Address', group: '', attr: 'maxlength="100" placeholder="name@email.com"', span: 5, text: '', page: 0 } },
            { field: 'home_phone', type: 'text', required: true,  html: { caption: 'Home Phone', group: '', attr: 'maxlength="15" placeholder="(###) ###-####"', span: 5, text: '', page: 0 } },
            { field: 'cell_phone', type: 'text', required: true,  html: { caption: 'Cell Phone', group: '', attr: 'maxlength="15" placeholder="(###) ###-####"', span: 5, text: '', page: 0 } },
            { field: 'interview',  type: 'list', required: true, options: { items: ['Yes', 'No'] },  html: { caption: 'Do you have an<br>interview?', group: '', attr: '', span: 6, text: '', page: 1 } },
            { field: 'date_of_interview', type: 'date', required: false,  html: { caption: 'Interview Date', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 1 } },
            { field: 'date_of_event', type: 'date', required: false,  html: { caption: 'Event Date', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 1 } },
            { field: 'pre_add_st1', type: 'text', required: true,  html: { caption: '<b>Pre-Disaster</b><br>Street 1', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 2 } },
            { field: 'pre_add_st2', type: 'text', required: false,  html: { caption: 'Street 2', group: '', attr: 'maxlength="50"', span: 5, text: '', page: 2 } },
            { field: 'pre_add_city', type: 'text', required: true,  html: { caption: 'City', group: '', attr: 'maxlength="50" placeholder="Athens"', span: 5, text: '', page: 2 } },
            { field: 'pre_add_state', type: 'text', required: true,  html: { caption: 'State', group: '', attr: 'maxlength="2" placeholder="AL"', span: 5, text: '', page: 2 } },
            { field: 'pre_add_zip', type: 'int', required: true,  html: { caption: 'ZIP', group: '', attr: 'maxlength="5" placeholder="#####"', span: 5, text: '', page: 2 } },
            { field: 'post_add_st1', type: 'text', required: true,  html: { caption: '<b>Post-Disaster</b><br>Street 1', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 3 } },
            { field: 'post_add_st', type: 'text', required: false,  html: { caption: 'Street 2', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 3 } },
            { field: 'post_add_city', type: 'text', required: true,  html: { caption: 'City', group: '', attr: 'maxlength="20" placeholder="Athens"', span: 5, text: '', page: 3 } },
            { field: 'post_add_state', type: 'text', required: true,  html: { caption: 'State', group: '', attr: 'maxlength="2" placeholder="AL"', span: 5, text: '', page: 3 } },
            { field: 'post_add_zip', type: 'int', required: true,  html: { caption: 'ZIP', group: '', attr: 'maxlength="5" placeholder="#####"', span: 5, text: '', page: 3 } },
            { field: 'health_limits',  type: 'list', required: true, options: { items: ['Yes', 'No'] },  html: { caption: 'Do you have any<br>health limitations?', group: '', attr: '', span: 5, text: '', page: 4 } },
            { field: 'health_limits_comment', type: 'textarea', required: false,  html: { caption: 'If So,<br>Please Describe', group: '', attr: 'maxlength="100"', span: 5, text: '', page: 4 } },
            { field: 'household_income',  type: 'list', required: true, options: { items: [ { id: '0-9,999', text: "$0 - $9,999"}, { id: '10,000-29,999', text: "$10,000 - $29,999"}, { id: '30,000-49,999', text: "$30,000 - $49,999"}, { id: '50,000-69999', text: "$50,000 - $69,999"}, { id: '70,000-89,999', text: "$70,000 - $89,999"}, { id: '90,000-over', text: "$90,000 or more"} ] },  html: { caption: 'Household Income', group: '', attr: '', span: 5, text: '', page: 5 } },
            { field: 'dwelling',  type: 'list', required: true, options: { items: [ { id: 'single_family', text: "Single Family"}, { id: 'Apt/Condo', text: "Apt/Condo"}, { id: 'mobile_home', text: "Mobile Home"} ] },  html: { caption: 'Dwelling', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 5 } },
            { field: 'owner_renter_info',  type: 'list', required: true, options: { items: [ 'owner', 'renter' ] },  html: { caption: 'Own or Rent', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 5 } },
            { field: 'landlord_first_name', type: 'text', required: false,  html: { caption: '<b>Landlord</b><br>First Name', group: '', attr: 'maxlength="20" placeholder="Landlord"', span: 5, text: '', page: 5 } },
            { field: 'landlord_last_name', type: 'text', required: false,  html: { caption: 'Last Name', group: '', attr: 'maxlength="20" placeholder="Landlord"', span: 5, text: '', page: 5 } },
            { field: 'monthly_rent', type: 'money', required: true,  html: { caption: 'Monthly Rent', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 5 } },
            { field: 'monthly_utilities', type: 'money', required: true,  html: { caption: 'Monthly Utilities<br>(owners/renters):', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 5 } },
            { field: 'dwelling_use',  type: 'list', required: true, options: { items: [ { id: 'primary_dwelling', text: "Primary"}, {id: 'secondary_dwelling', text: "Secondary"}, {id: 'business', text: "Business"} ] },  html: { caption: 'How is this<br>dwelling used?', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 5 } },
            { field: 'dwelling_insurance_contents', type: 'toggle', required: true,  html: { caption: 'Insurance on Contents', group: '', attr: '', span: 7, text: '', page: 6 } },
            { field: 'dwelling_insurance_hazzard', type: 'toggle', required: true,  html: { caption: 'Hazzard Insurance', group: '', attr: '', span: 7, text: '', page: 6 } },
            { field: 'dwelling_insurance_structure', type: 'toggle', required: true,  html: { caption: 'Structure Insurance', group: '', attr: '', span: 7, text: '', page: 6 } },
            { field: 'insurance_provider_name', type: 'text', required: false,  html: { caption: '<b>Insurance Provider</b><br>Name', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 6 } },
            { field: 'insurance_provider_phone', type: 'text', required: false,  html: { caption: 'Phone', group: '', attr: 'maxlength="15" placeholder="(###) ###-####"', span: 5, text: '', page: 6 } },
            { field: 'levofdamage',  type: 'list', required: true, options: { items: [ 'destroyed', 'major', 'minor', 'affected', 'inaccessible', 'unknown' ] },  html: { caption: 'Level of damage', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 7 } },
            { field: 'elec_on_off',  type: 'list', required: true, options: { items: [{ id: 0, text: "electricity is OFF"} ,{ id: 1, text: "electricity is ON"} ] },  html: { caption: 'Is the electricity on or off<br>at the location?', group: '', attr: 'maxlength="20"', span: 6, text: '', page: 7 } },
            { field: 'housing_needs',  type: 'list', required: true, options: { items: [{ id: 1, text: "Yes"},{ id: 0, text: "No"}] },  html: { caption: 'Do you have any housing<br>needs due to the disaster?', group: '', attr: 'maxlength="20"', span: 7, text: '', page: 7 } },
            { field: 'housing_need_type',  type: 'list', required: false, options: { items: ['Permanent', 'Temporary'] },  html: { caption: 'What type of housing<br>do you need?', group: '', attr: 'maxlength="20"', span: 6, text: '', page: 7 } },
        ],
		record: { 
			form_id		  : 'submit_disaster_relief',
		},
        actions: {
            'Previous': function() {
			
				if(this.page > 0){
					this.goto(this.page-1);
				}	
				if(this.page==0){
					$('button[name="Previous"]',$(this)[0].box).hide();
				} else {
					$('button[name="Previous"]',$(this)[0].box).show();
				}
				$('button[name="Next"]',$(this)[0].box).show();
				$('button[name="Submit Application"]',$(this)[0].box).hide();	
				w2ui['disaster_form'].resize();
            },
           'Next': function() {
				var page_count = 7;
				if(this.page < page_count){
					this.goto(this.page+1);
				}
				if(this.page == page_count){
					$('button[name="Next"]',$(this)[0].box).hide();
					$('button[name="Submit Application"]',$(this)[0].box).show();				
				}
				$('button[name="Previous"]',$(this)[0].box).show();
				w2ui['disaster_form'].resize();
           },
            'Submit Application': function () {
				$('button[name="Next"]',$(this)[0].box).show();
				$('button[name="Previous"]',$(this)[0].box).show();
				$('button[name="Submit Application"]',$(this)[0].box).hide();				
                this.save();
 			},
        },
		onRender: function(event) {
			event.onComplete = function () {
				$('button[name="Previous"]',$(this)[0].box).hide();
				$('button[name="Submit Application"]',$(this)[0].box).hide();
			}
		}, 
		onSave: function(event) {
			event.onComplete = function () {
				w2alert("Application Submitted.", "Submitted.", function () { window.location = "index.php" });
			}
		},
    });
});

$(document).ready(function() {
	//window.onload = resize_w2ui();
});

function disaster_form() {
	$('#first_page').hide();
	$('#disclosure').hide();
	$('#disaster_form').show();
	resize_w2ui();
}

function disclosure_form() {
	$('#first_page').hide();
	$('#disclosure').show();
	resize_w2ui();
}

</script>


</head>

<body>

	<center>
	
	<div id="main">
	<span>
		
	<div id="first_page">
	<p> <img src="inc/images/helping_hand1.png" alt="Disaster Assistance" style="width:50%;max-width:300px" class="center"></p>
	<h3>Disaster Assistance</h3> <!-- Header 1 style -->
	<h4>If you have been affected by a disaster<br>we are here to help!</h4> <!-- Header 2 style -->
	<!-- paragraph -->
	<p>Disasters can happen at any moment, in any form. Severe storms, flooding, tornadoes, fire and many other disasters can leave communities and families devastated. In the event of a disaster we are here to help. If you have been affected by a disaster and need assistance, please click the link below to fill out a disaster relief form. <br></p>

	<a class="button" href="javascript:disclosure_form();">Disaster Relief Form</a><br>
	
	</div>	
	
	<div id="disaster_form" style="display:none"></div>	
	
	<div id="disclosure" style="display:none">
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
	<a class="button" href="javascript:disaster_form();">I have read and agree to consent to disclosure of the information collected .</a><br><br><a class="button" href="index.php">I do not agree.</a><br><br>

	</div>


	</span>
	</div>

	<?php main_menu(); ?>
	
	</center>

</body>

</html>