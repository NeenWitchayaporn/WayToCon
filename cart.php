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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Shop Cart - WayToCon</title>
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
    <div class="h4 text-left mb-4 mt-5"><b> Gift Shop Cart </b></div>
        <!-- <form action="#" method="POST"> -->
            <div class="row">
                <div class="col">
                    <table class ='table table-bordered mt-3'>
                        <tr>
                            <th class="text-center">Order</th>
                            <th class="text-center">Product</th>
                            <th class="text-center">Detail</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Total Price</th>
                            <th class="text-center">Add  -<br>Remove</th>
                            <th class="text-center">Remove All</th>
                        </tr>
        <?php
        $Total = 0;
        $TotalPrice = 0;
        $n = 1;
        for($i = 0 ;$i <= (int)$_SESSION['record'];$i++){
            if(($_SESSION['ProductID'][$i]) != "")
            {
                $sql = "SELECT * FROM giftshop WHERE ProductID = '" .$_SESSION['ProductID'][$i]. "' ";
                $result1 =  mysqli_query($con,$sql);
                $row1 = mysqli_fetch_array($result1);
                $_SESSION["Price"] = $row1['ProductPrice'];
                $Total = $_SESSION['ProductQty'][$i];
                $SumPrice = $Total * $row1['ProductPrice'];
                $TotalPrice = $TotalPrice + $SumPrice;
            
        ?>
                        <tr>
                            <td class="text-center"><br><?=$n?></td>
                            <td class="text-center"><img src="image/<?=$row1['ProductPic']?>" width="80px" alt="" class="mt-4 p-3 my-2"></td>
                            <td>
                                <br>
                                <div class="cartdetail">
                                    <b><?=$row1['ProductName']?></b><br>
                                    <p style="color: #777777">Price : <?=$row1['ProductPrice']?> THB</p>
                                </div>
                            </td>
                            <td class="text-center"><br><?=$_SESSION['ProductQty'][$i]?></td>
                            <td class="text-center" width="110"><br><p style="color:#9565AE"><?=number_format($SumPrice)?> THB</p></td>
                            <td class="text-center"><br>
                                <a class='plusbutton' href="order.php?id=<?=$row1['ProductID']?>">+</a>
                                <?php if($_SESSION['ProductQty'][$i] > 1){ ?>
                                <a class='plusbutton' href="del-order.php?id=<?=$row1['ProductID']?>">-</a>
                                <?php } ?>
                            </td>
                            <td class="text-center"><br> 
                                <a class='xbutton' href="delete_from_cart.php?rec=<?=$i?>"></a>
                            </td>
                        </tr>
                        
                    <?php 
                    $n = $n+1;
                } } ?>

                    <tr>

                        <td colspan="3" class="text-center">
                            <b>Total Price  :</b>
                        </td>
                        <td colspan="4" class="text-center">         
                            <b style="color: #9565AE"><?=number_format($TotalPrice,2)?> THB</b>
                        </td>
                        
                    </tr>
                    </table>
                    
                    <div style="text-align:right">
                        <a class ='addmore mt-4' href="giftshop.php">Add More to Cart</a> <p class='sep'>|</p>
                        <?php if($TotalPrice > 0){ ?>
                        <a class ='detailprod mt-4' href="confirm-order.php">Confirm Order</a>
                        <?php } ?>
                    </div>
                </div>
            </div>

          

        <!-- </form> -->
        <br><br><br>
    </div>
    
</body>
</html>