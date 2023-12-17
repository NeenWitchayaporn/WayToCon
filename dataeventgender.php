<?php
header('Content-Type: application/json');
include('server.php');

	$sql = "SELECT u.UserGender,SUM(z.Price) AS TotalPrice
	FROM (((booking b JOIN bookingdetail d ON b.BookingID = d.BookingID)
    JOIN seatforshow h ON d.SeatForShowID = h.SeatForShowID)
    JOIN zoneforshow z ON h.ZoneForShowID = z.ZoneForShowID) 
    JOIN user u ON b.UserID = u.UserID
	WHERE b.Status = 2
    GROUP BY u.UserGender ORDER BY u.UserGender;";

	$result = mysqli_query($con,$sql);

	$data = array();
	foreach ($result as $row) {
		$data[] = $row;
	}


	echo json_encode($data);
?>