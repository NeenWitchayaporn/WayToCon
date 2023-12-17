<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WayToConheader</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "header.css">

</head>
<body>
    <div class="header">
                <div class="container">
                    <div class="header-con">
                        <div class="logo-container">
                            <a href="index.php">
                                <img src='./image/Logo.png' alt="Logo"/>
                            </a>
                        </div>
                        <div class="line-container">
                            <img src='./image/Line 3.png' alt=""/>
                        </div>
                            
                        <ul class= "menu">
                            <li class="menu-link" onClick={closeMobileMenu}>
                                <a href="index.php">Home</a>
                            </li>

                            <li class="dropdown" >
                                <a href="index.php">Event</a>
                            </li>
                        <li class="menu-link">
                            <a href="giftshop.php">Gift Shop</a>
                        </li>
                        <li class="menu-link">
                            <a href="user.php">User</a>
                        </li>
                    </ul>
                    <div class="login-btn">
                        
                        <a href="index.php?logout='1'" class="login-btn">Log Out</a>
                    </div>
                </div>
            </div>
        </div> 
         
</body>
</html>