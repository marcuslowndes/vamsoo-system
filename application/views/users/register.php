<!--Register Form-->
<div class="jumbotron">
	<h2> <?= $title ?> </h2>
	<br>
	<?php echo validation_errors(); ?>
	<?php echo form_open('users/register'); ?>

	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username" placeholder="j.smith1" required autofocus>
	</div>

	<div class="form-group">
		<label for="email">Email</label>
		<input type="email" class="form-control" name="email" placeholder="example@vamsoo.com" required autofocus>
	</div>

	<div class="form-group">
		<label for="password">Set Password</label>
		<input type="password" class="form-control" name="password" placeholder="password" required autofocus>
	</div>

	<div class="form-group">
		<label for="password2">Confirm Password</label>
		<input type="password" class="form-control" name="password2" required autofocus>
	</div>
	<div class="form-group">
		<label for="isadmin">Select Privilege Level</label>
		<select class="custom-select" name="isadmin">
			<option value="1">Security</option>
			<option value="2">Manager</option>
			<option value="3">Admin</option>
		</select>
	</div>

	<!--div class="form-check disabled">
		<label for="isadmin" class="form-check-label">
			<input type="checkbox" class="form-check-input">
			Allow admin privileges for account?
		</label>
	</div-->
	<br>
	<button type="submit" class="btn btn-primary btn-lg">Submit</button>

	<?php echo form_close(); ?>
</div>
