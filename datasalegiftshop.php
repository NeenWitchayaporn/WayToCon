<?php
header('Content-Type: application/json');
include('server.php');

	$sql = "SELECT YEAR(o.OrderDateTime) AS OrderYear, MONTH(o.OrderDateTime) AS OrderMonth, 
    SUM(g.ProductPrice * d.Quantity) AS TotalPrice FROM (giftshop g JOIN orderdetail d ON g.ProductID = d.ProductID) 
    JOIN giftshoporder o ON o.OrderID = d.OrderID
    WHERE o.Status = 2
    GROUP BY YEAR(o.OrderDateTime), MONTH(o.OrderDateTime)
    ORDER BY YEAR(o.OrderDateTime), MONTH(o.OrderDateTime);";

	$result = mysqli_query($con,$sql);

	$data = array();
	foreach ($result as $row) {
		$data[] = $row;
	}


	echo json_encode($data);
?>