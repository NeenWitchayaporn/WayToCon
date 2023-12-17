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
    <link rel="stylesheet" href="userlogin.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com/" >
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  </head>

  <div class="login-box">
    <?php if(isset($_SESSION['error'])) : ?>
            <div class = 'error'>
                <h3>
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <?php if(isset($_SESSION['message'])) : ?>
            <div class = 'error'>
                <h3>
                    <?php
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    ?>
                </h3>
            </div>
        <?php endif ?>

    <h2>Log in</h2>
    <form method="post" action="userlogin_db.php">
      <div class="user-box">
        <input type="text" name="email" required />
        <label>Email</label>
      </div>

      <div class="user-box">
        <input type="password" name="password" required/>
        <label>Password</label>
      </div>

      <div class="LogIn">
        <button type="submit" name="login_user" value="Log in"><span> Login </span></button>
      </div>

      <div>
        <p style="text-align: center">
          Don't have an account?
          <a href="userregister.php" class="register-link">
            Create an Account
          </a>
        </p>
      </div>
    </form>
  </div>
</html>
