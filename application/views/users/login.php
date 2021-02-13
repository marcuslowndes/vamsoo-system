<!--Login Form-->
<br>
<div class="jumbotron">
	<h2 class="text-center"> <?= $title ?> </h2> <br>
	<h3 class="text-center"> <?= $subtitle ?> </h3> <br>

	<?php echo validation_errors(); ?>
	<?php echo form_open('users/login'); ?>

	<!--div class="row">
		<div class="col-md-4 col-md-offset-4">
			<h1 class="text-center"><></h1-->
			<div class="form-group">
				<input type="text" class="form-control" name="username" placeholder="Enter Username" required autofocus>
			</div>

			<div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Enter Password" required autofocus>
			</div>
			<button class="btn btn-primary btn-lg btn-block" type="submit">Log In</button>
		<!--/div>
	</div-->
	<?php echo form_close(); ?>
</div>
<br><br><br>