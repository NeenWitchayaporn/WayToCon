<?php 
    include('server.php');
    session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }

    $query = 'SELECT o.*,u.UserEmail ,SUM(g.ProductPrice * d.Quantity) AS TotalPrice FROM 
    ((giftshoporder o JOIN orderdetail d ON o.OrderID = d.OrderID) JOIN giftshop g ON d.ProductID = g.ProductID) 
    JOIN user u ON o.UserID = u.UserID WHERE o.Status = 1 GROUP BY o.OrderID;';
    $result =  mysqli_query($con,$query);
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
    
    <div class="h5 text-center mb-5 mt-5"> All Gift Shop Order </div>
    <div class="ordertable">
        <div class="card mt-2">
                <div class="text-center mt-3">
                <a href="staffallorder.php"  role="button" class="btn btn-outline-secondary btn-sm active" >Not Purchase</button></a>
                <a href="staffallorder-purchase.php"><button type="button" class="btn btn-outline-secondary btn-sm">Purchase</button></a>
                <a href="staffallorder-cancel.php"><button type="button" class="btn btn-outline-secondary btn-sm">Cancel</button></a>
                </div>
                
                <div class="card-body">
                    <table class="table table-striped" id="datatablesSimple">
                        <thead>
                        <th class="text-center">ID</th>
                        <th class="text-center">Ordertime</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Shipping Detail</th>
                        <th class="text-center">Total Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Detail</th>
                        <th class="text-center">Change Status</th>
                        <th class="text-center">Cancel</th>
                        </thead>
                        
                        <tbody>
                        <?php while($row = mysqli_fetch_array($result)) { 
                            $status = $row['Status'];
                        ?>
                            <tr>
                                <td ><?=$row['OrderID']?></td>
                                <td><?=$row['OrderDateTime']?></td>
                                <td width ="100"><?=$row['UserEmail']?></td>
                                <td><?=$row['Address']?></td>
                                <td><?=number_format($row['TotalPrice'],2)?></td>
                                <td><?php 
                                    if($status == 1) echo "<b style='color:orange;'>Not Purchase</b>";
                                    if($status == 2) echo "<b style='color:blue;'>Purchase</b>";
                                    if($status == 0) echo "<b style='color:red;'>Cancel</b>";
                                ?></td>
                                <td><a href="staffdetailorder.php?id=<?=$row['OrderID']?>" class="btn btn-info btn-sm">Detail</a></td>
                                <td><a href="updateorder.php?id=<?=$row['OrderID']?>" class="btn btn-warning btn-sm" onclick="confirmchange(this.href);return false;">Change</a></td>
                                <td> <a href="cancelorder.php?id=<?=$row['OrderID']?>" class="btn btn-danger btn-sm" onclick="confirmcancel(this.href);return false;">Cancel</a> </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        
                    </table>
                </div>
        </div>
    </div>
        
    
    
</body>
</html>


<script> 
function confirmcancel(page){
    var agree = confirm('Are you sure to cancel this order?');
    if(agree)
    {
        window.location = page;
    }
}

function confirmchange(page){
    var agree = confirm('Are you sure to change payment status of this order?');
    if(agree)
    {
        window.location = page;
    }
}

</script>