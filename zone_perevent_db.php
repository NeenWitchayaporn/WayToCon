<?php
include('server.php');

if (isset($_POST['add_zone'])) {
    $showID = $_POST['show'];
    $zone_id = $_POST['show_id'];
    $add_price = $_POST['add_price'];
    $add_zoneforshowname = $_POST['add_zoneforshowname'];

    // Insert the seat into the database
    $insertQuery = "INSERT INTO zoneforshow (ZoneID, ShowID, Price, ZoneForShowName) VALUES ('$zone_id', '$showID','$add_price', '$add_zoneforshowname')";
    mysqli_query($con, $insertQuery);

    // Redirect to a success page or perform any other desired actions
    header('Location: all_event.php');
    exit();
}
?>