<div class="form-group">
	<select class="custom-select" style="margin-bottom: 1rem" name="title">
		<?php 
			if ($add_data['add_title'] != "") {
				echo '<option value="'.$add_data['add_title'].'">';
				switch( $add_data['add_title']){
					case 1: echo "Mr</option>"; break;
					case 2: echo "Mrs</option>"; break;
					case 3: echo "Ms</option>"; break;
					case 4: echo "Dr</option>"; break;
				}
			} else {
				echo '<option selected="">Select a Title</option>';
			}
		?>
		<option value="1">Mr</option>
		<option value="2">Mrs</option>
		<option value="3">Ms</option>
		<option value="4">Dr</option>
	</select>
</div>

<div class="form-group">
	<label for="username">Forename</label>
	<input type="text" class="form-control" name="forename" placeholder="John" required autofocus <?php if ($add_data['add_forename'] != "") { echo 'value="'.$add_data['add_forename'].'"'; }?> >
</div>

<div class="form-group">
	<label for="surname">Surname</label>
	<input type="text" class="form-control" name="surname" placeholder="Smith" required autofocus <?php if ($add_data['add_surname'] != "") { echo 'value="'.$add_data['add_surname'].'"'; }?> >
</div>

<?php if (!$add_new_sport){ ?>
<div class="form-group">
	<label for="sport">Select A Sport</label>
	<select class="custom-select" style="margin-bottom: 1rem" name="sport">
	<?php 
		if ($add_data['add_sport'] != "") {
			foreach ($sports as $sport) {
				if ($add_data['add_sport'] == $sport['Sport_Id']){
					if ($sport['Gender_Id'] == 1) {
						$gender = "Men's ";
					} else {
						$gender = "Women's ";
					}
					echo '<option value="'.$add_data['add_sport'].'">'.$gender.$sport['Sport_Name'].'</option>';
				}
			}
		}
	?>
		<option value="0">Add New Sport</option>
	<?php
		foreach ($sports as $sport) {
			echo '<option value="'.$sport['Sport_Id'].'">';
			if ($sport['Gender_Id'] == 1) {
				$gender = "Men's ";
			} else {
				$gender = "Women's ";
			}
			echo $gender.$sport['Sport_Name'];
			echo "</option>";
		}
	?>
	</select>
</div>
<?php } ?>