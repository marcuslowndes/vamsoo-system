<!--Events-->
<br>
<h2 class="text-center"> <?= $title ?> </h2>
<br>

<table class="table table-hover">
    <thead>
        <tr class="table-primary" >
            <th scope="col">Event Name</th>
            <th scope="col">Sport</th>
            <th scope="col">Venue</th>
            <th scope="col">Area</th>
            <th scope="col" style="width: 50px;">Authorisations</th>
        </tr>
    </thead>
    <tbody>

        <?php  // Cycle through all rows in event table, alternate row colour, and echo data in table rows
        $i = 0;
        foreach($events as $event) :
            $i++;
            if($i % 2 === 0){
                $table_colour = 'table-secondary';
            } else {
                $table_colour= 'table-light';
            }
        ?>
        <tr class="<?php echo $table_colour ?>"  id="<?php echo $event['Event_Id']; ?>">

            <th scope="row"><?php echo $event['Event_Name']; ?></th>

            <?php  //cycle through sport table and echo name
            foreach ($sports as $sport) {
                if ($sport['Sport_Id'] == $event['Sport_Id']){
                    if ($sport['Gender_Id'] == 1) {
                        $gender = "Men's ";
                    } else {
                        $gender = "Women's ";
                    }
                    echo "<td>".$gender.$sport['Sport_Name']."</td>";
                }
            }
            ?>

            <?php  //cycle through value table and area table and echo names
            foreach($venues as $venue){ 
                if ($venue['Venue_Id'] == $event['Venue_Id']){
                    echo "<td>".$venue['Venue_Name']."</td>";

                    foreach ($areas as $area) {
                        if ($area['Area_Id'] == $venue['Area_Id']){
                            echo "<td>".$area['Area_Name']."</td>";
                        }
                    }
                }
            } ?>

            <td>
                <a class="btn" style="background-color: #375a7f; width:100%" href="<?php echo site_url('/events/'.$event['Event_Id']); ?>">
                    <?php
                    $j = 0;
                    foreach($cardevents as $cardevent) {
                        if ($cardevent['Event_Id'] == $event['Event_Id']) {
                            $j++;
                        }
                    }
                    echo $j;
                    ?>
                </a>
            </td>

        </tr>    
        <?php endforeach; ?>

        <tr class="table-primary" >
            <th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
    </tbody>
</table>
<br><br><br>