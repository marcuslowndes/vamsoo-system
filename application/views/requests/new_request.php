<div class="form-group">
	<label for="official">Select An Official</label>
	<select class="custom-select" style="margin-bottom: 1rem" name="official">
		<option value="0">Add New Official</option>
		<?php

		foreach ($officials as $official) {
			// cycle through title table and echo title
			foreach($official_titles as $official_title){ 
				if ($official_title['Title_Id'] == $official['Title_Id']){
					echo '<option value="'.$official['Official_Id'].'">';
					echo $official_title['Title']." ".$official['Forename']." ".$official['Surname'];
					echo "</option>";
				}
			}
		}
		?>
	</select>
</div>


<div class="form-group">
	<label for="venue">Select A Venue</label>
	<select class="custom-select" style="margin-bottom: 1rem" name="venue">
		<?php
		foreach ($venues as $venue) {
            foreach ($areas as $area) {
                if ($area['Area_Id'] == $venue['Area_Id']){
					echo '<option value="'.$venue['Venue_Id'].'">';
					echo $venue['Venue_Name'].', '.$area['Area_Name'];
					echo "</option>";
				}
			}
		}
		?>
	</select>
</div>


<div class="form-group">
	<label for="request">Select Request Type</label>
    <div class="custom-control custom-radio">
      <input type="radio" id="requestenter" name="request" class="custom-control-input" checked="" value="1">
      <label class="custom-control-label" for="requestenter">Enter Venue</label>
    </div>
    <div class="custom-control custom-radio">
      <input type="radio" id="requestleave" name="request" class="custom-control-input" value="2">
      <label class="custom-control-label" for="requestleave">Leave Venue</label>
    </div>
</div> <br>


<div class="form-group">
	<label for="date">Day of Request</label>
	<input type="text" class="form-control" name="date" placeholder="YYYY/MM/DD" required autofocus>
</div> <br>


<div class="form-group">
	<label for="time">Time of Request</label>
	<input type="text" class="form-control" name="time" placeholder="HH:MM" required autofocus>
</div>
<br>