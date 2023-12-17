<?php
include('server.php');

$venuequery = 'SELECT l.LocationID, l.LocationName, z.ZoneID, zo.ZoneTypeName, z.ZoneCapacity, GROUP_CONCAT(s.SeatNo) AS SeatNumbers, GROUP_CONCAT(s.SeatRow) AS SeatRows
               FROM location l
               LEFT JOIN zone z ON l.LocationID = z.LocationID
               LEFT JOIN seat s ON z.ZoneID = s.ZoneID
               LEFT JOIN zonetype zo ON zo.ZonetypeID = z.ZonetypeID
               GROUP BY l.LocationID, z.ZoneID
               ORDER BY l.LocationID, z.ZoneID, zo.ZonetypeID, s.SeatID';
$result = mysqli_query($con, $venuequery);

// Check if the form is submitted
if (isset($_POST['add_seat'])) {
    $zoneID = $_POST['zone_id'];
    $seatNumber = $_POST['seat_number'];
    $seatRow = $_POST['seat_row'];

    // Insert the seat into the database
    $insertQuery = "INSERT INTO seat (ZoneID, SeatNo, SeatRow) VALUES ('$zoneID', '$seatNumber', '$seatRow')";
    mysqli_query($con, $insertQuery);

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
    <title>staff_create_new_venue</title>
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
        <form action="newseat.php" method="POST">
            <div class="center">
                <h1>Add Seats</h1>

                <h2>Seat Number and Seat Row</h2>
                <img src="https://cdn-icons-png.flaticon.com/128/57/57055.png"
                    data-src="https://cdn-icons-png.flaticon.com/128/57/57055.png" alt="Down filled triangular arrow "
                    title="Down filled triangular arrow " width="30" height="30" class="lzy lazyload--done"
                    srcset="https://cdn-icons-png.flaticon.com/128/57/57055.png 4x">

                <div class="box">
                    <select id="zone_id" name="zone_id">
                        <option value="">Select Zone</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $locationID = $row['LocationID'];
                            $locationName = $row['LocationName'];
                            $zoneID = $row['ZoneID'];
                            $zoneType = $row['ZoneTypeName'];
                            $zoneCapacity = $row['ZoneCapacity'];
                            $seatNumbers = explode(',', $row['SeatNumbers']);
                            $seatRows = explode(',', $row['SeatRows']);

                            echo "<option value='$zoneID'>$locationName | Zone: $zoneID | Zone Type: $zoneType | Capacity: $zoneCapacity | Seat Numbers: " . implode(',', $seatNumbers) . " | Seat Rows: " . implode(',', $seatRows) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="box">
                    <input type="text" id="seat_number" name="seat_number" placeholder="Seat Number" required />
                </div>

                <div class="box">
                    <input type="text" id="seat_row" name="seat_row" placeholder="Seat Row" required />
                </div>

                <div class="box">
                    <input type="submit" name="add_seat" value="Add Seat" />
                    <br />
                    <a href="all_venue.php" class="cancel_staff"><span>Cancel</span></a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>