<!--Event Authorisations view-->
<br>
<div class="jumbotron">
	<h3 class="text-center"> <?= $title ?> </h3>
	<br>
	<table class="table table-hover">
	    <thead>
	        <tr class="table-primary" >
	            <th scope="col">Card ID</th>
	            <th scope="col">Official Name</th>
	            <th scope="col">Role</th>
	            <th scope="col" style="width: 50px;">Delete</th>
	        </tr>
	    </thead>
	    <tbody>

	        <?php  // Cycle through all rows in event table, alternate row colour, and echo data in table rows
	        $i = 0;
	        foreach($cardevents as $cardevent) :
	            if($i % 2 === 0){
	                $table_colour = 'table-secondary';
	            } else {
	                $table_colour= 'table-light';
	            }
	        ?>
	        <tr class="<?php echo $table_colour ?>"  id="<?php echo $event['Event_Id']; ?>">

			<?php  // Cycle through card table and echo id
			if ($cardevent['Event_Id'] == $event['Event_Id']) {
			  $cardevent_id = $cardevent['Event_Id'];
	          $i++;
			  foreach ($cards as $card) {
				if ($card['Card_Id'] == $cardevent['Card_Id']){
				  echo "<th scope='row'>".$card['Card_Id']."</th>";

				  // Cycle through official table to get full name
				  foreach ($officials as $official) {
					if ($card['Official_Id'] == $official['Official_Id']){

					  // cycle through title table and echo title and full name
					  foreach($official_titles as $official_title){ 
						if ($official_title['Title_Id'] == $official['Title_Id']){
						  echo "<td>".$official_title['Title']." ".$official['Forename']." ".$official['Surname']."</td>";

						  //cycle through role table and echo name
						  foreach($roles as $role){ 
							if ($role['Role_Id'] == $official['Role_Id']){
							echo "<td>".$role['Role_Name']."</td>";
							?>
							<td>
			                    <a class="btn btn-danger" style="" href="<?php echo site_url('/events/delete/'.$event['Event_Id'].'/'.$cardevent['Card_Event_Id']); ?>">
			                    	🗑 <!--Waste Basket Emoji-->
			                    </a>
			            	</td>
							<?php 
							}
						  }
						}
					  }
					}
				  }
				}
			  }
			}
            ?>
            	
	        </tr>
	        <?php endforeach; ?>

	        <tr class="table-primary" >
	            <th>&nbsp;</th>
	            <td><a class="btn btn-secondary" style="" href="<?php echo site_url('/events/add/'.$event['Event_Id']); ?>">
                        Authorise Another Card
                    </a>
                </td><td>&nbsp;</td><td>&nbsp;</td>
	        </tr>
	    </tbody>
	</table>
</div>
<br><br><br>