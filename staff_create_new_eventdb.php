<?php
include('server.php');

$errors = array();

if (isset($_POST['event_name']) && isset($_FILES['cover_image']) && isset($_FILES['zone_image'])) {
    $ShowName = mysqli_real_escape_string($con, $_POST['event_name']);
    $ShowType = mysqli_real_escape_string($con, $_POST['show_type']);
    $EventDetail = mysqli_real_escape_string($con, $_POST['event_detail']);
    $SaleDate = mysqli_real_escape_string($con, $_POST['sale_date']);
    $LimitOfTickets = mysqli_real_escape_string($con, $_POST['limit_of_tickets']);
    $Location = mysqli_real_escape_string($con, $_POST['location']);
    $zones = isset($_POST['zone_name']) ? $_POST['zone_name'] : array();
    $zonePrices = isset($_POST['zone_price']) ? $_POST['zone_price'] : array();
    $zoneTypes = isset($_POST['zone_type']) ? $_POST['zone_type'] : array();
    $zoneSeats = isset($_POST['zone_seats']) ? $_POST['zone_seats'] : array();
    $showDates = $_POST['show_date'];


    var_dump($zones);
    var_dump($zonePrices);
    var_dump($zoneTypes);
    var_dump($zoneSeats);
    if (empty($ShowName)) {
        $errors[] = "Please input the event name";
    }
    if (empty($ShowType)) {
        $errors[] = "Please input the show type";
    }
    if (empty($EventDetail)) {
        $errors[] = "Please input the event detail";
    }
    if (empty($SaleDate)) {
        $errors[] = "Please input the sale date";
    }
    if (empty($LimitOfTickets)) {
        $errors[] = "Please input the limit of tickets";
    }
    if (empty($Location)) {
        $errors[] = "Please select a location";
    }

    // Check if the ShowType exists in typeofshow table
    $checkTypeQuery = "SELECT TypeID FROM typeofshow WHERE TypeName = '$ShowType'";
    $checkTypeResult = mysqli_query($con, $checkTypeQuery);

    if (!$checkTypeResult || mysqli_num_rows($checkTypeResult) === 0) {
        $errors[] = "Invalid show type";
    } else {
        $showTypeRow = mysqli_fetch_assoc($checkTypeResult);
        $ShowType = $showTypeRow['TypeID']; // Update the value of ShowType with the existing TypeID
    }

    // Check if the Location exists in the location table
    $checkLocationQuery = "SELECT LocationID FROM location WHERE LocationName = '$Location'";
    $checkLocationResult = mysqli_query($con, $checkLocationQuery);

    if (!$checkLocationResult || mysqli_num_rows($checkLocationResult) === 0) {
        $errors[] = "Invalid location";
    } else {
        $locationRow = mysqli_fetch_assoc($checkLocationResult);
        $LocationID = $locationRow['LocationID'];

        $cover_image = $_FILES['cover_image'];
        $zone_image = $_FILES['zone_image'];
        $cover_image_name = $cover_image['name'];
        $zone_image_name = $zone_image['name'];
        $cover_image_temp_name = $cover_image['tmp_name'];
        $zone_image_temp_name = $zone_image['tmp_name'];
        $cover_image_folder = "image/" . $cover_image_name;
        $zone_image_folder = "image/" . $zone_image_name;

        if (move_uploaded_file($cover_image_temp_name, $cover_image_folder) && move_uploaded_file($zone_image_temp_name, $zone_image_folder)) {
            $sql = "INSERT INTO showinfo (ShowName, TypeID, SaleDate, LocationID, Poster, SeatingMap, LimitTicket, Description)
            VALUES ('$ShowName', '$ShowType', '$SaleDate', '$LocationID', '$cover_image_name', '$zone_image_name', '$LimitOfTickets', '$EventDetail')";

            if (mysqli_query($con, $sql)) {
                $showId = mysqli_insert_id($con); // Get the inserted show ID

                if (count($showDates) > 0) {
                    foreach ($showDates as $showDate) {
                        $showDateSql = "INSERT INTO showtime (ShowDateTime, ShowID) VALUES ('$showDate', '$showId')";
                        $showDateResult = mysqli_query($con, $showDateSql);
                    }
                }

                if (count($zones) > 0) {
                    for ($i = 0; $i < count($zones); $i++) {
                        $zoneName = mysqli_real_escape_string($con, $zones[$i]);
                        $zonePrice = mysqli_real_escape_string($con, $zonePrices[$i]);
                        $zoneType = mysqli_real_escape_string($con, $zoneTypes[$i]);
                        $zoneSeat = mysqli_real_escape_string($con, $zoneSeats[$i]);

                        // Check if the ZoneType exists in zonetype table
                        $checkZoneTypeQuery = "SELECT ZoneTypeID FROM zonetype WHERE ZoneTypeName = '$zoneType'";
                        $checkZoneTypeResult = mysqli_query($con, $checkZoneTypeQuery);

                        if (!$checkZoneTypeResult || mysqli_num_rows($checkZoneTypeResult) === 0) {
                            $errors[] = "Invalid zone type for Zone: $zoneName";
                        } else {
                            $zoneTypeRow = mysqli_fetch_assoc($checkZoneTypeResult);
                            $zoneType = $zoneTypeRow['ZoneTypeID']; // Update the value of zoneType with the existing ZoneTypeID

                            $zoneSql = "INSERT INTO zone (LocationID, ZoneTypeID, ZoneCapacity) VALUES ('$LocationID', '$zoneType', '$zoneSeat')";
                            $zoneResult = mysqli_query($con, $zoneSql);

                            if ($zoneResult) {
                                $zoneId = mysqli_insert_id($con); // Get the inserted zone ID
                                $zoneForShowSql = "INSERT INTO zoneforshow (ZoneID, ShowID, Price, ZoneForShowName) VALUES ('$zoneId', '$showId', '$zonePrice', '$zoneName')";
                                $zoneForShowResult = mysqli_query($con, $zoneForShowSql);
                            }
                        }
                    }
                }

                $_SESSION['upload_status'] = 'Add Event Successfully';
                header("Location: all_event.php");
                exit();
            } else {
                die('Error: ' . mysqli_error($con));
            }
        } else {
            $errors[] = "Error! Failed to upload file.";
        }
    }
}

// Display errors
if (count($errors) > 0) {
    foreach ($errors as $error) {
        echo "<script>alert('$error');</script>";
    }
    echo "<script>window.location='staff_create_new_event.php';</script>";
    exit();
}

?>