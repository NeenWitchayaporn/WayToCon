<?php
include('server.php');

$error = array();

if (isset($_POST['create_new_venue'])) {
    $LocationName = mysqli_real_escape_string($con, $_POST['location_name']);
    $LocationAddress = mysqli_real_escape_string($con, $_POST['location_address']);
    $LocationCapacity = mysqli_real_escape_string($con, $_POST['location_capacity']);

    if (empty($LocationName)) {
        array_push($error, "Please input the venue name");
    }
    if (empty($LocationAddress)) {
        array_push($error, "Please input the venue address");
    }
    if (empty($LocationCapacity)) {
        array_push($error, "Please input the venue capacity");
    }

    $location_query = "SELECT * FROM location WHERE LocationName = '$LocationName'";
    $query = mysqli_query($con, $location_query);
    $result = mysqli_fetch_assoc($query);

    if ($result) {
        if ($result['LocationName'] == $LocationName) {
            array_push($error, "This location name is already in use");
        }
    }

    if (count($error) == 0) {
        $sql = "INSERT INTO location (LocationName, LocationAddress, Capacity)
                VALUES ('$LocationName', '$LocationAddress', '$LocationCapacity')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $locationId = mysqli_insert_id($con); // Get the inserted location ID

            if (isset($_POST['show_type']) && isset($_POST['zonecapacity'])) {
                $zoneTypes = $_POST['show_type'];
                $zoneCapacities = $_POST['zonecapacity'];

                $totalZones = count($zoneTypes);

                if ($totalZones > 0) {
                    for ($i = 0; $i < $totalZones; $i++) {
                        $zoneType = mysqli_real_escape_string($con, $zoneTypes[$i]);
                        $zoneCapacity = mysqli_real_escape_string($con, $zoneCapacities[$i]);

                        if (empty($zoneType) || empty($zoneCapacity)) {
                            array_push($error, "Please fill in all zone details");
                            break;
                        }

                        $zoneTypeID = getZoneTypeID($con, $zoneType);

                        if ($zoneTypeID == 0) {
                            array_push($error, "Invalid zone type");
                            break;
                        }

                        $zoneSql = "INSERT INTO zone (LocationID, ZoneTypeID, ZoneCapacity)
                                    VALUES ('$locationId', '$zoneTypeID', '$zoneCapacity')";
                        $zoneResult = mysqli_query($con, $zoneSql);

                        // if ($zoneResult) {
                        //     $zoneID = mysqli_insert_id($con); // Get the inserted zone ID

                        //     // Retrieve the seat information for the current zone
                        //     for ($j = 0; $j < count($seatNumbers); $j++) {
                        //         $seatNumber = mysqli_real_escape_string($con, $seatNumbers[$j]);
                        //         $seatRow = mysqli_real_escape_string($con, $seatRows[$j]);

                        //         if (!empty($seatNumber) && !empty($seatRow)) {
                        //             $seatSql = "INSERT INTO seat (ZoneID, SeatNo, SeatRow)
                        //                         VALUES ('$zoneID', '$seatNumber', '$seatRow')";
                        //             $seatResult = mysqli_query($con, $seatSql);

                        //             if (!$seatResult) {
                        //                 array_push($error, "Error: " . mysqli_error($con));
                        //                 break;
                        //             }
                        //         }
                        //     }
                        // } else {
                        //     array_push($error, "Error: " . mysqli_error($con));
                        //     break;
                        // }
                    }
                } else {
                    array_push($error, "Please provide at least one zone");
                }
            }

            if (count($error) == 0) {
                echo "<script> alert('Add Venue Successfully');</script>";
                echo "<script>window.location='all_venue.php';</script>";
            }
        } else {
            array_push($error, "Error: " . mysqli_error($con));
        }
    } else {
        echo "<script> alert('Error! Please Try Again');</script>";
        echo "<script>window.location='staff_create_new_venue.php';</script>";
    }
}

// Helper function to retrieve ZoneTypeID based on ZoneTypeName
function getZoneTypeID($con, $zoneTypeName)
{
    $zoneType = mysqli_real_escape_string($con, $zoneTypeName);
    $zoneTypeQuery = "SELECT ZoneTypeID FROM zonetype WHERE ZoneTypeName = '$zoneType'";
    $zoneTypeResult = mysqli_query($con, $zoneTypeQuery);
    $zoneTypeRow = mysqli_fetch_assoc($zoneTypeResult);

    if ($zoneTypeRow) {
        return $zoneTypeRow['ZoneTypeID'];
    }

    return 0;
}
?>