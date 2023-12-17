<?php
header('Content-Type: application/json');
include('server.php');

	$sql = "SELECT YEAR(b.BookedDateTime) AS BookYear, MONTH(b.BookedDateTime) AS BookMonth,
	SUM(z.Price) AS TotalPrice
	FROM ((booking b JOIN bookingdetail d ON b.BookingID = d.BookingID)
    JOIN seatforshow h ON d.SeatForShowID = h.SeatForShowID)
    JOIN zoneforshow z ON h.ZoneForShowID = z.ZoneForShowID
	WHERE b.Status = 2
    GROUP BY YEAR(b.BookedDateTime), MONTH(b.BookedDateTime)
    ORDER BY YEAR(b.BookedDateTime), MONTH(b.BookedDateTime);";

	$result = mysqli_query($con,$sql);

	$data = array();
	foreach ($result as $row) {
		$data[] = $row;
	}


	echo json_encode($data);
?>