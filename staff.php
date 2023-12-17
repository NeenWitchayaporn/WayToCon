<?php 

session_start();
    
if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['StaffEmail']);
    header('location:stafflogin.php');
}

if(!isset($_SESSION['StaffEmail'])){
    $_SESSION['message'] = 'You must log in first';
    header('location:stafflogin.php');
}
    include('server.php');
    $bcc = 'SELECT COUNT(BookingID) AS num FROM booking WHERE Status = 0';
    $bps = 'SELECT COUNT(BookingID) AS num FROM booking WHERE Status = 2';
    $bnp = 'SELECT COUNT(BookingID) AS num FROM booking WHERE Status = 1';
    $occ = 'SELECT COUNT(OrderID) AS num FROM giftshoporder WHERE Status = 0';
    $ops = 'SELECT COUNT(OrderID) AS num FROM giftshoporder WHERE Status = 2';
    $onp = 'SELECT COUNT(OrderID) AS num FROM giftshoporder WHERE Status = 1';
    $bccqr =mysqli_query($con,$bcc);
    $bccrs = mysqli_fetch_array($bccqr);
    $bpsqr =mysqli_query($con,$bps);
    $bpsrs = mysqli_fetch_array($bpsqr);
    $bnpqr =mysqli_query($con,$bnp);
    $bnprs = mysqli_fetch_array($bnpqr);

    $occqr =mysqli_query($con,$occ);
    $occrs = mysqli_fetch_array($occqr);
    $opsqr =mysqli_query($con,$ops);
    $opsrs = mysqli_fetch_array($opsqr);
    $onpqr =mysqli_query($con,$onp);
    $onprs = mysqli_fetch_array($onpqr);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WayToCon Staff</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "staff.css">
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
<?php if (isset($_SESSION['message'])): ?>
    <div class='error'>
      <h3>
        <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        ?>
      </h3>
    </div>
  <?php endif ?>

<div class="welcome">
        <h4>Welcome WayToCon Staff</h4>
    </div>
<div class="ordertable">
        <div class="card mt-3">
        <div class="row mt-3">
         <div class="h6 text-center mb-5 mt-2"> Event Booking </div>
            <div class="col-xl-1" ></div>
                            <div class="col-xl-3 col-md-6" >
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Booking (Purchased)<br> [ <b><?=$bpsrs['num']?></b> ]</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="staffallevent-purchase.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Booking (No Purchased)<br> [ <b><?=$bnprs['num']?></b> ]</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="staffallevent.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Booking (Cancel)<br> [ <b><?=$bccrs['num']?></b> ]</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="staffallevent-cancel.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            
        </div></div></div>
<div class="ordertable">
        <div class="card mt-2">
        <div class="row mt-3">
         <div class="h6 text-center mb-5 mt-2"> Giftshop Order </div>
            <div class="col-xl-1" ></div>
                            <div class="col-xl-3 col-md-6" >
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Order (Purchased)<br> [ <b><?=$opsrs['num']?></b> ]</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="staffallorder-purchase.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Order (No Purchased)<br> [ <b><?=$onprs['num']?></b> ]</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="staffallorder.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Order (Cancel)<br> [ <b><?=$occrs['num']?></b> ]</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="staffallorder-cancel.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            
        </div></div></div><br><br>



</body>
</html>