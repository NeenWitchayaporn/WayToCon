<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Venue | WayToCon Staff</title>
    <link rel="stylesheet" href="staff_create_new_venue.css">
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include_once('staffheader.php'); ?>
    <div class="container">
        <form action="staff_create_new_venue_db.php" method="POST">
            <div class="center">
                <h1>Create New Venue</h1>

                <h2>Venue Detail</h2>
                <img src="https://cdn-icons-png.flaticon.com/128/57/57055.png"
                    data-src="https://cdn-icons-png.flaticon.com/128/57/57055.png" alt="Down filled triangular arrow "
                    title="Down filled triangular arrow " width="30" height="30" class="lzy lazyload--done"
                    srcset="https://cdn-icons-png.flaticon.com/128/57/57055.png 4x">

                <div class="box">


                    <input type="text" id="location_name" name="location_name" placeholder="Venue name" require />


                    <img src="https://cdn-icons-png.flaticon.com/128/1159/1159633.png"
                        data-src="https://cdn-icons-png.flaticon.com/128/1159/1159633.png" alt="Edit " title="Edit "
                        width="25" height="25" class="lzy lazyload--done"
                        srcset="https://cdn-icons-png.flaticon.com/128/1159/1159633.png 4x"
                        style="position: absolute; top: 9.7%; left: 93%; transform: translate(-50%, -50%); filter: invert(70%)">
                    <p>Capacity</p>
                    <div class="text-small-venue">


                        <input type="text" id="location_capacity" name="location_capacity" placeholder="Capacity"
                            require />


                    </div>
                    <span class="text-behind">Seats</span>
                    <p>Address</p>


                    <textarea id="location_address" name="location_address" rows="10" cols="103" require></textarea>


                    <img src="https://cdn-icons-png.flaticon.com/128/1159/1159633.png"
                        data-src="https://cdn-icons-png.flaticon.com/128/1159/1159633.png" alt="Edit " title="Edit "
                        width="25" height="25" class="lzy lazyload--done"
                        srcset="https://cdn-icons-png.flaticon.com/128/1159/1159633.png 4x"
                        style="position: absolute; top: 53%; left: 93%; transform: translate(-50%, -50%); filter: invert(70%)">
                </div>



                <h2>Zone</h2>
                <img src="https://cdn-icons-png.flaticon.com/128/57/57055.png"
                    data-src="https://cdn-icons-png.flaticon.com/128/57/57055.png" alt="Down filled triangular arrow "
                    title="Down filled triangular arrow " width="30" height="30" class="lzy lazyload--done"
                    srcset="https://cdn-icons-png.flaticon.com/128/57/57055.png 4x">
                <div class="box">
                    <div class="text-small">
                        <div id="zones-container"></div>
                    </div>
                    <button type="button" id="add_zone_new_slot">Add New Zone</button>
                </div>
            </div>




            <div class='down'>
                <input type="submit" value="Create New Venue" class='create_new_venue mt-4' name="create_new_venue" />
                <div class='cancel'>
                    <a class="cancel_staff" href="all_venue.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <script src="staff_create_new_venue.js"></script>
</body>

</html>