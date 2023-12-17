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
    
    $sid = $_GET['id'];
    $gsquery = "SELECT * FROM giftshop g JOIN giftshopcollection c ON g.ProductCollectionID = c.ProductCollectionID WHERE ProductID = '$sid'";
    $result =  mysqli_query($con,$gsquery);
    $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Shop - WayToCon</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
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
    <div class="row">
        <div class="cartheader">
            <h4 class='mt-5 mb-5'><b><?=$row['ProductName']?></b></h4>
            <a href="cart.php" class="cart">
                <p class="text-right mt-5 mb-5">
                <img src="image/shopping-cart.png" width="25px" height="25px" alt="">
                </p>
            </a>
        </div>
        
        <hr class='line1'>
        <div class="col-md-6">
            <img src="image/<?=$row['ProductPic']?>" width="350px" alt="" class="mt-4 p-3 my-2 border"><br>
        </div>
        <div class="col-md-6">
            <h5 class='mt-4'><b><?=$row['ProductName']?></b></h5><br>
            From  <b style="color:#9565AE"><?=$row['ProductColName']?></b> Collection<br><br><br><br>
            <b style="color:#9565AE" class='mt-1 mb-3'>Description</b><br><br>
            <p><?=$row['ProductDescription']?></p><br><br>

            <hr class='line1'><br>
            <h5 style="color:#9565AE">Price : <?=number_format($row['ProductPrice'])?>  THB </h5><br>
            
            <a class ="detailprod mt-3 mr-4" href="order.php?id=<?=$row['ProductID']?>">Add to Cart</a>
        
        </div>
        
        
    </div>
    <a class ="back mt-5 mr-4" href="giftshop.php">Back</a>
    </div><br><br><br>

    
</body>
</html>