<?php
    session_start();
    include('server.php');
    $error = array();

    if(isset($_POST['reg_user']))
    {
        $firstname = mysqli_real_escape_string($con, $_POST['first_name']);
        $lastname = mysqli_real_escape_string($con, $_POST['last_name']);
        $gender = mysqli_real_escape_string($con, $_POST['gender']);
        $dob = mysqli_real_escape_string($con, $_POST['dob']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $idno = mysqli_real_escape_string($con, $_POST['id_card']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $password_1 = mysqli_real_escape_string($con, $_POST['password']);
        $password_2 = mysqli_real_escape_string($con, $_POST['confirmPassword']);

        if(empty($firstname)){
            array_push($error, "Please Input data FirstName");
        }
        if(empty($lastname)){
            array_push($error, "Please Input data LastName");
        }
        if(empty($gender)){
            array_push($error, "Please Input data Gender");
        }
        if(empty($dob)){
            array_push($error, "Please Input data Date of Birth");
        }
        if(empty($phone)){
            array_push($error, "Please Input data Phone Number");
        }
        if(empty($address)){
            array_push($error, "Please Input data Address");
        }
        if(empty($idno)){
            array_push($error, "Please Input data ID Card Number");
        }
        if(empty($email)){
            array_push($error, "Please Input data Email");
        }
        if(empty($password_1)){
            array_push($error, "Please Input data Password");
        }
        if($password_1 != $password_2){
            array_push($error, "Confirm password doesn't match");
        }

        $user_query = "SELECT * FROM User WHERE UserEmail = '$email' OR UserIDcard = '$idno'";
        $query = mysqli_query($con,$user_query);
        $result = mysqli_fetch_assoc($query);

        if($result) {
            if($result['UserEmail'] == $email)
            {
                array_push($error, "This Email already in use");
            }
            if($result['UserIDcard'] == $idno)
            {
                array_push($error, "This ID Card Number already registed");
            }
            
        }

       if(count($error) == 0) {
            $password = md5($password_1);
            $sql = "INSERT INTO User (UserFirstName, UserLastName, UserGender, UserDOB, UserPhone, UserAddress, UserIDcard, UserEmail, UserPassword)
	        VALUES ('$firstname', '$lastname', '$gender','$dob','$phone','$address','$idno','$email','$password')";
            if (!mysqli_query($con,$sql)) {
                die('Error: ' . mysqli_error($con));
            }
            $_SESSION['UserEmail'] = $email;
            $_SESSION['success'] = 'You are logged in';
            header('location:index.php');
       }
       else {
            array_push($error,'Error Try again !');
            $_SESSION['error'] = 'Error Try again !';
            header('location:userregister.php');
       }

        
    }





?>