<div class="form-group">
	<label for="official">Select An Official</label>
	<select class="custom-select" style="margin-bottom: 1rem" name="official">
		<option value="0">Add New Official</option>
		<?php
		  /*foreach ($cards as $card) {
			if ($card['Card_Id'] == $cardevent['Card_Id']){

			  // Cycle through official table to get full name
			  foreach ($officials as $official) {
				if ($card['Official_Id'] == $official['Official_Id']){

				  // cycle through title table to get title and full name
				  foreach($official_titles as $official_title){ 
					if ($official_title['Title_Id'] == $official['Title_Id']){

					  //cycle through role table and get sport
					  foreach($roles as $role){ 
						if ($role['Role_Id'] == $official['Role_Id']){

						  //cycle through sport to check if official's sport is relevant
						  foreach($sports as $sport){ 
							if ($role['Sport_Id'] == $sport['Sport_Id']
									&& $event['Sport_Id'] == $sport['Sport_Id']){

			  				  echo "<option value='".$card['Card_Id']."'>";

					  		  echo "<td>".$official_title['Title']." ".$official['Forename']." ".$official['Surname']."</td>";
					  		}
			  			  }
						}
					  }
					}
				  }
				}
			  }
			}
		  }*/


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