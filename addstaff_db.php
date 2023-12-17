<?php 
    include('server.php');
    $error = array();
    if(isset($_POST['add_staff']))
    {
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
        $password = mysqli_real_escape_string($con, $_POST['password']);

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
        if(empty($password)){
            array_push($error, "Please Input data Password");
        }
        $staff_query = "SELECT * FROM Staff WHERE StaffEmail = '$email' OR StaffIDcard = '$idno'";
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
            $password = md5($password);
            if(!empty($_POST['endworkdate']))
            {
                $endworkdate = mysqli_real_escape_string($con, $_POST['endworkdate']);
                $sql = "INSERT INTO Staff (StaffFirstName, StaffLastName, StaffGender, StaffDOB, StaffPhone, PositionID, StaffIDcard, StaffEmail, StaffSalary, StaffWorkDate, EndWorkDate ,StaffPassword)
                VALUES ('$firstname', '$lastname', '$gender','$dob','$phone','$position','$idno','$email','$salary','$workdate','$endworkdate','$password')";
                $result = mysqli_query($con,$sql);
                if (!$result) {
                    die('Error: ' . mysqli_error($con));
                }
                else
                {
                    echo "<script> alert('Add Staff Successfully');</script>";
                    echo "<script>window.location='staffmember.php';</script>";
                }
                
            }
            else
            {
                $sql = "INSERT INTO Staff (StaffFirstName, StaffLastName, StaffGender, StaffDOB, StaffPhone, PositionID, StaffIDcard, StaffEmail, StaffSalary, StaffWorkDate,StaffPassword)
                VALUES ('$firstname', '$lastname', '$gender','$dob','$phone','$position','$idno','$email','$salary','$workdate','$password')";
                $result = mysqli_query($con,$sql);
                if (!$result) {
                    die('Error: ' . mysqli_error($con));
                }
                else
                {
                    echo "<script> alert('Add Staff Successfully');</script>";
                    echo "<script>window.location='staffmember.php';</script>";
                }
            }    
        }
        else
        {
            echo "<script> alert('Error ! Please Try Again');</script>";
            echo "<script>window.location='addstaff.php';</script>";
            
            
        }
        

    }

?>

