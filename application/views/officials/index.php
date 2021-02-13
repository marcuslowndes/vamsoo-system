<!--Officials-->
<br>
<h2 class="text-center"> <?= $title ?> </h2>
<br>

<table class="table table-hover">
    <thead>
        <tr class="table-primary" >
            <th scope="col">ID</th>
            <th scope="col">Full Name</th>
            <th scope="col">Sport</th>
            <th scope="col">Role</th>
            <th scope="col" style="width: 60px;">ID Card</th>
        </tr>
    </thead>
    <tbody>
        <?php  // Cycle through all rows in Official table and echo ids
            $i = 0;
            foreach($officials as $official) :
                $i++;
                if($i % 2 === 0){
                    $table_colour = 'table-secondary';
                } else {
                    $table_colour= 'table-light';
                }
        ?>

        <tr class="<?php echo $table_colour ?>"  id="<?php echo $official['Official_Id']; ?>">

            <th scope="row"><?php echo $official['Official_Id']; ?></th>

            <?php //Cycle through official table and echo names
            foreach($official_titles as $official_title){ 
                if ($official_title['Title_Id'] == $official['Title_Id']){
                    echo "<td>".$official_title['Title']." ".$official['Forename']." ".$official['Surname']."</td>";
                }
            }
            ?>

            <?php //cycle through role table and sport table and echo names
            foreach($roles as $role){ 
                if ($role['Role_Id'] == $official['Role_Id']){
                    foreach ($sports as $sport) {
                        if ($sport['Sport_Id'] == $role['Sport_Id']){
                            if ($sport['Gender_Id'] == 1) {
                                $gender = "Men's ";
                            } else {
                                $gender = "Women's ";
                            }
                            echo "<td>".$gender.$sport['Sport_Name']."</td>";
                        }
                    }
                    echo "<td>".$role['Role_Name']."</td>";
                }
            }
            ?>

            <!--td>Get WSGB <?php //echo $official['WSGB_Id']; ?></td-->

            <?php //cycle through card table and get card id of official
            foreach($cards as $card) {
                if ($card['Official_Id'] == $official['Official_Id']) { ?>
                <td>
                    <a class="btn" style="background-color: #375a7f; width:100%" href="<?php echo site_url('/officials/'.$card['Card_Id']); ?>">
                        <?php echo $card['Card_Id']; ?>
                    </a>
                </td>
            <?php }} ?>

        </tr>
        <?php endforeach; ?>

        <tr class="table-primary" >
            <th>&nbsp;</th>
            <td> <a class="btn btn-primary" style="background-color: #444" href="<?php echo site_url('/officials/add'); ?>">Add New Official</a> </td>
            <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><!--td>+</td-->
        </tr>
    </tbody>
</table>
<br><br><br>