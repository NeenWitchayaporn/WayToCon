<?php
    include('server.php');
    session_start();
    
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['UserEmail']);
        header('location:userlogin.php');
    }

    if(!isset($_SESSION['UserEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:userlogin.php');
    }

?>
<?php 
    
    $all = 'SELECT * FROM showinfo s  JOIN location l ON s.locationID = l.LocationID WHERE s.SaleDate <= CURDATE() ORDER BY SaleDate' ;
    $query1 = mysqli_query($con,$all);

    $upcoming = 'SELECT * FROM (showinfo s JOIN showtime t ON s.ShowID = t.ShowID) JOIN location l ON s.locationID = l.LocationID WHERE s.SaleDate > CURDATE() ORDER BY SaleDate';
    $query2 = mysqli_query($con,$upcoming);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>WayToCon</title>
<link rel="icon" type="image/x-icon" href="image/template.png" />
<link rel = "stylesheet" href = "index.css">
<link rel = "stylesheet" href = "css/bootstrap-grid.min.css">
</head>
<body>

<?php include_once('header.php'); ?>

<div class = container-fluid>
<!-- First Row [All]-->
<h2 class="font-weight-bold mb-2">All Event</h2><br>
<div class="row">

<?php while($row = mysqli_fetch_array($query1)) { ?>
        <div class="col-md-3">
            <div class="card" >
                <div class="card-img">
                    <img src="image/<?= $row['Poster'] ?>" width = "100%"alt="">
                </div>
                <div class="card-body">
                    <p><h4 class = "showname"><a href="user_concert_detail.php" class="card-title"><?= $row['ShowName'] ?></a></h4>
                    Location : <?= $row['LocationName'] ?></p><br>
                    <a href="user_concert_detail.php?id=<?=$row['ShowID']?>" class="card-button"> Buy Now</a>
                </div>
            </div>
        </div>
<?php  }  ?>
</div>
    <br>
    <!-- Second Row [Upcoming]-->
    <h2 class="font-weight-bold mb-2">Upcoming Event</h2><br>
    <div class="row">
    <?php while($row = mysqli_fetch_array($query2)) { ?>
        <div class="col-md-3">
            <div class="card">
                <div class="card-img">
                    <img src="image/<?= $row['Poster'] ?>" width = "100%"alt="">
                </div>
                <div class="card-body">
                    <h4 class = "showname"><a href="user_concert_detail.php" class="card-title"><?= $row['ShowName'] ?></a></h4>
                    <p class="card-text">
                        <?= $row['ShowDateTime'] ?>
                        <br>
                        <?= $row['LocationName'] ?>
                    </p>
                    <a href="user_concert_detail.php?id=<?=$row['ShowID']?>" class="card-upcoming-button">Upcoming</a>
                </div>
            </div>
        </div>
    <?php  }  ?>
    </div>
</div>   

</body>

</html>

