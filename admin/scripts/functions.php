<?php
	// NOTE: before php 5.1.0 the valid date range was limited from
	// 01-01-1970 to 01-19-2038 on some systems (e.g. Windows). this
	// function corrects the year value in pre-1970 dates, if necessary,
	// so that the proper date can be stored in the mySQL database. 
	function date_reformat($date_string) {
		// year must be in YYYY format
		if(!preg_match("/\\d{4}/", $date_string, $match)) return null;
		
		//convert the year to an integer
		$year = intval($match[0]);
		
		// if the year is after 1970, proceed normally
		if($year >= 1970) return date("Y-m-d", strtotime($date_string)); 
		
		// if OS is Windows and not Unix or Mac, update year
		if(stristr(PHP_OS, "WIN") && !stristr(PHP_OS, "DARWIN")) {
			
			// calculate the difference between 1975 and the year
			$diff = 1975 - $year;
			// calculate the new year value
			$new_year = $year + $diff;
			// replace the year with the new year value and convert to date
			$new_date = date("Y-m-d", strtotime(str_replace($year, $new_year, $date_string)));
			// return the date with the correct year
			return str_replace($new_year, $year, $new_date);
		}
		// if OS is not Windows and is either Unix or Mac, return original date
		return date("Y-m-d", strtotime($date_string));
	}

	// **ASU2016** function to calculate age from date_of_birth 
	function ageCalculator($dob) {
		if(!empty($dob)) {
			$birthdate = new DateTime($dob);
			$today = new DateTime('today');
			$age = $birthdate->diff($today)->y;
			return $age;
		}else{
			return 0;
		}
	}
	
	
	// Creates a list of skills with checkboxes.
	// Pulls the list of active skills from the skills table and
	// aranges them by skill groups, sorted alphabetically.
	// Function can be called from any php file at the location
	// where the skill list should be included.
	function list_skills() {
		$query=("SELECT * " .
				"  FROM skill " .
				" WHERE enabled = 1 " .
				"   AND skill_group IS NOT NULL " .
				"ORDER BY skill_group, skill_name");
	
		$result=mysql_query($query)
			or die ("Unable to make the query: " . mysql_error());
	
		$new_group = NULL;	// used to show group headings
		$grp_cnt = 1;		// counts the different groups
		$row_cnt = 0;		// counts the number of checkboxes per column, determines when a new column is started
	
		while ($row=mysql_fetch_array($result)) {
			$group = @$row["skill_group"];
			$s_id = @$row["skill_id"];
			$s_name = @$row["skill_name"];
		
			if (is_null($new_group)) {
				$new_group = $group;
				echo <<<EOD
						<li>
							<label class="description" for="group{$grp_cnt}">{$group}</label>
							<span>
							
EOD;
			} elseif (($new_group != $group) && ($row_cnt < 17)) {
				$new_group = $group;
				$grp_cnt++;
				echo <<<EOD
							</span>
						</li>
						<li>
							<label class="description" for="group{$grp_cnt}">{$group}</label>
							<span>
							
EOD;
			} elseif (($new_group != $group) && ($row_cnt >= 17)) {
				$new_group = $group;
				$grp_cnt++;
				$row_cnt = 0;
			echo <<<EOD
							</span>
						</li>
					</ul>
				</td>
				<td>
					<ul>
						<li>
							<label class="description" for="group{$grp_cnt}">{$group}</label>
							<span>
							
EOD;
			}
		
			echo <<<EOD
								<input type="checkbox" class="checkbox required" name="checkbox[]" title="Select at least one skill" value="{$s_id}" />
								<label class="choice">{$s_name}</label>
EOD;
			$row_cnt++;
		}
	} // end function list_skills()
	
	
	
	// Creates a list of skills with checkboxes appropriately checked.
	// Pulls the list of active skills from the skills table and
	// aranges them by skill groups, sorted alphabetically. Places a
	// checkmark in the boxes, as appropriate.
	// Function can be called from any php file at the location
	// where the populated skill list should be included.
	function populate_skills($skill_array) {
	
		$skill_query = ("SELECT * " .
				  "  FROM skill " .
				  " WHERE enabled = 1 " .
				  "   AND skill_group IS NOT NULL " .
				  "ORDER BY skill_group, skill_name");
	
		$skill_result = mysql_query($skill_query)
			or die ("Unable to make the query: " . mysql_error());
	
		$new_group = NULL;	// used to show group headings
		$grp_cnt = 1;		// counts the different groups
		$row_cnt = 0;		// counts the number of checkboxes per column, determines when a new column is started
	
		while ($skill_row = mysql_fetch_array($skill_result)) {
			$group = $skill_row['skill_group'];
			$s_id = $skill_row['skill_id'];
			$s_name = $skill_row['skill_name'];
			
			if (in_array($s_id, $skill_array)) {
				$checked = 'checked="checked"';
			} else {
				$checked = '';
			}
		
			if (is_null($new_group)) {
				$new_group = $group;
				echo <<<EOD
						<li>
							<label class="description" for="group{$grp_cnt}">{$group}</label>
							<span>
							
EOD;
			} elseif (($new_group != $group) && ($row_cnt < 17)) {
				$new_group = $group;
				$grp_cnt++;
				echo <<<EOD
							</span>
						</li>
						<li>
							<label class="description" for="group{$grp_cnt}">{$group}</label>
							<span>
							
EOD;
			} elseif (($new_group != $group) && ($row_cnt >= 17)) {
				$new_group = $group;
				$grp_cnt++;
				$row_cnt = 0;
			echo <<<EOD
							</span>
						</li>
					</ul>
				</td>
				<td>
					<ul>
						<li>
							<label class="description" for="group{$grp_cnt}">{$group}</label>
							<span>
							
EOD;
			}
		
			echo <<<EOD
								<input type="checkbox" class="checkbox required" name="checkbox[]" title="Select at least one skill" value="{$s_id}" {$checked}>
								<label class="choice">{$s_name}</label>
EOD;
			$row_cnt++;
		}
	} // end function populate_skills()
?>