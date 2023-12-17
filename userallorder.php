<?php 
    include('server.php');
    session_start();

    if(!isset($_SESSION['UserEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:userlogin.php');
    }

    $sql = "SELECT o.* ,u.UserEmail ,SUM(g.ProductPrice * d.Quantity) AS TotalPrice FROM 
    ((giftshoporder o JOIN orderdetail d ON o.OrderID = d.OrderID) JOIN giftshop g ON d.ProductID = g.ProductID) 
    JOIN user u ON o.UserID = u.UserID WHERE UserEmail = '".$_SESSION['UserEmail']."' GROUP BY o.OrderID;";
    $result =  mysqli_query($con,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Order | WayToCon</title>
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
<?php include_once('header.php'); ?>
    
    <div class="h5 text-center mb-5 mt-5"> Your Gift Shop Order </div>
    <div class="ordertable">
        <div class="card mt-2">
                <div class="card-body">
                    <table class="table table-striped" id="datatablesSimple">
                        <thead>
                        <th class="text-center">Order ID</th>
                        <th class="text-center">Ordertime</th>
                        <th class="text-center">Shipping Detail</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Confirm Payment</th>
                        </thead>
                        
                        <tbody>
                        <?php while($row = mysqli_fetch_array($result)) { 
                            $status = $row['Status'];
                        ?>
                            <tr>
                                <td ><?=$row['OrderID']?></td>
                                <td><?=$row['OrderDateTime']?></td>
                                <td><?=$row['Address']?></td>
                                <td><?=number_format($row['TotalPrice'],2)?></td>
                                <td><?php 
                                    if($status == 1) echo "<b style='color:orange;'>Not Purchase</b>";
                                    if($status == 2) echo "<b style='color:blue;'>Purchase</b>";
                                    if($status == 0) echo "<b style='color:red;'>Cancel</b>";
                                ?></td>
                                <td><a href="order-report.php?id=<?=$row['OrderID']?>" class="btn btn-info btn-sm">Detail</a></td>
                                <td><?php if((empty($row['PurchaseDateTime'])) && (empty($row['PaymentAmount']))): ?>
                                    <a href="confirm-order-payment.php?id=<?=$row['OrderID']?>" class="btn btn-success btn-sm">Confirm</a>
                                    <?php else : ?>
                                        <button type="button" class="btn btn-secondary btn-sm" disabled>Confirm</button>
                                    <?php endif ?>
                                
                                
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        
                    </table>
                </div>
        </div>
    </div>
    
</body>
</html>

