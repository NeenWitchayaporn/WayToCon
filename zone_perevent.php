<?php
include('server.php');

if (isset($_GET['id'])) {
    $showID = $_GET['id'];

    // Delete all data associated with the Location ID
    $showQuery = "SELECT * FROM showinfo s JOIN zone z ON z.LocationID = s.LocationID WHERE s.ShowID = '$showID' AND z.ZoneID NOT IN
    (SELECT ZoneID FROM zoneforshow WHERE s.ShowID = '$showID')";
    $zoneResult = mysqli_query($con, $showQuery);

}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Zone</title>
    <link rel="stylesheet" href="newseat.css">
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include_once('staffheader.php'); ?>
    <div class="container">
        <form action='zone_perevent_db.php' method="POST">
            <div class="center">
                <h1>Add New Zone</h1>

                <div class="box">
                    <span>Show ID</span>
                    <input id="show" name="show" type="text" value="<?=$showID?>" readonly>
                 </div>

                <div class="box">
                    <select id="show_id" name="show_id" required>
                        <span>Select Zone</span>
                        <?php
                        while ($zone = mysqli_fetch_assoc($zoneResult)) {
                            $zoneID = $zone['ZoneID'];
                            echo "<option value='$zoneID' check='' >Zone - $zoneID </option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="box">
                    <span>Add Price</span>
                    <input type='number' step="0.01" min='0' name='add_price' required/>
                </div>
                <div class="box">
                    <span>Add Zone For Show Name</span>
                    <input type='text' name='add_zoneforshowname' required/>
                </div>

                <div class="box">
                    <input type="submit" name="add_zone" value="Add Zone" />
                    <br />
                    <a href="all_event.php" class="cancel_staff"><span>Cancel</span></a>
                </div>
            </div>
        </form>
</body>

</html>