<?php
include('server.php');

$venuequery = 'SELECT l.LocationID, l.LocationName, z.ZoneID, zo.ZoneTypeName, z.ZoneCapacity, s.SeatID, s.SeatNo, s.SeatRow
               FROM location l
               LEFT JOIN zone z ON l.LocationID = z.LocationID
               LEFT JOIN seat s ON z.ZoneID = s.ZoneID
               LEFT JOIN zonetype zo ON zo.ZonetypeID = z.ZonetypeID
               ORDER BY l.LocationID, z.ZoneID, zo.ZonetypeID, s.SeatID';
$result = mysqli_query($con, $venuequery);

// Check if the form is submitted for seat deletion
if (isset($_POST['delete_seat'])) {
    $seatID = $_POST['seat_id'];
    echo "Seat ID: $seatID<br>"; // Debug output

    // Get the seat details
    $getSeatQuery = "SELECT * FROM seat WHERE SeatID = '$seatID'";
    $seatResult = mysqli_query($con, $getSeatQuery);
    $seat = mysqli_fetch_assoc($seatResult);

    // Delete the seat from the database
    $deleteSeatQuery = "DELETE FROM seat WHERE SeatID = '$seatID'";
    mysqli_query($con, $deleteSeatQuery);

    // Delete the corresponding seat number and seat row
    $seatNo = $seat['SeatNo'];
    $seatRow = $seat['SeatRow'];
    echo "Seat No: $seatNo<br>"; // Debug output
    echo "Seat Row: $seatRow<br>"; // Debug output

    $deleteSeatNumberQuery = "UPDATE seat SET SeatNo = '' WHERE SeatNo = '$seatNo' AND SeatID = '$seatID'";
    mysqli_query($con, $deleteSeatNumberQuery);

    $deleteSeatRowQuery = "UPDATE seat SET SeatRow = '' WHERE SeatRow = '$seatRow' AND SeatID = '$seatID'";
    mysqli_query($con, $deleteSeatRowQuery);

    // Redirect to a success page or perform any other desired actions
    header('Location: all_venue.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Seat</title>
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
        <form action="deleteseat.php" method="POST">
            <div class="center">
                <h1>Delete Seat</h1>
                <div class="box">
                    <label for="seat_id">Select Seat:</label>
                    <select id="seat_id" name="seat_id">
                        <option value="">Select Seat</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $locationID = $row['LocationID'];
                            $locationName = $row['LocationName'];
                            $zoneID = $row['ZoneID'];
                            $zoneType = $row['ZoneTypeName'];
                            $zoneCapacity = $row['ZoneCapacity'];
                            $seatID = $row['SeatID'];
                            $seatNo = $row['SeatNo'];
                            $seatRow = $row['SeatRow'];
                            echo "<option value='$seatID'>$locationName | Zone: $zoneID | Zone Type: $zoneType | Seat No: $seatNo | Seat Row: $seatRow</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="box">
                    <input type="submit" name="delete_seat" value="Delete Seat" />
                    <br />
                    <a href="all_venue.php" class="cancel_staff"><span>Cancel</span></a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>