<?php 
    include('server.php');
    session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }

    $query = 'SELECT o.*,u.UserEmail ,s.ShowName , t.ShowDateTime ,SUM(z.Price) AS TotalPrice FROM 
    (((((booking o JOIN bookingdetail d ON o.BookingID = d.BookingID) JOIN seatforshow h ON d.SeatForShowID = h.SeatForShowID) 
    JOIN user u ON o.UserID = u.UserID) JOIN zoneforshow z ON h.ZoneForShowID = z.ZoneForShowID) JOIN showinfo s ON z.ShowID = s.ShowID) JOIN
    showtime t ON o.showtimeID = t.ShowtimeID WHERE o.Status = 1 GROUP BY o.BookingID;';
    $result =  mysqli_query($con,$query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Booking | WayToCon Staff</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "stafforder.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js" ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com/" >
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</head>
<body>
<?php include_once('staffheader.php'); ?>
    
    <div class="h5 text-center mb-5 mt-5"> All Event Booking </div>
    <div class="ordertable">
        <div class="card mt-2">
                <div class="text-center mt-3">
                <a href="staffallevent.php" role="button" class="btn btn-outline-secondary btn-sm active">Not Purchase</button></a>
                <a href="staffallevent-purchase.php"><button type="button" class="btn btn-outline-secondary btn-sm">Purchase</button></a>
                <a href="staffallevent-cancel.php"><button type="button" class="btn btn-outline-secondary btn-sm">Cancel</button></a>
                </div>
                
                <div class="card-body">
                    <table class="table table-striped" id="datatablesSimple">
                        <thead>
                        <th class="text-center">ID</th>
                        <th class="text-center">Ordertime</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Show</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Change Status</th>
                        <th class="text-center">Cancel</th>
                        </thead>
                        
                        <tbody>
                        <?php while($row = mysqli_fetch_array($result)) { 
                            $status = $row['Status'];
                        ?>
                            <tr>
                                <td ><?=$row['BookingID']?></td>
                                <td><?=$row['BookedDateTime']?></td>
                                <td width ="100"><?=$row['UserEmail']?></td>
                                <td><?=$row['ShowName']?><br><?=$row['ShowDateTime']?></td>
                                <td><?=number_format($row['TotalPrice'],2)?></td>
                                <td><?php 
                                    if($status == 1) echo "<b style='color:orange;'>Not Purchase</b>";
                                    if($status == 2) echo "<b style='color:blue;'>Purchase</b>";
                                    if($status == 0) echo "<b style='color:red;'>Cancel</b>";
                                ?></td>
                                <td><a href="staffdetailbook.php?id=<?=$row['BookingID']?>" class="btn btn-info btn-sm">Detail</a></td>
                                <td><a href="updatebook.php?id=<?=$row['BookingID']?>" class="btn btn-warning btn-sm" onclick="confirmchange(this.href);return false;">Change</a></td>
                                <td> <a href="cancelbook.php?id=<?=$row['BookingID']?>" class="btn btn-danger btn-sm" onclick="confirmcancel(this.href);return false;">Cancel</a> </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        
                    </table>
                </div>
        </div>
    </div>
        
    
    
</body>
</html>

<script> 
function confirmcancel(page){
    var agree = confirm('Are you sure to cancel this booking?');
    if(agree)
    {
        window.location = page;
    }
}

function confirmchange(page){
    var agree = confirm('Are you sure to change payment status of this booking?');
    if(agree)
    {
        window.location = page;
    }
}

</script>