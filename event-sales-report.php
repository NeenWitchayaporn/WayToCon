<?php 
session_start();
if(!isset($_SESSION['StaffEmail'])){
    $_SESSION['message'] = 'You must log in first';
    header('location:stafflogin.php');
}

if(!isset($_SESSION['Role'])){
    $_SESSION['message'] = "You don't have permission";
    header('location:stafflogin.php');
}
    include('server.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Sales | WayToCon Staff</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "stafforder.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js" ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com/" >
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</head>
<body>
<?php include_once('staffheader.php'); ?>
    
    <div class="h5 text-center mb-5 mt-5"> All Event Sales </div>
    <div class="ordertable">
        <div class="card mt-2"><br>
                <div class="mt-2" style="padding-left:30px;">
                    <form name="dt" action="event-sales-report.php" method="POST">
                    <div class="row">
                        <div class="col-sm-2 mr-3">
                            <input type="date" name="d1" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <input type="date" name="d2" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="datatablesSimple">
                        <thead>
                        
                        <th class="text-center">Show ID</th>
                        <th class="text-center">Show</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Total Sales Amount</th>
                        <th class="text-center">Total Quantity Sold</th>
                    
                        </thead>
    

    <?php

    $d1 = $_POST['d1'];
    $d2 = $_POST['d2'];
    $add_date = date('Y/m/d',strtotime($d2."+1 days"));
    if(!(($d1=="") && ($d2=="")))
    {
        echo "<div class='mb-2' style='padding-left:10px;'>Search From $d1 to $d2</div>";
        $query = "SELECT s.*, SUM(z.Price) AS TotalPrice, COUNT(d.DetailID) AS TotalQty 
        FROM ((((showinfo s JOIN showtime t ON s.ShowID = t.ShowID) JOIN booking b ON b.ShowtimeID = t.ShowtimeID) 
        JOIN bookingdetail d ON d.BookingID = b.BookingID) JOIN seatforshow h ON d.SeatForShowID = h.SeatForShowID) 
        JOIN zoneforshow z ON z.ZoneForShowID = h.ZoneForShowID WHERE (b.Status = 2) AND (b.BookedDateTime BETWEEN '$d1' AND '$add_date') 
        GROUP BY s.ShowID ORDER BY s.ShowID";
    }
    else
    {
        $query = "SELECT s.*, SUM(z.Price) AS TotalPrice, COUNT(d.DetailID) AS TotalQty 
        FROM ((((showinfo s JOIN showtime t ON s.ShowID = t.ShowID) JOIN booking b ON b.ShowtimeID = t.ShowtimeID) 
        JOIN bookingdetail d ON d.BookingID = b.BookingID) JOIN seatforshow h ON d.SeatForShowID = h.SeatForShowID) 
        JOIN zoneforshow z ON z.ZoneForShowID = h.ZoneForShowID WHERE (b.Status = 2) GROUP BY s.ShowID ORDER BY s.ShowID";
    }
    $result =  mysqli_query($con,$query);
     while($rowdt = mysqli_fetch_array($result)) {
    ?>
    
    <tr>
        <td class="text-center"><br><b><?=$rowdt['ShowID']?></b></td>    
            <td class="text-center"><img src="image/<?=$rowdt['Poster']?>" width="75px" alt="" class="mt-4 p-2 my-2"></td>
            <td>
                <br>
                
                    <b><?=$rowdt['ShowName']?></b><br>
                    <p style="color: #777777"><?=$rowdt['Description']?> THB</p>
            
            </td>
            <td class="text-center" ><br>
                <p style="color:#F68B63"><?=number_format($rowdt['TotalPrice'],2)?> THB</p>
            </td>
            
            <td class="text-center">
                <br><p style="color:F68B63"><?=$rowdt['TotalQty']?></p>
            </td>
    </tr>

      
    <?php } ?>
                        
        
                        
                    </table>
                </div>
        </div><br><br>
    </div>
        
    
    
</body>
</html>