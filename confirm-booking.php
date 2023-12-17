<?php
    session_start();
    include('server.php');
    

    if(!isset($_SESSION['UserEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:userlogin.php');
    }


    if(isset($_SESSION['UserEmail'])) {
        $useremail = $_SESSION['UserEmail'];
    }
?>

<?php 
    $showid = $_GET['id'];
    $roundselect = $_GET['show_time'];
    $zoneselect = $_GET['zone'];
    $seatforshowid = $_GET['seatforshowid'];

    $seatIds = explode(",", $seatforshowid);
    $quantity = count( $seatIds);
    
    $all = "SELECT * FROM showinfo s JOIN location l ON s.locationID = l.LocationID WHERE s.ShowID = '$showid'";
    $query1 = mysqli_query($con,$all);
    $row1 = mysqli_fetch_array($query1);

    $showtime = "SELECT * FROM showinfo s JOIN showtime t ON s.ShowID = t.ShowID WHERE t.ShowTimeID = '$roundselect' ORDER BY t.ShowDateTime";
    $query2 = mysqli_query($con,$showtime);
    $row2 = mysqli_fetch_array($query2);

    $zone = "SELECT * FROM showinfo s JOIN zoneforshow h ON s.ShowID = h.ShowID WHERE h.ZoneForShowID = '$zoneselect'";
    $query3 = mysqli_query($con,$zone);
    $row3 = mysqli_fetch_array($query3);

    $seat = "SELECT * FROM ((showtime t JOIN showinfo s ON t.ShowID = s.ShowID) JOIN zoneforshow h ON s.ShowID = h.ShowID) JOIN seatforshow f ON h.ZoneForShowID = f.ZoneForShowID JOIN seat z ON f.SeatID = z.SeatID WHERE s.ShowID = '$showid' AND t.ShowTimeID = $roundselect AND h.ZoneforShowID =  $zoneselect ";
    $query4 = mysqli_query($con,$seat);
    $row4 = mysqli_fetch_array($query4);
    

    $user = "SELECT * FROM user u WHERE u.UserEmail = '$useremail'";
    $query6 = mysqli_query($con,$user);
    $row6 = mysqli_fetch_array($query6);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking - WayToCon</title>
    <link rel="icon" type="image/x-icon" href="image/template.png"/>
    <link rel = "stylesheet" href = "confirm-booking.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js" ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="container" style = "margin-top: 30px">
    <div class="h4 text-left mtb-4 "><b> Confirm Booking </b></div>
        <form action="booking_db.php" method="POST">
            <div class="row">
                <div class="col-4">
                    <div class="text-left mt-2" style =" margin-top :20px;"><b>Membership Information</b></div><br>
                    <table class="orderconfi" style = "padding-right : 0%; width : 1062px; height:12px;">
                        <tr>
                            <td>
                                <div class="form-group ">
                                <p class="name">Name : <?= $row6['UserFirstName'] ?> <?= $row6['UserLastName'] ?></p>
                                <input type="hidden" name="name" value="<?= $row6['UserFirstName'] ?> <?= $row6['UserLastName'] ?>">
                            </div>
                        </td>
                    </tr>
                    </table>
                </div>
                    <br>
                <div class="col-4">    
                    <div class="text-left mt-3"><b>Payment Method</b></div><br>
                    <table class="orderconfi mt-1">
                    <tr>
                        <td>
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="truemoney"><input class="form-check-input" type="radio" name="paymentmethod" value=1 checked="">
                                    <span> TrueMoney Wallet</span></label>
                                </div>
                                <br>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="promptpay"><input class="form-check-input" type="radio" name="paymentmethod" value=2>
                                    <span> PromptPay</span></label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </table>
                </div>
            </div>
                <br>
            <div class="col-lg-6">
            <div class="text-left mt-3"><b>Summary</b></div>
            <br>
            <table class="orderconfi mt-5">
            <tbody>
                <div class="text-left mt-3" style = "margin-bottom : 20px ;"><b>Booking Detail</b></div>
                <tr>
                    <td>
                            <b style = "margin-right : 20px ;"> Show Name</b>
                            <?=$row1['ShowName']?>
                            <input type="hidden" name="showid" value="<?=$row1['ShowID']?>">
                    </td>
                </tr>
                <tr>
                    <td>
                            <b style = "margin-right : 20px ;">Show Round</b>
                            <?=$row2['ShowDateTime']?>
                            <input type="hidden" name="showtime" value="<?=$row2['ShowtimeID']?>">
                    </td>
                </tr>
                <tr>
                    <td>
                            <b style = "margin-right : 20px ;">Zone</b>
                            <?=$row4['ZoneForShowName']?>
                            <input type="hidden" name="zoneselect" value="<?= $row4['ZoneForShowID'] * $quantity?>">
                    </td>
                </tr>
                <tr>
                    <td>
                            <b style = "margin-right : 20px ;"> Price</b>
                            <?=$row4['Price']?>
                    </td>
                </tr>
                <tr>
                    <td>
                            <b style = "margin-right : 20px ;"> Number of seats (s)</b>
                            <?=$quantity?>
                            <input type="hidden" name="quantity" value="<?=$quantity?>">
                    </td>
                </tr>
                <tr>
                    <td>
                            <b style = "margin-right : 20px ;">Seat Number</b>
                            <?=$seatforshowid?>
                            <input type="hidden" name="seatNo" value="<?=$seatforshowid?>">
                    </td>
                </tr>
                <tr>
                    <td>
                            <b style = "margin-right : 20px ;" >Total Amount</b>
                            <?= $row4['Price'] * $quantity?> THB
                            <input type="hidden" name="paymentamount" value="<?= $row4['Price'] * $quantity?>">
                    </td>
                </tr>
            </tbody>
        </table>      
    </div>
            <div class="cartheader mt-5 mr-4">
                    <a class ="back text-left " onclick="window.history.back();">Back</a>
                    <span class="text-end"><input type="submit" name="cf_booking" value='Confirm Booking' class='detailbook'/></span>               
            </div><br><br><br>
            
        </form>
    </div>
    
    
</body>
</html>