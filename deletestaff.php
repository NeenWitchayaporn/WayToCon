<?php 
    session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }
    
    if(!isset($_SESSION['Role'])){
        $_SESSION['message'] = "You don't have permission";
        header('location:stafflogin.php');
    }
    include('server.php');   
    if(isset($_GET['id']))
    {
        $sid = $_GET['id'];
        $sql = "DELETE FROM Staff WHERE StaffID = '$sid'";
        $result = mysqli_query($con,$sql);
        if (!$result) {
            die('Error: ' . mysqli_error($con));
        }
        else
        {
            echo "<script> alert('Delete Staff Successfully');</script>";
            echo "<script>window.location='staffmember.php';</script>";
        }
    }

?>


