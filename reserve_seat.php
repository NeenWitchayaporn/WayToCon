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
    $roundselect = $_GET['show_time'];
    $zoneselect = $_GET['zone'];

    $all = "SELECT * FROM showinfo s JOIN location l ON s.locationID = l.LocationID WHERE s.ShowID = '$showid'";
    $query1 = mysqli_query($con,$all);
    $row1 = mysqli_fetch_array($query1);

    $Limit = $row1['LimitTicket'];

    $showtime = "SELECT * FROM showinfo s JOIN showtime t ON s.ShowID = t.ShowID WHERE t.ShowTimeID = '$roundselect' ORDER BY t.ShowDateTime";
    $query2 = mysqli_query($con,$showtime);
    $row2 = mysqli_fetch_array($query2);

    $zone = "SELECT * FROM showinfo s JOIN zoneforshow h ON s.ShowID = h.ShowID WHERE h.ZoneForShowID = '$zoneselect'";
    $query3 = mysqli_query($con,$zone);
    $row3 = mysqli_fetch_array($query3);

    $seat = "SELECT * FROM ((showtime t JOIN showinfo s ON t.ShowID = s.ShowID )JOIN zoneforshow h ON s.ShowID = h.ShowID) JOIN seatforshow f ON h.ZoneForShowID = f.ZoneForShowID JOIN seat z ON f.SeatID = z.SeatID WHERE s.ShowID = '$showid' AND t.ShowTimeID = $roundselect AND h.ZoneforShowID =  $zoneselect ";
    $query4 = mysqli_query($con,$seat); 
    
    $seat = "SELECT * FROM ((showtime t JOIN showinfo s ON t.ShowID = s.ShowID )JOIN zoneforshow h ON s.ShowID = h.ShowID) JOIN seatforshow f ON h.ZoneForShowID = f.ZoneForShowID JOIN seat z ON f.SeatID = z.SeatID WHERE s.ShowID = '$showid' AND t.ShowTimeID = $roundselect AND h.ZoneforShowID =  $zoneselect ";
    $query5 = mysqli_query($con,$seat);
    $row5 = mysqli_fetch_array($query5);

    $seat2 = "SELECT * FROM ((showtime t JOIN showinfo s ON t.ShowID = s.ShowID) JOIN zoneforshow h ON s.ShowID = h.ShowID) JOIN seatforshow f ON h.ZoneForShowID = f.ZoneForShowID JOIN seat z ON f.SeatID = z.SeatID WHERE s.ShowID = '$showid' AND t.ShowTimeID = $roundselect AND h.ZoneforShowID =  $zoneselect AND f.SeatForShowID NOT IN ( SELECT d.SeatForShowID From bookingdetail d JOIN booking b ON b.BookingID = d.BookingID WHERE b.Status != 0)";
    $query6 = mysqli_query($con,$seat2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Seat</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "reserve_seat.css">
    <link rel = "stylesheet" href = "css/bootstrap-grid.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com/" >
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include_once('header.php'); ?>
    
    <div class = "container-md " >
        <h1 class="font-weight-bold mtb-4"><?=$row1['ShowName'] ?></h1>
        <div class="row ">
                <div class="col-md-3 mt-4">
                    <div class="card">
                        <img src="image/<?=$row1['Poster'] ?>" width = "100%"alt="">
                        <div class="card-body">
                            <h2 class="card-title mt-2"><?=$row1['ShowName'] ?></h2>
                            <h5 class="card-title "><?=$row1['LocationName'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 mt-4">
                    <div class="booking">
                        <div class="inner-wrapper">
                        <div class="col-12">
                            <h3 class = "align-self-center">STEP 2  Select Seats</h3>
                            <div class="booking-body">
                                <div class="container" style = " padding-left : 0 px; margin-left : 0px">
                                    <div class="row">
                                        <div class="col seat-map-container">
                                            <div class="seat-map">
                                                <div class="seat-map-info">
                                                    <ul class="seat-type">
                                                        <li>
                                                            <span class="ico" style = "background-color : #ADFF00;"></span>
                                                            <span class="txt"><?=$row5['Price'] ?> THB </span>
                                                        </li>
                                                        <li>
                                                            <span class="ico ico-seat-select" style = "background-color : #00D1FF"></span>
                                                            <span class="txt">selected seat</span>
                                                        </li>
                                                        <li>
                                                            <span class="ico ico-not-available" style = "background-color : #FF0000"></span>
                                                            <span class="txt">not available seat</span>
                                                        </li>
                                                    </ul>
                                                    <div class="seat-map-stage">
                                                        <span class="txt">STAGE</span>
                                                    </div>
                                                    <div class="seat-map-body">
                                                    <form id="frmSeat" name="frmseat">
                                                        <div class="seat-table">
                                                        <table id="tableseats">
                                                            <tbody>
                                                            <?php
                                                            $rows = array();
                                                            while ($row6 = mysqli_fetch_array($query6)) {
                                                                $rows[] = $row6;
                                                            }
                                                            usort($rows, function ($a, $b) {
                                                                return strcmp($a['SeatRow'], $b['SeatRow']);
                                                            });

                                                            $currentRow = "";
                                                            $currentRowSeats = array();
                                                            foreach ($rows as $row6) {
                                                                if ($row6['SeatRow'] !== $currentRow) {
                                                                if ($currentRow !== "") {
                                                                    echo '<tr>';
                                                                    echo '<td class="headrow">' . $currentRow . '</td>';
                                                                    echo '<td class="skiprow" colspan="2"></td>';
                                                                    foreach ($currentRowSeats as $seat) {
                                                                    echo '<td title="' . $seat['SeatNo'] . '">';
                                                                    echo '<div class="seatuncheck" id="' . $seat['SeatForShowID'] . '" onclick="clicked(this)">';
                                                                    echo '<span>' . $seat['SeatNo'] . '</span>';
                                                                    echo '</div>';
                                                                    echo '</td>';
                                                                    }
                                                                    echo '</tr>'; 
                                                                }
                                                                $currentRow = $row6['SeatRow'];
                                                                $currentRowSeats = array();
                                                                }
                                                                $currentRowSeats[] = $row6;
                                                            }
                                                            if ($currentRow !== "") {
                                                                echo '<tr>';
                                                                echo '<td class="headrow">' . $currentRow . '</td>';
                                                                echo '<td class="skiprow" colspan="2"></td>';
                                                                foreach ($currentRowSeats as $seat) {
                                                                echo '<td title="' . $seat['SeatNo'] . '">';
                                                                echo '<div class="seatuncheck" id="' . $seat['SeatForShowID'] . '" onclick="clicked(this)">';
                                                                echo '<span>' . $seat['SeatNo'] . '</span>';
                                                                echo '</div>';
                                                                echo '</td>';
                                                                }
                                                                echo '</tr>';
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <h5 class = "align-self-center">Ticket Information</h5>
                            <div class="container-md">
                            <div class="ticketinfo col-11">
                                <table id = "Ticket-Info">
                                    <tbody >
                                        <tr>
                                            <th scope = "row">Round</th>
                                            <td><?=$row2['ShowDateTime']?></td>
                                            
                                        </tr>
                                        <tr>
                                            <th scope = "row">Zone</th>
                                            <td><?=$row5['ZoneForShowName']?></td>
                                            
                                        </tr>
                                        <tr>
                                            <th scope = "row">Seat No</th>
                                            <td ><ul id="seatNumbers"></ul></td>

                                        </tr>
                                        <tr>
                                            
                                            <th scope = "row">Quantity</th>
                                            <td id="quantity"></td>
                                            
                                        </tr>
                                        <tr>
                                            <th scope = "row">Unit Price (THB)</th>
                                            <td id="unitPrice"><?=$row5['Price']?></td>

                                        </tr>
                                        <tr>
                                            <th scope = "row">Total Price (THB)</th>
                                            <td id="totalPrice"></td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 mt-3 align-self-md-center">
                <a  href="#" onclick="window.history.back();" class="back-button mb-2">Back</a>
            </div>
            <div class="col-12 col-lg-6 mt-3 align-self-md-center">                                                                  
                    <a href="#" id = "nextButton" class="next-button mb-2" onclick="confirmseats()">Next</a>
            </div>
        </div>
    </div>                                                                            
        
        <script src = js/bootstrap-grid.min.js></script>
        <script>

            function clicked(element) {
                if (element.classList.contains('seatuncheck')) {
                    element.classList.remove('seatuncheck');
                    element.classList.add('seatchecked');
                } else if (element.classList.contains('seatchecked')) {
                    element.classList.remove('seatchecked');
                    element.classList.add('seatuncheck');
                }

                showTicketInformation();
            }

            function showTicketInformation() {
            var checkedSeats = document.getElementsByClassName("seatchecked");
            var quantity = checkedSeats.length;
            var unitPrice = parseInt(document.getElementById("unitPrice").textContent);
            var totalPrice = quantity * unitPrice;


            document.getElementById("quantity").textContent = quantity;
            document.getElementById("totalPrice").textContent = totalPrice;

            var seatNumbers = document.getElementById("seatNumbers");
            seatNumbers.innerHTML = "";

    
            for (var i = 0; i < checkedSeats.length; i++) {
                var seatNumber = checkedSeats[i].querySelector("span").textContent;
                var seatNumberElement = document.createElement("li");
                seatNumberElement.textContent = seatNumber;
                seatNumbers.appendChild(seatNumberElement);
            }
            return totalPrice;
            
            var nextButton = document.querySelector(".next-button");
            nextButton.addEventListener("click", markCheckedSeatsAsUnavailable);

            function markCheckedSeatsAsUnavailable() {
                var checkedSeats = document.getElementsByClassName("seatchecked"); 
                for (var i = 0; i < checkedSeats.length; i++) {
                    var seat = checkedSeats[i];
                    seat.classList.remove("seatchecked");
                    seat.classList.add("not-available");
                    }
            }
            }
            function confirmseats() {
                    var checkedSeats = document.getElementsByClassName("seatchecked");
                    var btn = document.getElementsByClassName("next-button");
                    var limit = "<?=$Limit ?>"

                    if(checkedSeats.length <= 0)
                    {
                        btn.classList.remove("next-button");
                        btn.classList.add("disabled next-button");   
                    }
                    else if(checkedSeats.length > limit)
                    {
                        btn.classList.remove("next-button");
                        btn.classList.add("disabled next-button");   
                        alert();
                    }
                    else{
                    var seatforshowIds = [];

                    for (var i = 0; i < checkedSeats.length; i++) {
                        var seatForShowId = checkedSeats[i].id;
                        seatforshowIds.push(seatForShowId);
                    }

                    var showid = "<?=$showid ?>";
                    var showtimeid = "<?=$roundselect ?>";
                    var zoneid = "<?=$zoneselect ?>";
                    var seatforshowid = seatforshowIds.join(",");

                    var url = "confirm-booking.php?id=" + showid + "&show_time=" + showtimeid + "&zone=" + zoneid + "&seatforshowid=" + seatforshowid;
                    window.location.href = url; 
                }
            }

            function alert()
            {
                window.alert("Maximum tickets per transaction, Pleaes complete this transaction before buying more tickets");
            }
            

        </script>
</body>
</html>
