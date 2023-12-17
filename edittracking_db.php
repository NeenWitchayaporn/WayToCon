<?php 
    include('server.php');   
    session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }
    $error = array();

    if(isset($_POST['updatetrackno']))
    {
        $sid = $_POST['id'];
        $trackno = mysqli_real_escape_string($con, $_POST['trackno']);
        $staff = mysqli_real_escape_string($con, $_POST['staff']);
        

        if(empty($trackno)){
            array_push($error, "Please Input data Tracking Number");
        }
        if(empty($staff)){
            array_push($error, "Please Input data Responsible Staff");
        }


        if(count($error) == 0) {

            $sql = "UPDATE giftshoporder SET TrackingNumber = '$trackno', StaffID = '$staff' WHERE OrderID = '$sid'";
            $result = mysqli_query($con,$sql);
            if (!$result) {
                die('Error: ' . mysqli_error($con));
            }
            else
            {
                echo "<script> alert('Edit Tracking Number Successfully');</script>";
                echo "<script>window.location='staffallorder.php';</script>";
            }

        }
        else
        {
            echo "<script> alert('Error ! Please Try Again');</script>";
            echo "<script>window.location='staffallorder.php';</script>";
            
            
        }

    }

?>