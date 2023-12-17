<?php 
    include('server.php');   
    if(isset($_GET['id']))
    {
        $sid = $_GET['id'];
        $sql = "DELETE FROM giftshop WHERE ProductID = '$sid'";
        $result = mysqli_query($con,$sql);
        if (!$result) {
            die('Error: ' . mysqli_error($con));
        }
        else
        {
            echo "<script> alert('Delete Product Successfully');</script>";
            echo "<script>window.location='all_product.php';</script>";
        }
    }

?>


