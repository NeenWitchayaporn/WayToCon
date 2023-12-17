<?php
    session_start();
    include('server.php');
    if(isset($_POST['cf_booking']))
    {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $payment = mysqli_real_escape_string($con, $_POST['paymentmethod']);
        $showtime = mysqli_real_escape_string($con, $_POST['showtime']);
        $seatNo = mysqli_real_escape_string($con, $_POST['seatNo']);
        $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
        
        $seat = explode(",", $seatNo);


        $user_query = "SELECT * FROM User WHERE UserEmail = '" .$_SESSION['UserEmail']. "' ";
        $query = mysqli_query($con,$user_query);
        $result = mysqli_fetch_assoc($query);
        $id = $result['UserID'];

        $sql = "INSERT INTO booking (UserID, ShowtimeID, PaymentMethodID)
        VALUES('$id','$showtime','$payment')";

        if (!mysqli_query($con,$sql)) {
                echo('Error: ' .mysqli_error($con));
            }

            $bookID = mysqli_insert_id($con);
            $_SESSION['BookingID'] = $bookID;

            echo $bookID;

            for($i = 0; $i < $quantity;$i++)
            if(($seat[$i]) != "")
            {
                
                $sql2 = "INSERT INTO bookingdetail (BookingID,SeatForShowID,NameOnTicket)
                VALUES('$bookID','" .$seat[$i]. "','" .$name. "')";

                 if (!mysqli_query($con,$sql2)) {
                    echo('Error: ' .mysqli_error($con));
                }

                     echo "<script> window.location='booking-report.php?id=".$bookID."'</script>";
                }
            }
     
?>