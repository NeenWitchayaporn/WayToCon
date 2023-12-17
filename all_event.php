<?php
include('server.php');

mysqli_query($con, "SET SESSION group_concat_max_len = 1000000;");

$eventquery = "SELECT * FROM showinfo s LEFT JOIN location l ON s.LocationID = l.LocationID
LEFT JOIN typeofshow typ ON s.TypeID = typ.TypeID ORDER BY s.ShowID";

$result = mysqli_query($con, $eventquery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WayToCon Staff</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel="stylesheet" href="all_event.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <?php include_once('staffheader.php'); ?>
    <div class="container">
        <div class="h5 text-center mb-5 mt-5"> All Events </div>
        <table class="table table-striped">
            <tr class="table-secondary">
                <th>Show ID</th>
                <th>Event Name</th>
                <th>Location Name</th>
                <th>Poster</th>
                <th>Show Type</th>
                <th>Show Dates</th>
                <th>Sale Date</th>
                <th>Zone Names</th>
                <th>Zone Prices</th>
                <th>Type of Zones</th>
                <th>Add Zone</th>
                <th>Delete</th>
            </tr>
            <?php while($row = mysqli_fetch_array($result)) { ?>
                <tr>
                       <td><?=$row['ShowID']?></td>
                       <td><?=$row['ShowName']?></td>
                       <td><?=$row['LocationName']?></td>
                       <td class='text-center'><img src='image/<?=$row['Poster']?>' alt='Poster' height='100'></td>
                       <td class='text-center'><?=$row['TypeName']?></td>
                       <td class='text-center'>
                            <?php 
                            $dt = "SELECT * FROM showtime WHERE ShowID = '".$row['ShowID']."'";
                            $dtres = mysqli_query($con, $dt);
                            while($row1 = mysqli_fetch_array($dtres)) { ?>
                                <?=$row1['ShowDateTime']?><br>
                            <?php } ?>
                        </td>
                        <td><?=$row['SaleDate']?></td>
                        <td>
                        <?php 
                            $zone = "SELECT * FROM zoneforshow WHERE ShowID = '".$row['ShowID']."' ORDER BY ZoneForShowID";
                            $zoneres = mysqli_query($con, $zone);
                            while($row2 = mysqli_fetch_array($zoneres)) { ?>
                                <?=$row2['ZoneForShowName']?><br>
                            <?php } ?>
                        </td>
                        <td>
                        <?php 
                            $zprice = "SELECT * FROM zoneforshow WHERE ShowID = '".$row['ShowID']."' ORDER BY ZoneForShowID";
                            $zpriceres = mysqli_query($con, $zprice);
                            while($row3 = mysqli_fetch_array($zpriceres)) { ?>
                                <?=$row3['Price']?><br>
                            <?php } ?>
                        </td>
                        <td>
                        <?php 
                            $ztype = "SELECT * FROM zoneforshow h JOIN zone z ON z.ZoneID = h.ZoneID JOIN zonetype t ON z.ZoneTypeID = t.ZoneTypeID WHERE h.ShowID = '".$row['ShowID']."'";
                            $ztyperes = mysqli_query($con, $ztype);
                            while($row4 = mysqli_fetch_array($ztyperes)) { ?>
                                <?=$row4['ZoneTypeName']?><br>
                            <?php } ?>
                        </td>
                        <td class='text-center'><a class='edit_event mt=1' href='zone_perevent.php?id=<?=$row['ShowID']?>'>Add New Zone</a></td>
                        <td class='text-center'><a class='delete_event mt=1' href='deleteevent.php?id=<?=$row['ShowID']?>' onclick='confirmdel(this.href);return false;'>Delete</a></td>
                 </tr>
            <?php } ?>

        </table>

        <a class='add_event mt=1' href="staff_create_new_event.php">Add New Event</a>
    </div>
</body>

</html>


<script>
    function confirmdel(page) {
        var agree = confirm('Are you sure to delete this event?');
        if (agree) {
            window.location = page;
        }
    }
</script>

