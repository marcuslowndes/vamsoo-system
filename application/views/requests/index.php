<!--requests-->
<br>
<h2 class="text-center"> <?= $title ?> </h2>
<br>

<table class="table table-hover">
    <thead>
        <tr class="table-primary" >
            <th scope="col">ID</th>
            <th scope="col">Card ID</th>
            <th scope="col">Official</th>
            <th scope="col">Venue</th>
            <th scope="col">Request Type</th>
            <th scope="col">Timestamp</th>
            <th scope="col" style="width: 50px;">Authorisation</th>
        </tr>
    </thead>
    <tbody>

        <?php  // Cycle through all rows in request table, alternate row colour, and echo data in table rows
        $i = 0;
        foreach($requests as $request) :
            $i++;
            if($i % 2 === 0){
                $table_colour = 'table-secondary';
            } else {
                $table_colour= 'table-light';
            }
        ?>
        <tr class="<?php echo $table_colour ?>"  id="<?php echo $request['Request_Id']; ?>">

            <th scope="row"><?php echo $request['Request_Id']; ?></th>

            <?php  //cycle through card table and official table and echo id and offical full name
            foreach ($cards as $card) {
              if ($card['Card_Id'] == $request['Card_Id']){
                echo "<td>".$card['Card_Id']."</td>";
                // Cycle through official table and echo full name
                foreach ($officials as $official) {
                  if ($card['Official_Id'] == $official['Official_Id']){
                    // cycle through title table and echo title
                    foreach($official_titles as $official_title){ 
                      if ($official_title['Title_Id'] == $official['Title_Id']){
                        echo "<td>".$official_title['Title']." ".$official['Forename']." ".$official['Surname']."</td>";
                      }
                    }
                  }
                }
              }
            }
            ?>

            <?php  //cycle through value table and area table and echo names
            foreach($venues as $venue){ 
                if ($venue['Venue_Id'] == $request['Venue_Id']){
                    foreach ($areas as $area) {
                        if ($area['Area_Id'] == $venue['Area_Id']){
                            echo "<td>".$venue['Venue_Name'].", ".$area['Area_Name']."</td>";
                        }
                    }
                }
            }
            ?>

            <td scope="row">
            <?php
            if($request['Request_Type_Id'] == 1){
                echo "Enter";
            } else{
                echo "Leave";
            }
            ?>
            </td>

            <td scope="row">
                <?php
                date_default_timezone_set('Europe/London');
                echo date('d/m/y H:i', strtotime($request['Timestamp']));
                ?>
            </td>

            <?php 
            if($request['Authorisation']){
                echo "<td scope='row' style='background-color:#00bc8c'>Approved</td>";
            } else {
                echo "<td scope='row' style='background-color:#E74C3C'>Denied</td>";
            }
            ?>

        </tr>    
        <?php endforeach; ?>

        <tr class="table-primary" >
            <th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td>
            <td> <a class="btn btn-primary" style="background-color: #444" href="<?php echo site_url('/requests/add'); ?>">Request To Enter A Venue</a> </td>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
    </tbody>
</table>
<br><br><br><br><br><br>