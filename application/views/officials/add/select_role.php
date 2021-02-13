<div class="form-group">
	<select class="custom-select" style="margin-bottom: 1rem" name="role">
		<option selected="">Select a Role</option>
		<?php
			foreach ($roles as $role) {
				if ($role['Sport_Id'] == $add_data['add_sport']){
					echo '<option value="'.$role['Role_Id'].'">';
					echo $role['Role_Name'];
					echo "</option>";
				}
			}
		?>
	</select>
</div>