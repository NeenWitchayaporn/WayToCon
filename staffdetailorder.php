<?php
  
    include('server.php');
    session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }

    if(!isset($_GET['id'])){
        header('location:staffallorder.php');
    }

    
    $sql = "SELECT * FROM (giftshoporder g JOIN user u ON g.UserID = u.UserID) JOIN paymentmethod p ON g.PaymentMethodID = p.PaymentMethodID
    WHERE OrderID = '".$_GET['id']."'";
    $result =  mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Shop Order | WayToCon Staff</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "stafforder.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js" ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com/" >
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</head>
<body>
    <?php include_once('staffheader.php'); ?>
    <div class="container">
    <div class="alert alert-info h4 text-center mb-4 mt-5" role="alert">
         Order Detail Report
    </div>
    <div class="row">
                
    <div class="col">
    <div class="text-left mt-1">
        <b>OrderID&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['OrderID']?> <br>
        <p class="mt-2"><b>Order Datetime&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['OrderDateTime']?> <br>
        <b>User Name&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['UserFirstName']. ' ' .$row['UserLastName']?> <br>
        <b>User Email&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['UserEmail']?> <br>
        <b>Payment Method&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['PaymentMethodName']?> <br>
        <b>Shipping Detail&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['Address']?></p>
        <?php
        if((!empty($row['PurchaseDateTime'])) && (!empty($row['PaymentAmount']))): ?>
            <b style="color: blue;">Purchase DateTime&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['PurchaseDateTime']?><br>
            <b style="color: blue;">Payment Amount&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=number_format($row['PaymentAmount'],2)?> THB</p>
        <?php endif ?>
        
        <?php
        if(!empty($row['TrackingNumber'])): ?>
            <b style="color: blue;">Tracking Number&nbsp;&nbsp;:&nbsp;&nbsp;</b><?=$row['TrackingNumber']?></p>
        <?php endif ?>
        
        
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

            <div class="cartheader mt-3 mr-4">
                    <a class ="btn btn-outline-secondary text-center" href="staffallorder.php">Back</a>  
                    <?php
                    if(empty($row['TrackingNumber']) && ($row['Status'] != 0)): ?>
                        <a class ="btn btn-outline-success" href="edittracking.php?id=<?=$row['OrderID']?>">Add Tracking Number</a>  
                    <?php endif ?>  
            </div><br><br><br>
            
        
    </div>
    
    
</body>
</html>