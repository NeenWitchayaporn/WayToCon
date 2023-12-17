<?php
header('Content-Type: application/json');
include('server.php');

	$sql = "SELECT o.*, SUM(z.Price) AS TotalPrice
	FROM (((((showinfo s JOIN showtime t ON s.ShowID = t.ShowID) 
			JOIN booking b ON b.ShowtimeID = t.ShowtimeID) 
		JOIN bookingdetail d ON d.BookingID = b.BookingID) 
		JOIN seatforshow h ON d.SeatForShowID = h.SeatForShowID) 
		JOIN zoneforshow z ON z.ZoneForShowID = h.ZoneForShowID) 
		JOIN typeofshow o ON o.TypeID = s.TypeID
	WHERE (b.Status = 2) GROUP BY o.TypeID ORDER BY o.TypeID;";

	$result = mysqli_query($con,$sql);

	$data = array();
	foreach ($result as $row) {
		$data[] = $row;
	}


	echo json_encode($data);
?>