<?php
include('server.php');

// Check if the form is submitted
if (isset($_POST['add_zone'])) {
    $locationID = $_POST['location_id'];
    $zoneTypeID = $_POST['zone_type_id'];
    $zoneCapacity = $_POST['zone_capacity'];

    // Check if the provided ZoneTypeID exists in the zonetype table
    $zoneTypeCheckQuery = "SELECT * FROM zonetype WHERE ZoneTypeID = $zoneTypeID";
    $zoneTypeCheckResult = mysqli_query($con, $zoneTypeCheckQuery);
    if (mysqli_num_rows($zoneTypeCheckResult) > 0) {
        // Insert the zone into the database
        $insertQuery = "INSERT INTO zone (LocationID, ZonetypeID, ZoneCapacity) VALUES ('$locationID', '$zoneTypeID', '$zoneCapacity')";
        mysqli_query($con, $insertQuery);

        // Redirect to a success page or perform any other desired actions
        header('Location: all_venue.php');
        exit();
    } else {
        // ZoneTypeID does not exist in zonetype table
        echo "Invalid Zone Type ID. Please select a valid Zone Type.";
    }
}

// Query to fetch locations
$locationQuery = "SELECT * FROM location";
$locationResult = mysqli_query($con, $locationQuery);

// Query to fetch zone types
$zoneTypeQuery = "SELECT * FROM zonetype";
$zoneTypeResult = mysqli_query($con, $zoneTypeQuery);
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
    <style>
        input[type="radio"] {
            display: none;
        }

        .zone-type-button {
            display: inline-block;
            padding: 8px 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
            width: fit-content;
        }

        .zone-type-button.selected {
            background-color: #ccc;
        }
    </style>
</head>

<body>
    <?php include_once('staffheader.php'); ?>
    <div class="container">
        <form action="newzone.php" method="POST">
            <div class="center">
                <h1>Add New Zone</h1>

                <div class="box">
                    <select id="location_id" name="location_id" required>
                        <option value="">Select Location</option>
                        <?php
                        while ($locationRow = mysqli_fetch_assoc($locationResult)) {
                            $locationID = $locationRow['LocationID'];
                            $locationName = $locationRow['LocationName'];
                            echo "<option value='$locationID'>$locationName</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="box">
                    <span>Zone Type</span>
                    <?php
                    while ($zoneTypeRow = mysqli_fetch_assoc($zoneTypeResult)) {
                        $zoneTypeID = $zoneTypeRow['ZoneTypeID'];
                        $zoneTypeName = $zoneTypeRow['ZoneTypeName'];
                        echo "<label><input type='radio' name='zone_type_id' value='$zoneTypeID' required hidden>
                            <span class='zone-type-button' onclick='selectZoneType(this)'>$zoneTypeName</span></label>";
                    }
                    ?>
                </div>

                <div class="box">
                    <input type="number" id="zone_capacity" name="zone_capacity" placeholder="Zone Capacity" required />
                </div>

                <div class="box">
                    <input type="submit" name="add_zone" value="Add Zone" />
                    <br />
                    <a href="all_venue.php" class="cancel_staff"><span>Cancel</span></a>
                </div>
            </div>
        </form>
    </div>

    <script>
        function selectZoneType(button) {
            var radio = button.parentNode.querySelector('input[type="radio"]');
            var allButtons = document.querySelectorAll('.zone-type-button');

            if (radio.checked) {
                radio.checked = false;
                button.classList.remove('selected');
            } else {
                for (var i = 0; i < allButtons.length; i++) {
                    allButtons[i].classList.remove('selected');
                }

                radio.checked = true;
                button.classList.add('selected');
            }
        }
    </script>
</body>

</html>