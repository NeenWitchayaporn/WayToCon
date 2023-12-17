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
    unset($_SESSION['OrderID']);
    $gsquery = 'SELECT * FROM giftshop g JOIN giftshopcollection c ON g.ProductCollectionID = c.ProductCollectionID WHERE g.Stock > 0';
    $result =  mysqli_query($con,$gsquery);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Shop - WayToCon</title>
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
    <?php if(isset($_SESSION['message'])) : ?>
            <div class = "alertred text-center mt-5">
                <h4>
                    <?php
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    ?>
                </h4>
            </div>
        <?php endif ?>
    <div class="cartheader">
        <div class="h4 text-left mb-4 mt-5">
            <b>Gift Shop Products</b>
        </div>
        <a href="cart.php" class="cart">
            <p class="text-right mt-5 mb-4">
            <img src="image/shopping-cart.png" width="25px" height="25px" alt="">
            </p>
        </a>
    </div>

    <hr class='line1'>
    <div class="row">
    <?php while($row = mysqli_fetch_array($result)) { ?>
        
        <div class="col-sm-3">
            <div class="text-center">
                <img src="image/<?=$row['ProductPic']?>" width="200px" heigth="250px" alt="" class="mt-5 p-3 my-2 border"><br> 
                <p class="fw-bolder mt-4"><?=$row['ProductName']?></p>
                <b style="color:#9565AE">Price :  <?=number_format($row['ProductPrice'])?>  THB </b><br> 
                <a class ='detailprod mt-4' href="detail-product.php?id=<?=$row['ProductID']?>">View Details</a>   
            </div>
            
        <br>
        </div>
        <?php } ?>   
    </div>
    </div>
    <br><br>

    
</body>
</html>