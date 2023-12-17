<?php
    session_start();
    include('server.php');
    
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['UserEmail']);
        header('location:userlogin.php');
    }

    if(!isset($_SESSION['UserEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:userlogin.php');
    }

    if((!isset($_GET['id']))){
        $_SESSION['message'] = 'You must book first';
        header('location:index.php');
    }

    if(isset($_GET['id']))
    {
        $sql = "SELECT * FROM (((booking b JOIN user u on b.UserID = u.UserID) JOIN showtime t ON b.ShowtimeID = t.ShowtimeID) 
                JOIN showinfo s ON t.ShowID = s.ShowID) WHERE BookingID = '".$_GET['id']."' ";
    }

    
    $result =  mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Booking - WayToCon</title>
    <link rel="icon" type="image/x-icon" href="image/template.png"/>
    <link rel = "stylesheet" href = "giftshop.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js" ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="container">
    <div class="alert alert-info h4 text-center mb-4 mt-5" role="alert">
         Your Booking 
    </div>
    <div class="row">
                
    <div class="col">
    <div class="text-left mt-1">
        <b>BookingID&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['BookingID']?> <br>
        <p class="mt-2"><b>Booking Datetime&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['BookedDateTime']?> <br>
        <b>User Name&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['UserFirstName']. ' ' .$row['UserLastName']?> <br>
        <br>
        <b>Show Name&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['ShowName']?></p>
        <b>Show Time&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['ShowDateTime']?></p>
    </div>
    

    <table class="table table-bordered">
            <tr>
                <th class="text-center">Detail ID</th>
                <th class="text-center">Seat</th>
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
                    <p style="color: #777777">Row : <?=$rowdt['SeatRow']?><br>
                    Zone : <?=$rowdt['ZoneForShowName']?></p>
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

            <td class="text-center" colspan="2" >
                <b>Total Price  :</b>
            </td>
            <td class="text-center">         
                <b style="color: #9565AE"><?=number_format($rowtt['TotalPrice'],2)?> THB</b>
            </td>

            </tr>
                    </table>
                    
                </div>
            </div>

            <div>
                <h6 class="text-end mt-1">** Please make the payment within 48 hours. **</h6>
            </div>

            <br><br><br>
            
        
    </div>
    
    
</body>
</html>