<?php
session_start();
include('server.php');

$error = array();

if (isset($_POST['login_staff'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    if (empty($email)) {
        array_push($error, "Please input email");
    }
    if (empty($password)) {
        array_push($error, "Please input password");
    }

    if (count($error) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM Staff WHERE StaffEmail = '$email' AND StaffPassword = '$password'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['StaffEmail'] = $email;
            $_SESSION['staff_id'] = $row['StaffID'];
            if($row['PositionID'] == 2)
            {
                $_SESSION['Role'] = 'Admin';
            }
            header('location: staff.php');
          
        } else {
            array_push($error, 'Wrong email or password');
            $_SESSION['error'] = 'Wrong email or password';
            header('location: stafflogin.php');
          
        }
    }
}
?>