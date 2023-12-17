<?php 
    include('server.php');
    session_start();
    
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['StaffEmail']);
        header('location:stafflogin.php');
    }

    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }


    $productquery = 'SELECT * FROM giftshop g JOIN giftshopcollection gcol ON g.ProductCollectionID = gcol.ProductCollectionID ORDER BY g.ProductID ASC' ;
    $result =  mysqli_query($con,$productquery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WayToCon Product</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "staffmember.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
        <div class="h5 text-center mb-5 mt-5"> All Product </div>
        <table class="table table-striped">
            <tr class="table-secondary">
                <th>Product ID</th>
                <th>Name </th>
                <th>Collection</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Picture</th>
                <th>Description</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

        <?php while($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?=$row['ProductID']?></td>
                <td><?=$row['ProductName']?></td>
                <td><?=$row['ProductColName']?></td>
                <td><?=$row['ProductPrice']?></td>
                <td><?=$row['Stock']?></td>
                <td><img src="image/<?=$row['ProductPic']?>" height="100px"></td>
                <td><?=$row['ProductDescription']?></td>
                <td><a class ='edit_staff mt=1' href="updateproduct.php?id=<?=$row['ProductID']?>">Edit</a></td>
                <td><a class ='delete_staff mt=1' href="deleteproduct.php?id=<?=$row['ProductID']?>" onclick="confirmdel(this.href);return false;">Delete</a></td>
            </tr>
        <?php } ?>
        </table>

        <a class ='add_staff mt=1' href="staff_add_newPro.php">Add New Product</a>   
        <br><br><br>
    </div>
</body>
</html>


<script> 
function confirmdel(page){
    var agree = confirm('Are you sure to delete this product?');
    if(agree)
    {
        window.location = page;
    }
}

</script>