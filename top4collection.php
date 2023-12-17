<?php
header('Content-Type: application/json');
include('server.php');

	$sql = "SELECT c.*,SUM(g.ProductPrice * d.Quantity) AS TotalPrice
    FROM ((giftshop g JOIN orderdetail d ON g.ProductID = d.ProductID) JOIN giftshopcollection c 
    ON g.ProductCollectionID = c.ProductCollectionID) JOIN giftshoporder o ON o.OrderID = d.OrderID 
    WHERE (o.Status = 2) GROUP BY c.ProductCollectionID ORDER BY c.ProductCollectionID LIMIT 4;";

	$result = mysqli_query($con,$sql);

	$data = array();
	foreach ($result as $row) {
		$data[] = $row;
	}


	echo json_encode($data);
?>