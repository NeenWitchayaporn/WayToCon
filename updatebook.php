<?php
    include('server.php');
    session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }
    if(isset($_GET['id']))
    {
        $bid = $_GET['id'];
        $sql = "UPDATE booking SET Status = 2 WHERE BookingID ='$bid'";
        $result = mysqli_query($con,$sql);
        if($result)
        {
            echo "<script>window.location='staffallevent.php';</script>";
        }
        else
        {
            echo "<script> alert('Error ! Please Try Again');</script>";
            echo "<script>window.location='staffallevent.php';</script>";
        }
    }
    else
    {
        echo "<script>window.location='staffallevent.php';</script>";
    }

?>