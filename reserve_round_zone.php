<?php
    include('server.php');
    session_start();

    if(!isset($_SESSION['UserEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:userlogin.php');
    }

    if(!isset($_GET['id'])){
        header('location:index.php');
    }
?>

<?php 
    $showid = $_GET['id'];
    $all = "SELECT * FROM showinfo s JOIN location l ON s.locationID = l.LocationID WHERE s.ShowID = '$showid'";
    $query1 = mysqli_query($con,$all);
    $row1 = mysqli_fetch_array($query1);

    $showtime = "SELECT * FROM showinfo s JOIN showtime t ON s.ShowID = t.ShowID WHERE s.ShowID = '$showid' ORDER BY t.ShowDateTime";
    $query2 = mysqli_query($con,$showtime);

    $zone = "SELECT * FROM showinfo s JOIN zoneforshow h ON s.ShowID = h.ShowID WHERE s.ShowID = '$showid'";
    $query3 = mysqli_query($con,$zone);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Round and Zone</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "reserve_round_zone.css">
    <link rel = "stylesheet" href = "css/bootstrap-grid.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com/" >
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include_once('header.php'); ?>
    <div class = container-fluid>
        <h1 class="font-weight-bold mb-2"><?= $row1['ShowName'] ?></h1>
        <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <img src="image/<?= $row1['Poster'] ?>" width = "100%"alt="">
                        <div class="card-body">
                            <h2 class="card-title mt-2"><?= $row1['ShowName'] ?></h2>
                            <h4 class="card-title "><?= $row1['LocationName'] ?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 ">
                    <div class="inner-wrapper">
                        <div class="col-12">
                            <h3 class = "align-self-center">STEP 1  Select Round and Zone</h3>
                            <div class="box">
                                <div class="row">
                                    <div class="col-5">
                                        <form action="" method="get">
                                            <select id="show_time" name="show_time">
                                            <?php while($row2 = mysqli_fetch_array($query2)) { ?>
                                                <option value="<?= $row2['ShowtimeID'] ?>"><?= $row2['ShowDateTime'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="id" value="Choose options">
                                        </form>
                                    </div>
                                    <div class="col-4 ">
                                    <form action="" method="get">
                                        <select id="zone" name="zone">
                                        <?php while($row3 = mysqli_fetch_array($query3)) { ?>
                                            <option value="<?= $row3['ZoneForShowID'] ?>"><?= $row3['ZoneForShowName'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="id" value="Choose options">
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <h4 class = "align-self-center">preview</h4>
                            <img src="image/<?= $row1['SeatingMap'] ?>" width = "60%"alt="">
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 mt-3 align-self-md-center">
                <a href="user_concert_detail.php" class="back-button mb-2">Back</a>
            </div>

            <div class="col-12 col-lg-6 mt-2 align-self-md-center">
                <a id="next" href="reserve_seat.php?id=<?= $row1['ShowID'] ?>" onclick="addQueryParams(event)" class="next-button mb-2">Next</a>
            </div>
        </div>
        
    </div> 
        <script src = js/bootstrap-grid.min.js></script>
        <script>
        function addQueryParams(event) {
            event.preventDefault();
            var showTime = encodeURIComponent(document.getElementById('show_time').value);
            var zone = encodeURIComponent(document.getElementById('zone').value);
            var nextUrl = document.getElementById('next').getAttribute('href');
            nextUrl += '&show_time=' + showTime + '&zone=' + zone;
            location.href = nextUrl;
        }
</script>
        
</body>
</html>

