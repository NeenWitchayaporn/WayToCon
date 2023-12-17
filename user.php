<?php
session_start();
include('server.php');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = 'You must log in first';
    header('location: userlogin.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location: userlogin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WayToCon</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel="stylesheet" href="userlogin.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include_once('header.php'); ?>
    <div class="container"><br><br>
        <div class="profile">
            <?php
            $select = mysqli_query($con, "SELECT * FROM user WHERE UserID = '$user_id'") or die('Query failed');
            if (mysqli_num_rows($select) > 0) {
                $fetch = mysqli_fetch_assoc($select);
                echo '<img src="image/default-avatar.png">';
                echo '<h3>' . $fetch['UserFirstName'] . '</h3>';
            }
            ?>
            <a href="updateuser.php" class="btn">Update Profile</a>
            <a href="userallorder.php" class="btn2">Your Gift Shop Order</a>
            <a href="userallbooking.php" class="btn2">Your Event Booking</a>
            <a href="userlogin.php?logout=<?php echo $user_id; ?>" class="delete-btn">Logout</a>
            <p>New <a href="userlogin.php">login</a> or <a href="index.php">Go Home</a></p>
        </div>
    </div>
</body>

</html>