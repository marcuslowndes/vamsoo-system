<!--Id card view-->
<div class="jumbotron">
	<?php echo validation_errors(); ?>
	<?php echo form_open('officials/'.$card['Card_Id']); ?>
	<table class="table table-hover">
		<thead>
			<tr class="table-primary" >
        		<th scope="col"> <h4><?= $title ?></h4> </th>
				<th scope="col"> &nbsp; </th>
				<th scope="col"> <h4>Edit</h4> </th>
			</tr>
		</thead>
		<tr>
			<th class="table-primary" style="width: 10rem;" scope="row"> Card Id </th>
			<td> <?php echo $card['Card_Id']; ?> </td>
			<td> &nbsp; </td>
		</tr>
		<tr>
			<th class="table-primary" scope="row"> Official Id </th>
			<td> <?php echo $official['Official_Id']; ?> </td>
			<td> &nbsp;</td>
		</tr>
		<tr>
			<th class="table-primary" scope="row"> Title </th>
			<td> <?php echo $official_titles['Title']; ?> </td>
			<td>
				<select class="custom-select" style="" name="title">
					<option selected="">Select a Title</option>
					<option value="1">Mr</option>
					<option value="2">Mrs</option>
					<option value="3">Ms</option>
					<option value="4">Dr</option>
				</select>
			</td>
		</tr>
		<tr>
			<th class="table-primary" scope="row"> Surname </th>
			<td> <?php echo $official['Surname']; ?> </td>
			<td> <input type="text" class="form-control" name="surname" placeholder="Change Surname (Max 32 Chars)"> </td>
		</tr>
		<tr>
			<th class="table-primary" scope="row"> Forename </th>
			<td> <?php echo $official['Forename']; ?> </td>
			<td> <input type="text" class="form-control" name="forename" placeholder="Change Forename (Max 32 Chars)"> </td>
		</tr>
		<tr>
			<th class="table-primary" scope="row"> Card Status </th>
			<td> <?php echo $card_status['Status']; ?> </td>
			<td>
				<select class="custom-select" style="" name="status">
					<option selected="">Change Status</option>
					<option value="1">Valid</option>
					<option value="2">Expired</option>
					<option value="3">Cancelled</option>
				</select>
			</td>
		<tr>
			<th class="table-primary" scope="row"> Sport </th>
			<td> <?php echo $sport['Sport_Name']; ?> </td>
			<td> &nbsp; </td>
		</tr>
		</tr>
		<tr>
			<th class="table-primary" scope="row"> Role </th>
			<td> <?php echo $role['Role_Name']; ?> </td>
			<td> &nbsp; </td>
		</tr>
		<tr>
			<th class="table-primary" scope="row"> Expires On </th>
			<td> <?php echo $card['Expiry_Date']; ?> </td>
			<td> &nbsp; </td>
		</tr>
		<tr>
			<td> &nbsp;</td>
			<td> &nbsp;</td>
			<td> <button type="submit" style="width:100%" class="btn btn-primary">Submit</button> </td>
		</tr>
	</table>
	<?php echo form_close(); ?>
</div>