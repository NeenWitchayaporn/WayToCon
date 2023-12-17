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

    if((!isset($_SESSION['OrderID'])) & (!isset($_GET['id']))){
        $_SESSION['message'] = 'You must order first';
        header('location:giftshop.php');
    }
    if(!isset($_GET['id']))
    {
        $sql = "SELECT * FROM giftshoporder g JOIN user u ON g.UserID = u.UserID WHERE OrderID = '".$_SESSION['OrderID']."'";
    }
    if(!isset($_SESSION['OrderID']))
    {
        $sql = "SELECT * FROM giftshoporder g JOIN user u ON g.UserID = u.UserID WHERE OrderID = '".$_GET['id']."' ";
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
    <div class="alert alert-info h4 text-center mb-4 mt-5" role="alert">
         Your Order 
    </div>
    <div class="row">
                
    <div class="col">
    <div class="text-left mt-1">
        <b>OrderID&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['OrderID']?> <br>
        <p class="mt-2"><b>Order Datetime&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['OrderDateTime']?> <br>
        <b>User Name&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['UserFirstName']. ' ' .$row['UserLastName']?> <br>
        <b>Shipping Detail&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['Address']?></p><br>
    </div>
    

    <table class="table table-bordered">
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Product</th>
                <th class="text-center">Detail</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Total Price</th>
            </tr>
        
            <?php
                $detailqr = "SELECT *,(g.ProductPrice * o.Quantity) AS SumPrice FROM orderdetail o JOIN giftshop g on o.ProductID = g.ProductID WHERE o.OrderID = '".$row['OrderID']."' ORDER BY o.ProductID";
                $query = mysqli_query($con,$detailqr);
                while($rowdt = mysqli_fetch_array($query)) {
            ?>

          <tr>

            <td class="text-center"><br><b><?=$rowdt['ProductID']?></b></td>    
            <td class="text-center"><img src="image/<?=$rowdt['ProductPic']?>" width="75px" alt="" class="mt-4 p-2 my-2"></td>
            <td>
                <br>
                
                    <b><?=$rowdt['ProductName']?></b><br>
                    <p style="color: #777777">Price : <?=$rowdt['ProductPrice']?> THB</p>
            
            </td>
            <td class="text-center" ><br>
                <?=$rowdt['Quantity']?>
            </td>
            
            <td class="text-center">
                <br><p style="color:#9565AE"><?=number_format($rowdt['SumPrice'],2)?> THB</p>
            </td>
            
         </tr>
         
         <?php } 
            $totalqr = "SELECT SUM(g.ProductPrice * d.Quantity) AS TotalPrice FROM (giftshoporder o JOIN orderdetail d ON o.OrderID = d.OrderID) 
                        JOIN giftshop g ON d.ProductID = g.ProductID WHERE o.OrderID = '".$row['OrderID']."' GROUP BY o.OrderID;";
            $query1 = mysqli_query($con,$totalqr);
            $rowtt = mysqli_fetch_array($query1);     
         ?>   
                        

            <tr>

            <td class="text-center" colspan="3" >
                <b>Total Price  :</b>
            </td>
            <td class="text-center" colspan="2">         
                <b style="color: #9565AE"><?=number_format($rowtt['TotalPrice'],2)?> THB</b>
            </td>

            </tr>
                    </table>
                    
                </div>
            </div>

            <div>
                <h6 class="text-end mt-1">** Please make the payment within 48 hours. **</h6>
            </div>

            <div class="cartheader mt-3 mr-4">
                    <a class ="back text-center " onclick="window.history.back();">Back</a>      
            </div><br><br><br>
            
        
    </div>
    
    
</body>
</html>