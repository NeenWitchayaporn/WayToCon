<?php
include('server.php');

if (isset($_GET['id'])) {
    $locationId = $_GET['id'];

    // Delete all data associated with the Location ID
    $deleteSeatQuery = "DELETE s FROM seat s JOIN zone z ON s.ZoneID = z.ZoneID WHERE z.LocationID = '$locationId'";
    mysqli_query($con, $deleteSeatQuery);

    $deleteZoneQuery = "DELETE FROM zone WHERE LocationID = '$locationId'";
    mysqli_query($con, $deleteZoneQuery);

    $deleteLocationQuery = "DELETE FROM location WHERE LocationID = '$locationId'";
    mysqli_query($con, $deleteLocationQuery);

    // Redirect back to the page displaying all venues
    header('Location: all_venue.php');
}
?>