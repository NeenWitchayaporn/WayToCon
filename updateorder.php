<?php
    include('server.php');
    session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }
    if(isset($_GET['id']))
    {
        $oid = $_GET['id'];
        $sql = "UPDATE giftshoporder SET Status = 2 WHERE OrderID ='$oid'";
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