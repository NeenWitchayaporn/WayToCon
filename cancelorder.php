<?php
    include('server.php');
    if(isset($_GET['id']))
    {
        $oid = $_GET['id'];
        $dt = "SELECT * FROM Orderdetail WHERE OrderID = '$oid'";
        $dtquery = mysqli_query($con,$dt);
        while($rdt = mysqli_fetch_array($dtquery))
        {
            $proid = $rdt['ProductID'];
            $qty = $rdt['Quantity'];
            $stsql = "UPDATE giftshop SET Stock = Stock + $qty WHERE ProductID = '$proid'";
            $stquery = mysqli_query($con,$stsql);
        }

        $sql = "UPDATE giftshoporder SET Status = 0 WHERE OrderID ='$oid'";
        $result = mysqli_query($con,$sql);
        if($result)
        {
            echo "<script>window.location='staffallorder.php';</script>";
        }
        else
        {
            echo "<script> alert('Error ! Please Try Again');</script>";
            echo "<script>window.location='staffallorder.php';</script>";
        }
    }
    else
    {
        echo "<script>window.location='staffallorder.php';</script>";
    }

?>