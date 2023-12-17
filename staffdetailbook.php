<?php 
    include('server.php');
    session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }

    // $query = 'SELECT o.*,u.UserEmail ,s.ShowName , t.ShowDateTime ,SUM(z.Price) AS TotalPrice FROM 
    // (((((booking o JOIN bookingdetail d ON o.BookingID = d.BookingID) JOIN seatforshow h ON d.SeatForShowID = h.SeatForShowID) 
    // JOIN user u ON o.UserID = u.UserID) JOIN zoneforshow z ON h.ZoneForShowID = z.ZoneForShowID) JOIN showinfo s ON z.ShowID = s.ShowID) JOIN
    // showtime t ON o.showtimeID = t.ShowtimeID WHERE o.Status = 1 GROUP BY o.BookingID;';
    // $result =  mysqli_query($con,$query);

    if(!isset($_GET['id'])){
        header('location:staffallevent.php');
    }
    // BookingID BookedDateTime UserName UserEmail PaymentMethod ShowName ShowDatetime

    
    $sql = "SELECT * FROM (((booking b JOIN user u on b.UserID = u.UserID) JOIN showtime t ON b.ShowtimeID = t.ShowtimeID) 
    JOIN showinfo s ON t.ShowID = s.ShowID) JOIN paymentmethod p ON b.PaymentMethodID = p.PaymentMethodID
    WHERE BookingID = '".$_GET['id']."'";
    $result =  mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    
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
    
<div class="container">
    <div class="alert alert-info h4 text-center mb-4 mt-5" role="alert">
         Booking Detail Report
    </div>
    <div class="row">
                
    <div class="col">
    <div class="text-left mt-1">
        <b>BookingID&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['BookingID']?> <br>
        <p class="mt-2"><b>Booking Datetime&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['BookedDateTime']?> <br>
        <b>User Name&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['UserFirstName']. ' ' .$row['UserLastName']?> <br>
        <b>User Email&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['UserEmail']?> <br>
        <b>Payment Method&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['PaymentMethodName']?> <br>
        <br>
        <b>Show Name&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['ShowName']?></p>
        <b>Show Time&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['ShowDatetime']?></p>
        <?php
        if((!empty($row['PurchaseDateTime'])) && (!empty($row['PaymentAmount']))): ?>
            <b style="color: blue;">Purchase DateTime&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['PurchaseDateTime']?><br>
            <b style="color: blue;">Payment Amount&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['PaymentAmount']?></p>
        <?php endif ?>
        
    </div>
    

    <table class="table table-bordered">
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Seat</th>
                <th class="text-center">Detail</th>
                <th class="text-center">Price</th>
            </tr>
            
            <?php
                // DetailID SearForShowID (ZoneForShowName NameOnTicket) Price

                $detailqr = "SELECT * FROM (((booking b JOIN bookingdetail d ON b.BookingID = d.BookingID) 
                JOIN seatforshow h ON d.SeatForShowID = h.SeatForShowID) JOIN zoneforshow z ON z.ZoneForShowID = h.ZoneForShowID) 
                JOIN Seat s ON h.SeatID = s.SeatID WHERE b.BookingID = '".$row['BookingID']."' ORDER BY d.detailID";
                $query = mysqli_query($con,$detailqr);
                while($rowdt = mysqli_fetch_array($query)) {
            ?>

          <tr>

            <td class="text-center"><br><b><?=$rowdt['DetailID']?></b></td>    
            <td>
                <br>
                
                    <b>Seat Number : <?=$rowdt['SeatNo']?></b><br>
                    <p style="color: #777777">Row : <?=$rowdt['SeatRow']?> THB</p>
            
            </td>
            <td class="text-center" ><br>
                    <b><?=$rowdt['ZoneForShowName']?></b><br>
                    <p style="color: #777777">Name on Ticket : <?=$rowdt['NameOnTicket']?></p>
            </td>
            
            <td class="text-center">
                <br><p style="color:#9565AE"><?=number_format($rowdt['Price'],2)?> THB</p>
            </td>
            
         </tr>
         
         <?php } 
            $totalqr = "SELECT SUM(z.Price) AS TotalPrice FROM ((booking b JOIN bookingdetail d ON b.BookingID = d.BookingID)
            JOIN seatforshow h ON d.SeatForShowID = h.SeatForShowID) JOIN zoneforshow z ON z.ZoneForShowID = h.ZoneForShowID
            WHERE b.BookingID = '".$row['BookingID']."' GROUP BY b.BookingID";
            $query1 = mysqli_query($con,$totalqr);
            $rowtt = mysqli_fetch_array($query1);
         ?>   
                        

            <tr>

            <td class="text-center" colspan="3" >
                <b>Total Price  :</b>
            </td>
            <td class="text-center">         
                <b style="color: #9565AE"><?=number_format($rowtt['TotalPrice'],2)?> THB</b>
            </td>

            </tr>
                    </table>
                   
                </div>
            </div>
            <br>

            <div class="cartheader mt-3 mr-4">
                    <a class ="btn btn-outline-secondary text-center" href="staffallevent.php">Back</a>    
            </div><br><br><br>
            
        
    </div>
    
        
    
    
</body>
</html>

