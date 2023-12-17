<?php 
    session_start();
    if(!isset($_SESSION['UserEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:userlogin.php');
    }
    include('server.php');
    if(isset($_POST['cf_order']))
    {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $payment = mysqli_real_escape_string($con, $_POST['paymentmethod']);


        $shipinfo = $name . ' ' . $address . ' ' . $phone;

        $user_query = "SELECT * FROM User WHERE UserEmail = '" .$_SESSION['UserEmail']. "' ";
        $query = mysqli_query($con,$user_query);
        $result = mysqli_fetch_assoc($query);
        $id = $result['UserID'];
        
       
        $sql = "INSERT INTO giftshoporder (UserID,Address,PaymentMethodID) 
        VALUES('$id','$shipinfo','$payment')";
        
        if (!mysqli_query($con,$sql)) {
            echo('Error: ' .mysqli_error($con));
        }
    
        $orderID = mysqli_insert_id($con);
        $_SESSION['OrderID'] = $orderID;

        for($i = 0 ;$i <= (int)$_SESSION['record'];$i++){
            if(($_SESSION['ProductID'][$i]) != "")
            {
                $sql2 = "INSERT INTO orderdetail(OrderID,ProductID,Quantity)
                VALUES('$orderID','" .$_SESSION['ProductID'][$i]. "','" .$_SESSION['ProductQty'][$i]. "')";
                if(mysqli_query($con,$sql2))
                {
                    $sql3 = "UPDATE giftshop SET Stock = Stock - '" .$_SESSION['ProductQty'][$i]. "' WHERE ProductID = '" .$_SESSION['ProductID'][$i]. "'";
                    mysqli_query($con,$sql3);
                    // echo "<script> alert('Order Successfully')</script>";
                    echo "<script> window.location='order-report.php'</script>";
                }
            }
        }
        
    }

    unset($_SESSION['record']);
    unset($_SESSION['ProductID']);
    unset($_SESSION['ProductQty']);
    unset($_SESSION["Price"]);

?>

