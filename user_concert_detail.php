<?php
    include('server.php');
    session_start();

    if(!isset($_SESSION['UserEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:userlogin.php');
    }

    if(!isset($_GET['id'])){
        header('location:index.php');
    }
?>

<?php 
    
    $showid = $_GET['id'];
    $all = "SELECT * FROM showinfo s JOIN location l ON s.locationID = l.LocationID WHERE s.ShowID = '$showid'";
    $query1 = mysqli_query($con,$all);
    $row1 = mysqli_fetch_array($query1);

    $showtime = "SELECT * FROM showinfo s JOIN showtime t ON s.ShowID = t.ShowID WHERE s.ShowID = '$showid' ORDER BY t.ShowDateTime";
    $query2 = mysqli_query($con,$showtime);

    $zone = "SELECT * FROM showinfo s JOIN zoneforshow h ON s.ShowID = h.ShowID WHERE s.ShowID = '$showid'";
    $query3 = mysqli_query($con,$zone);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event_detail</title>
    <link rel = "stylesheet" href = "user_concert_detail.css">
    <link rel = "stylesheet" href = "css/bootstrap-grid.min.css">
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com/" >
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>


<body>
    <?php include_once('header.php'); ?>

    <div class="container-md mt-5">
        <h1 class="font-weight-bold mtb-2"><?= $row1['ShowName'] ?></h1>
        <div class="row">
                <div class="col-md-3 mt-4">
                    <div class="card">
                        <img src="image/<?= $row1['Poster'] ?>" width = "100%" alt="">
                        <?php if($row1['SaleDate'] < date("Y-m-d")) : ?>
                                <a href="reserve_round_zone.php?id=<?=$row1['ShowID']?>" class="card-button">Buy Now</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-9 mt-4">
                    <div class="info-card">
                        <div class="row">
                            <div class="col-5">
                                <div class="showdate" >
                                    <div class="row">
                                        <div class="col-2 align-self-md-center px0" >
                                                <img src="./image/fi-rs-calendar.png" alt="">
                                        </div>
                                        <div class="col-10">
                                             <h5 class="card-title">Show Date</h5>
                                        </div>
                                    </div>
                                    <?php while($row2 = mysqli_fetch_array($query2)) { ?>
                                    <p class="card-text"><?= $row2['ShowDateTime'] ?></p>
                                    <?php } ?>
                                </div>
                                <div class="venue">
                                    <div class="row">
                                        <div class="col-2 align-self-md-center px0" >
                                                <img src="./image/Vector.png" alt="">
                                        </div>
                                        <div class="col-10">
                                            <h5 class="card-title">Venue</h5>
                                        </div>
                                    </div>
                                    <p class="card-text"><?= $row1['LocationName'] ?></p>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="saleopen">
                                    <div class="row">
                                        <div class="col-2 align-self-md-center px0" >
                                                <img src="./image/Vector-2.png" alt="">
                                        </div>
                                        <div class="col-10">
                                            <h5 class="card-title">Sale Date</h5>
                                        </div>
                                    </div>
                                    <p class="card-text"><?= $row1['SaleDate'] ?></p>
                                </div>
                                    <div class="price">
                                        <div class="row">
                                            <div class="col-2 align-self-md-center px0" >
                                                    <img src="./image/Vector-3.png" alt="">
                                            </div>
                                            <div class="col-10">
                                                <h5 class="card-title">Ticket Price</h5>
                                            </div>
                                        </div>
                                          <tr>
                                            |
                                            <?php while($row3 = mysqli_fetch_array($query3)) { ?>
                                            <ul class="card-text"><?= $row3['Price'] ?> THB | </ul>
                                            <?php } ?>
                                          </tr>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-2 ">
                <div class="card">
                    <h3 class="Seating">Seating Plan</h3>                   
                    <img src="image/<?= $row1['SeatingMap'] ?>" width = "100%"alt="">
                </div>
            </div>
            <div class="col-md-8 mt-2 ">
                <div class="card">
                    <h3 class="detail">Detail</h3>
                    <div class="detail-body">
                        <p class="card-text"><?= $row1['Description'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script src = js/bootstrap-grid.min.js></script>
</body>
</html>

