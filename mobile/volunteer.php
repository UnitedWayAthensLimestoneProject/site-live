
<?php

require_once("inc/functions.php");
require_once("inc/scripts/database_connection.php");
require_once("inc/scripts/script_functions.php");

?>

<!DOCTYPE html>

<html>

<head>

<?php load_headers(); ?>

<script>
$(function () {
    $('#volunteer_form').w2form({ 
        name   : 'volunteer_form',
        header : 'Volunteer Registration Form',
        url    : 'inc/scripts/add_volunteer.php',
		style  : 'width:100%;max-width:500px;min-width:300px',
        fields: [
            { field: 'first_name', type: 'text', required: true,  html: { caption: 'First Name', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 0 } },
            { field: 'middle_initial', type: 'text', required: true,  html: { caption: 'M.I.', group: '', attr: 'maxlength="1"', span: 5, text: '', page: 0 } },
            { field: 'last_name', type: 'text', required: true,  html: { caption: 'Last Name', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 0 } },
            { field: 'dob', type: 'date', required: true,  html: { caption: 'Date Of Birth', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 0 } },
            { field: 'email', type: 'email', required: true,  html: { caption: 'Email Address', group: '', attr: 'maxlength="100" placeholder="name@email.com"', span: 5, text: '', page: 1 } },
            { field: 'home_phone', type: 'text', required: true,  html: { caption: 'Home Phone', group: '', attr: 'maxlength="15" placeholder="(###) ###-####"', span: 5, text: '', page: 1 } },
            { field: 'cell_phone', type: 'text', required: true,  html: { caption: 'Cell Phone', group: '', attr: 'maxlength="15" placeholder="(###) ###-####"', span: 5, text: '', page: 1 } },
            { field: 'street_address1', type: 'text', required: true,  html: { caption: '</label><div></div></div><div class="w2ui-group-title">Address</div><div class="w2ui-field w2ui-span5 w2ui-required"><label>Street 1', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 2 } },
            { field: 'street_address2', type: 'text', required: false,  html: { caption: 'Street 2', group: '', attr: 'maxlength="50"', span: 5, text: '', page: 2 } },
            { field: 'city', type: 'text', required: true,  html: { caption: 'City', group: '', attr: 'maxlength="50" placeholder="Athens"', span: 5, text: '', page: 2 } },
            { field: 'state', type: 'text', required: true,  html: { caption: 'State', group: '', attr: 'maxlength="2" placeholder="AL"', span: 5, text: '', page: 2 } },
            { field: 'zip_code', type: 'int', required: true,  html: { caption: 'ZIP', group: '', attr: 'maxlength="5" placeholder="#####"', span: 5, text: '', page: 2 } },
            { field: 'occupation', type: 'text', required: true,  html: { caption: '</label><div></div></div><div class="w2ui-group-title">Employement</div><div class="w2ui-field w2ui-span5 w2ui-required"><label>Occupation', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 3 } },
            { field: 'employer', type: 'text', required: false,  html: { caption: 'Employer', group: '', attr: 'maxlength="20"', span: 5, text: '', page: 3 } },
            { field: 'health_limits',  type: 'list', required: true, options: { items: ['Yes', 'No'] },  html: { caption: '</label><div></div></div><div class="w2ui-group-title">Health Limits</div><div class="w2ui-field w2ui-span5 w2ui-required"><label>Do you have any<br>health limitations?', group: '', attr: '', span: 5, text: '', page: 4 } },
            { field: 'health_limits_comment', type: 'textarea', required: false,  html: { caption: 'If So,<br>Please Describe', group: '', attr: 'maxlength="100"', span: 5, text: '', page: 4 } },
            { field: 'affiliated',  type: 'list', required: true, options: { items: ['Yes', 'No'] },  html: { caption: '</label><div></div></div><div class="w2ui-group-title">Affiliations</div><div class="w2ui-field w2ui-span8 w2ui-required"><label>Are you currently affiliated with<br>any disaster relief organizations?', group: '', attr: '', span: 8, text: '', page: 5 } },
            { field: 'affiliated_comment', type: 'textarea', required: false,  html: { caption: 'If So,<br>Please Describe', group: '', attr: 'maxlength="100"', span: 8, text: '', page: 5 } },
            { field: 'limestone', type: 'toggle', required: false,  html: { caption: '</label><div></div></div><div class="w2ui-group-title">Willing To Volunteer in:</div><div class="w2ui-field w2ui-span7"><label>Limestone County', group: '', attr: '', span: 7, text: '', page: 6 } },
            { field: 'neighbor', type: 'toggle', required: false,  html: { caption: 'Neighboring Counties', group: '', attr: '', span: 7, text: '', page: 6 } },
            { field: 'anywhere', type: 'toggle', required: false,  html: { caption: 'Anywhere in Alabama', group: '', attr: '', span: 7, text: '', page: 6 } },
            { field: 'emer_first_name', type: 'text', required: false,  html: { caption: '</label><div></div></div><div class="w2ui-group-title">Emergency Contact</div><div class="w2ui-field w2ui-span7"><label>First Name', group: '', attr: 'maxlength="20"', span: 7, text: '', page: 6 } },
            { field: 'emer_last_name', type: 'text', required: false,  html: { caption: 'Last Name', group: '', attr: 'maxlength="20"', span: 7, text: '', page: 6 } },
            { field: 'emer_relationship', type: 'text', required: false,  html: { caption: 'Relationship', group: '', attr: 'maxlength="20"', span: 7, text: '', page: 6 } },
            { field: 'emer_phone', type: 'text', required: false,  html: { caption: 'Emergency Contact Phone', group: '', attr: 'maxlength="15" placeholder="(###) ###-####"', span: 7, text: '', page: 6 } },
 			<?php $start_page = 7;  $cpage = list_skills2($start_page); ?>
            { field: 'special_skills',  type: 'list', required: true, options: { items: ['Yes', 'No'] },  html: { caption: 'Do you have any Skills<br>that are not listed?', group: '', attr: 'maxlength="20"', span: 7, text: '', page: <?php echo $cpage ?> } },
            { field: 'special_skills_comment', type: 'textarea', required: false,  html: { caption: 'If So,<br>Please Describe', group: '', attr: 'maxlength="20"', span: 5, text: '', page: <?php echo $cpage ?> } },

			],
		record: { 
			form_id		  : 'submit_register_new_volunteer',
		},
        actions: {
            'Previous': function() {
			
				if(this.page-1 >= <?php echo $start_page?>){
					this.header = "Select Skills";
				} else {
					this.header = "Volunteer Registration Form";
				}
 
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
				w2ui['volunteer_form'].resize();
				
           },
           'Next': function(event) {
				var page_count = <?php echo $cpage; ?>;

				if(this.page+1 >= <?php echo $start_page?>){
					this.header = "Select Skills";
				} else {
					this.header = "Volunteer Registration Form";
				}

				if(this.page < page_count){
					this.goto(this.page+1);
				}
				if(this.page == page_count){
					$('button[name="Next"]',$(this)[0].box).hide();
					$('button[name="Submit Application"]',$(this)[0].box).show();				
				}
				$('button[name="Previous"]',$(this)[0].box).show();
				w2ui['volunteer_form'].resize();
				
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

function volunteer_form() {
	$('#first_page').hide();
	$('#disclosure').hide();
	$('#volunteer_form').show();
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
	<span>
		<center>
				<img src="inc/images/united_kid.png" alt="Get Involved" style="width:90%;max-width:300px" class="center"></p> <!-- picture -->
				
				<h3>GIVE AN HOUR. GIVE A SATURDAY. GIVE YOUR BEST.</h3> <!-- Header 2 style -->
				<!-- paragraph -->
				<p>The United Way is working to advance the common good by focusing on education, income and health: the building blocks for a good life. But we can't do it alone. We need the heads, hands and hearts of committed people like you to help us. </p>
				<br>Sign up now to volunteer with the United Way of Athens-Limestone County:</p><br><br><a class="button" href="javascript:disclosure_form();">Volunteer Registration Form </a>	<br><br>
		</center>
	</span>
	</div>
	
	<div id="volunteer_form" style="display:none"></div>	
	
	<div id="disclosure" style="display:none">
				<h3>Code of Conduct</h3>
				<p>No volunteer or paid staff member shall:</p>
				<table id="codeofconducttable">
					<tr>
						<td style="width:25px">a.</td>
						<td><p>Authorize the use of or use for the benefit or advantage of any person, the name, emblem, endorsement, services, or property of the United Way.</p></td>
					</tr>
					<tr>
						<td>b.</td>
						<td><p>Accept or seek, on behalf of himself or any other person, any financial advantage or gain of other than nominal value which may be offered as a result of the volunteer's or paid staff's affiliation with the United Way.</p></td>
					</tr>
					<tr>
						<td>c.</td>
						<td><p>Publicly utilize United Way in connection with the promotion of partisan politics, religious matters, or positions on any issue not in conformity with the official position of the United Way.</p></td>
					</tr>
					<tr>
						<td>d.</td>
						<td><p>Disclose any confidential United Way information that is available solely as a result of the volunteer's or paid staff member's affiliation with the United Way to any person not authorized to receive such information, or use to the disadvantage of the United Way any such confidential information, without the express authorization of the United Way.</p></td>
					</tr>
					<tr>
						<td>e.</td>
						<td><p>Knowingly take any action or make any statement intended to influence the conduct of the United Way in such a way as to confer any financial benefit on any person, corporation, or entity in which the individual has a significant interest or affiliation.</p></td>
					</tr>
					<tr>
						<td>f.</td>
						<td><p>Operate or act in any manner that is contrary to the best interests of the United Way.</p></td>
					</tr>
				</table>
				<p>In the event that the volunteer's or paid staff obligation to operate in the best interests of the United Way conflicts with the interests of any organization in which the individual has a financial interest or an affiliation, the individual shall disclose such conflict to the United Way upon becoming aware of it, shall absent himself or herself from the room during deliberations on the matter, and shall refrain from participating in any decisions or voting in connection with the matter.</p><br>
	<a class="button" href="javascript:volunteer_form();">I have read and agree with the Code of Conduct (shown above).</a><br><br><a class="button" href="index.php">I do not agree.</a><br><br>

	</div>


	</span>
	</div>

	<?php main_menu(); ?>
	
	</center>

</body>

</html>