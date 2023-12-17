<?php 
    include('server.php');   
    $error = array();

    if(isset($_POST['cf']))
    {
        $sid = $_POST['id'];
        $purdatetime = mysqli_real_escape_string($con, $_POST['purchasedt']);
        $paymentamount = mysqli_real_escape_string($con, $_POST['payment']);
        

        if(empty($purdatetime)){
            array_push($error, "Please Input data Purchase DateTime");
        }
        if(empty($paymentamount)){
            array_push($error, "Please Input data Payment Amount");
        }


        if(count($error) == 0) {

            $sql = "UPDATE booking SET PurchaseDateTime = '$purdatetime', PaymentAmount = '$paymentamount' WHERE BookingID = '$sid'";
            $result = mysqli_query($con,$sql);
            if (!$result) {
                die('Error: ' . mysqli_error($con));
            }
            else
            {
                echo "<script> alert('Add Data Successfully');</script>";
                echo "<script>window.location='userallbooking.php';</script>";
            }

        }
        else
        {
            echo "<script> alert('Error ! Please Try Again');</script>";
            echo "<script>window.location='userallbooking.php';</script>";
            
            
        }

    }

?>