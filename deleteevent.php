<?php 
    include('server.php');
    
    if (isset($_GET['id'])) {
        $showID = $_GET['id'];
    
        $deleteZoneSql = "DELETE FROM zoneforshow WHERE ShowID = '$showID'";
        $deleteZoneResult = mysqli_query($con, $deleteZoneSql);
        
        if (!$deleteZoneResult) {
            die('Error: ' . mysqli_error($con));
        }
        
        $deleteTimeSql = "DELETE FROM showtime WHERE ShowID = '$showID'";
        $deleteTimeResult = mysqli_query($con, $deleteTimeSql);
        
        if (!$deleteTimeResult) {
            die('Error: ' . mysqli_error($con));
        }
        
        $deleteEventSql = "DELETE FROM showinfo WHERE ShowID = '$showID'";
        $deleteEventResult = mysqli_query($con, $deleteEventSql);
        
        if (!$deleteEventResult) {
            die('Error: ' . mysqli_error($con));
        }
        else {
            echo "<script> alert('Delete Event Successfully');</script>";
            echo "<script>window.location='all_event.php';</script>";
        }
    }
?>
