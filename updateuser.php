<?php

session_start();
include('server.php');

if(!isset($_SESSION['user_id'])){
    $_SESSION['message'] = 'You must log in first';
    header('location:userlogin.php');
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {

    $update_firstname = mysqli_real_escape_string($con, $_POST['update_firstname']);
    $update_lastname = mysqli_real_escape_string($con, $_POST['update_lastname']);
    $update_dob = mysqli_real_escape_string($con, $_POST['update_dob']);
    $update_gender = mysqli_real_escape_string($con, $_POST['update_gender']);
    $update_phone = mysqli_real_escape_string($con, $_POST['update_phone']);
    $update_address = mysqli_real_escape_string($con, $_POST['update_address']);
    $update_email = mysqli_real_escape_string($con, $_POST['update_email']);

    mysqli_query($con, "UPDATE `user` SET UserFirstName = '$update_firstname', UserLastName = '$update_lastname', UserDOB = '$update_dob', UserGender = '$update_gender', UserPhone = '$update_phone', UserAddress = '$update_address', UserEmail = '$update_email' WHERE UserID = '$user_id'") or die('query failed');
    $_SESSION['update_success'] = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WayToCon</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .gender-label {
            display: inline-block;
            margin-right: 10px;
        }
    </style>
</head>

<body>
<?php include_once('header.php'); ?>

    <div class="update-profile">

        <?php
        $select = mysqli_query($con, "SELECT * FROM user WHERE UserID = '$user_id'") or die('Query failed');
        if (mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_assoc($select);
        }
        ?>
        <?php
        if (isset($_SESSION['update_success'])) {
            echo '<script>alert("Update successful");</script>';
            unset($_SESSION['update_success']);
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <?php
        
                echo '<img src="image/default-avatar.png">';
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
            ?>
            <div class="flex">
                <div class="inputBox">
                    <span>First Name :</span>
                    <input type="text" maxlength="20" name="update_firstname"
                        value="<?php echo $fetch['UserFirstName']; ?>" class="box">
                    <span>Last Name :</span>
                    <input type="text" maxlength="20" name="update_lastname"
                        value="<?php echo $fetch['UserLastName']; ?>" class="box">
                    <span>Date of Birth :</span>
                    <input type="date" name="update_dob" value="<?php echo $fetch['UserDOB']; ?>" class="box">

                    <span>Gender:</span>
                    <label class="gender-label">
                        <input type="radio" id="male" name="update_gender" value="M" <?php if ($fetch['UserGender'] === 'M')
                            echo 'checked'; ?> />
                        <span>Male</span>
                    </label>
                    <label class="gender-label">
                        <input type="radio" id="female" name="update_gender" value="F" <?php if ($fetch['UserGender'] === 'F')
                            echo 'checked'; ?> />
                        <span>Female</span>
                    </label>

                    <span>Phone :</span>
                    <input type="text" maxlength="10" minlength="10" name="update_phone"
                        value="<?php echo $fetch['UserPhone']; ?>" class="box">
                    <span>Address :</span>
                    <textarea name="update_address" class="box"><?php echo $fetch['UserAddress']; ?></textarea>
                    <span>Email :</span>
                    <input type="email" maxlength="30" name="update_email" value="<?php echo $fetch['UserEmail']; ?>"
                        class="box" readonly>
                </div>
            </div>
            <input type="submit" value="Update Profile" name="update_profile" class="btn">
            <a href="user.php" class="delete-btn">Go Back</a>
        </form>

    </div>

</body>

</html>