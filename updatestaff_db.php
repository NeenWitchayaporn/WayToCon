<?php 
    include('server.php');  
    session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }

    if(!isset($_SESSION['Role'])){
        $_SESSION['message'] = "You don't have permission";
        header('location:stafflogin.php');
    } 
    $error = array();

    if(isset($_POST['update_staff']))
    {
        $sid = $_POST['id'];
        $firstname = mysqli_real_escape_string($con, $_POST['first_name']);
        $lastname = mysqli_real_escape_string($con, $_POST['last_name']);
        $dob = mysqli_real_escape_string($con, $_POST['dob']);
        $gender = mysqli_real_escape_string($con, $_POST['gender']);
        $position = mysqli_real_escape_string($con, $_POST['position']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $idno = mysqli_real_escape_string($con, $_POST['id_card']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $salary = mysqli_real_escape_string($con, $_POST['salary']);
        $workdate = mysqli_real_escape_string($con, $_POST['workdate']);

        if(empty($firstname)){
            array_push($error, "Please Input data FirstName");
        }
        if(empty($lastname)){
            array_push($error, "Please Input data LastName");
        }
        if(empty($dob)){
            array_push($error, "Please Input data Date of Birth");
        }
        if(empty($gender)){
            array_push($error, "Please Input data Gender");
        }
        if(empty($position)){
            array_push($error, "Please Input data Postiton");
        }
        if(empty($phone)){
            array_push($error, "Please Input data Phone Number");
        }
        if(empty($idno)){
            array_push($error, "Please Input data ID Card Number");
        }
        if(empty($email)){
            array_push($error, "Please Input data Email");
        }
        if(empty($salary)){
            array_push($error, "Please Input data Salary");
        }
        if(empty($workdate)){
            array_push($error, "Please Input data Work Date");
        }

        $staff_query = "SELECT * FROM Staff WHERE (StaffEmail = '$email' OR StaffIDcard = '$idno') AND StaffID != '$sid'";
        $query = mysqli_query($con,$staff_query);
        $result = mysqli_fetch_assoc($query);

        if($result) {
            if($result['StaffEmail'] == $email)
            {
                array_push($error, "This Email already in use");
            }
            if($result['StaffIDcard'] == $idno)
            {
                array_push($error, "This staff already added");
            }
        }

        if(count($error) == 0) {
            if(!empty($_POST['endworkdate']))
            {
                $endworkdate = mysqli_real_escape_string($con, $_POST['endworkdate']);
                $sql = "UPDATE Staff SET StaffFirstName = '$firstname', StaffLastName = '$lastname', StaffGender = '$gender', StaffDOB = '$dob', StaffPhone = '$phone', PositionID = '$position', StaffIDcard = '$idno', StaffEmail='$email', StaffSalary='$salary', StaffWorkDate='$workdate', EndWorkDate='$endworkdate' WHERE StaffID = '$sid'";
                $result = mysqli_query($con,$sql);
                if (!$result) {
                    die('Error: ' . mysqli_error($con));
                }
                else
                {
                    echo "<script> alert('Edit Staff Information Successfully');</script>";
                    echo "<script>window.location='staffmember.php';</script>";
                }
                
            }
            else
            {
                $sql = "UPDATE Staff SET StaffFirstName = '$firstname', StaffLastName = '$lastname', StaffGender = '$gender', StaffDOB = '$dob', 
                StaffPhone = '$phone', PositionID = '$position', StaffIDcard = '$idno', StaffEmail='$email', StaffSalary='$salary', StaffWorkDate='$workdate'
                WHERE StaffID = '$sid'"; 
                $result = mysqli_query($con,$sql);
                if (!$result) {
                    die('Error: ' . mysqli_error($con));
                }
                else
                {
                    echo "<script> alert('Edit Staff Information Successfully');</script>";
                    echo "<script>window.location='staffmember.php';</script>";
                }
            }    
        }
        else
        {
            echo "<script> alert('Error ! Please Try Again');</script>";
            echo "<script>window.location='staffmember.php';</script>";
            
            
        }

    }

?>