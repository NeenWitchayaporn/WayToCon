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

    if(!isset($_SESSION['record']))
    {
        header('location:giftshop.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Shop Order - WayToCon</title>
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
    <div class="h4 text-left mb-4 mt-5"><b> Confirm Order </b></div>
        <form action="order_db.php" method="POST">
            <div class="row">
                <div class="col-lg-6">
                    <div class="text-left mt-2"><b>Shipping Detail</b></div><br>
                    <table class="orderconfi">
                    <tr><td>
                        <div class="form-group">
                        <label class="name">Name :</label>
                            <input class="form-control mt-2" name="name" placeholder="Name" type="text" required />
                        </div><br>

                        <div class="form-group">
                        <label class="address">Address :</label>
                            <textarea class="form-control mt-2" name="address" placeholder="Address" style="height:170px" required></textarea>
                        </div><br>

                        <div class="form-group">
                        <label class="">Phone :<br/></label>
                        <div>
                            <input class="form-control mt-2" name="phone" placeholder="089-9XX-XXXX"  type="text" maxlength="10" required/>
                        </div>
                    </div><br>
                    </td></tr>
                    </table><br>
                
                <div class="text-left mt-3"><b>Payment Method</b></div><br>
                <table class="orderconfi mt-1">
                    <tr>
                        <td>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                            <label class="form-check-label" for="truemoney"><input class="form-check-input" type="radio" name="paymentmethod" value=1 checked="">
                            <span> TrueMoney Wallet</span></label>
                            </div><br>
                            <div class="form-check form-check-inline">
                            <label class="form-check-label" for="promptpay"><input class="form-check-input" type="radio" name="paymentmethod" value=2>
                            <span> PromptPay</span></label>
                            </div>
                        </div>
                        
                        </td>
                    </tr>
                </table>
        </div>
    <div class="col-lg-6">
    <table class="orderconfi mt-5">

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
                
            <td class="text-center"><img src="image/<?=$row1['ProductPic']?>" width="75px" alt="" class="mt-4 p-2 my-2"></td>
            <td>
                <br>
                
                    <b><?=$row1['ProductName']?></b><br>
                    <p style="color: #777777">Price : <?=$row1['ProductPrice']?> THB</p>
            
            </td>
            <td class="text-center" width = '140'><br>
                <b>Quantity : <?=$_SESSION['ProductQty'][$i]?></b>
                <br><p style="color:#9565AE"><?=number_format($SumPrice,2)?> THB</p>
            </td>
            
         </tr>
                        
    <?php 
    $n = $n+1;
} } ?>

            <tr>

            <td colspan="2" >
                <b>Total Price  :</b>
            </td>
            <td class="text-end">         
                <b style="color: #9565AE"><?=number_format($TotalPrice,2)?> THB</b>
            </td>

            </tr>
                    </table>
                    
                </div>
            </div>
            <div class="cartheader mt-5 mr-4">
                    <a class ="back text-left " href="cart.php">Back</a>
                    <span class="text-end"><input type="submit" name="cf_order" value='Confirm Order' class='detailprod'/></span>               
            </div><br><br><br>
            
        </form>
    </div>
    
    
</body>
</html>