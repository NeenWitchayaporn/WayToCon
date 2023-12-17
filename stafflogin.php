<?php
session_start();
include('server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>WayToCon</title>
  <link rel="icon" type="image/x-icon" href="image/template.png" />
  <link rel="stylesheet" href="stafflogin.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<div class="login-box">
  <?php if (isset($_SESSION['error'])): ?>
    <div class='error'>
      <h3>
        <?php
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
      </h3>
    </div>
  <?php endif ?>

  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <h2>Log in</h2>
  <form method="post" action="stafflogin_db.php">
    <div class="user-box">
      <input type="text" name="email" required />
      <label>Email</label>
    </div>

    <div class="user-box">
      <input type="password" name="password" required />
      <label>Password</label>
    </div>


    <div class="logo">
      <img src="image/staff.png" alt="Logo" style="width: 128px; height: 70px;">
    </div>

    <br>
    <br>
    <br>
    <br>

    <div class="LogIn">
      <button type="submit" name="login_staff" value="Log in"><span> Login </span></button>
    </div>


  </form>
</div>

</html>