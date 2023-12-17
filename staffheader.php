<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WayToConheader</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "staffheader.css">
    <link rel="preconnect" href="https://fonts.googleapis.com/" >
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
                <div class="container">
                    <div class="header-con">
                        <div class="logo-container">
                            <a href="staff.php">
                                <img src='./image/Logo.png' alt="Logo"/>
                            </a>
                        </div>
                        <div class="stafflogo-container">
                            <a href="staffprofile.php">
                                <img src='./image/StaffLogo.png' alt="Logo"/>
                            </a>
                        </div>
                        <div class="line-container">
                            <img src='./image/Line 3.png' alt=""/>
                        </div>
                            
                        <ul class= "menu">
                            <li class="menu-link" >
                                <a href="staffmember.php">Staff</a>
                            </li>

                            <li class="dropdown" >
                                <a href="#">Event</a>
                                <div class="dropdown-content">
                                    <a href="all_event.php">All Event</a>
                                    <a href="staffallevent.php">All Booking</a>
                                    <a href="event-sales-report.php">Event Sales Report</a>
                                </div>
                            </li>

                            <li class="dropdown" >
                                <a href="#">Gift Shop</a>
                                <div class="dropdown-content">
                                    <a href="all_product.php">All Product</a>
                                    <a href="staffallorder.php">All Order</a>
                                    <a href="giftshop-sales-report.php">Giftshop Sales Report</a>
                                </div>
                            </li>

                        <li class="menu-link">
                            <a href="all_venue.php">Venue</a>
                        </li>
                        <li class="menu-link">
                            <a href="staffdashboard.php">Dashboard</a>
                        </li>
                    </ul>
                    <div class="login-btn">
                        <a href="staff.php?logout='1'" class="login-btn">Log Out</a>
                    </div>
                </div>
            </div>
        </div> 
         
</body>
</html>