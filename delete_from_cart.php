<?php
   ob_start();
   session_start();
   if(!isset($_SESSION['UserEmail'])){
    $_SESSION['message'] = 'You must log in first';
    header('location:userlogin.php');
    }
   include('server.php');
   if(isset($_GET['rec']))
    {
        $rec = $_GET['rec'];
        $_SESSION['ProductID'][$rec] = "";
        $_SESSION['ProductQty'][$rec] = "";
    }
    header('location:cart.php');


?>