<?php
include('server.php');

$venuequery = 'SELECT l.*, GROUP_CONCAT(z.ZoneID) AS ZoneIDs, GROUP_CONCAT(zo.ZoneTypeName) AS ZoneTypes, GROUP_CONCAT(z.ZoneCapacity) AS ZoneCapacities, GROUP_CONCAT(s.SeatNo) AS SeatNumbers, GROUP_CONCAT(s.SeatRow) AS SeatRows
               FROM location l
               LEFT JOIN zone z ON l.LocationID = z.LocationID
               LEFT JOIN seat s ON z.ZoneID = s.ZoneID
               LEFT JOIN zonetype zo ON zo.ZonetypeID = z.ZonetypeID
               GROUP BY l.LocationID
               ORDER BY l.LocationID, z.ZoneID, zo.ZonetypeID';
$result = mysqli_query($con, $venuequery);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WayToCon Staff</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel="stylesheet" href="all_venue.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</head>

<body>
    <?php include_once('staffheader.php'); ?>
    <div class="container">
        <div class="h5 text-center mb-5 mt-5"> All Venue </div>
        <table class="table table-striped">
            <tr class="table-secondary">
                <th>Location ID</th>
                <th>Location Name</th>
                <th>Capacity(Seats)</th>
                <th>Location Address</th>
                <th>Zone ID</th>
                <th>Zone Type</th>
                <th>Zone Capacity(Seats)</th>
                <th>Seat Number</th>
                <th>Seat Row</th>
                <th>Delete</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_array($result)) {
                $zoneIDs = explode(',', $row['ZoneIDs']);
                $zoneTypes = explode(',', $row['ZoneTypes']);
                $zoneCapacities = explode(',', $row['ZoneCapacities']);
                $seatNumbers = explode(',', $row['SeatNumbers']);
                $seatRows = explode(',', $row['SeatRows']);
                $maxCount = max(count($zoneIDs), count($zoneTypes), count($zoneCapacities), count($seatNumbers), count($seatRows));

                $zoneCapacityMap = array();
                for ($j = 0; $j < count($zoneIDs); $j++) {
                    $zoneCapacityMap[$zoneIDs[$j]] = $zoneCapacities[$j];
                }
                ?>
                <?php for ($i = 0; $i < $maxCount; $i++) { ?>
                    <tr>
                        <?php if ($i === 0) { ?>
                            <td rowspan="<?= $maxCount ?>">
                                <?= $row['LocationID'] ?>
                            </td>
                            <td rowspan="<?= $maxCount ?>">
                                <?= $row['LocationName'] ?>
                            </td>
                            <td rowspan="<?= $maxCount ?>">
                                <?= $row['Capacity'] ?>
                            </td>
                            <td rowspan="<?= $maxCount ?>">
                                <?= $row['LocationAddress'] ?>
                            </td>
                        <?php } ?>
                        <td>
                            <?= $zoneIDs[$i] ?? '' ?>
                        </td>
                        <td>
                            <?= $zoneTypes[$i] ?? '' ?>
                        </td>
                        <td>
                            <?= $zoneCapacityMap[$zoneIDs[$i]] ?? '' ?>
                        </td>
                        <td>
                            <?= $seatNumbers[$i] ?? '' ?>
                        </td>
                        <td>
                            <?= $seatRows[$i] ?? '' ?>
                        </td>
                        <?php if ($i === 0) { ?>
                            <td rowspan="<?= $maxCount ?>"><a class='delete_staff mt=1'
                                    href="deletevenue.php?id=<?= $row['LocationID'] ?>"
                                    onclick="confirmdel(this.href);return false;">Delete</a></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>

        <a class='add_venue mt=1' href="staff_create_new_venue.php">Add New Venue</a>
        <a class='edit_staff mt=1' href="newzone.php">Add New Zone</a>
        <a class='edit_staff mt=1' href="newseat.php">Add New Seat</a>
        <a class='delete_staff mt=1' href="deletezone.php">Delete Zone</a>
        <a class='delete_staff mt=1' href="deleteseat.php">Delete Seat</a>
    </div>
</body>

</html>


<script>
    function confirmdel(page) {
        var agree = confirm('Are you sure to delete this venue?');
        if (agree) {
            window.location = page;
        }
    }
</script>