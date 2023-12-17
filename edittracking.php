<?php 
    include('server.php'); 
    session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }
    
    if(!isset($_GET['id'])){
        header('location:staffallorder.php');
    }  
    $sid = $_GET['id'];
    $sql = "SELECT * FROM giftshoporder g JOIN user u ON g.UserID = u.UserID WHERE OrderID = '$sid'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);

    $staffqr = "SELECT * FROM Staff";
    $rs = mysqli_query($con,$staffqr);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Shop Order | WayToCon Staff</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "stafforder.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js" ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com/" >
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</head>
<body>
<?php include_once('staffheader.php'); ?>
    <div class="h5 text-center mb-5 mt-5"> Edit Tracking Number </div>
    <form action="edittracking_db.php" method ="POST">
        <div class='container'>
        <div class='row'>
            <div class='col-sm-1'></div>
            <div class='col-sm-10'>
                <div class="form-group">
                    <label class="id">Order ID :</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="id" type="text" value=<?=$row['OrderID']?> readonly/>
                    </div>
                </div><br>

                <div class="form-group">
                    <label class="orderdt">Order Datetime :</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="orderdt" type="text" value="<?=$row['OrderDateTime']?>" readonly/>
                    </div>
                </div><br>

                <div class="form-group">
                    <label class="email">User E-Mail :</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="email" type="text" value="<?=$row['UserEmail']?>" readonly/>
                    </div>
                </div><br>

                <div class="form-group">
                    <label class="address">Shipping Detail :</label>
                    <div class="col-sm-8">
                        <textarea class="form-control mt-2" name="address" readonly><?=$row['Address']?></textarea>
                    </div>
                </div><br>
                <hr><br>

                <div class="form-group">
                    <label class="trackno">Tracking Number :</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="trackno" type="text" minlength='13' maxlength="13" placeholder="RG12XXXXXXXTH" required/>
                    </div>
                </div><br>


                <div class="form-group">
                    <label class="staff">Responsible Staff :</label>
                    <div  class="col-sm-8">
                        <select class="form-control mt-2" name="staff">
                        <?php
                            while ($rst = mysqli_fetch_assoc($rs)) {
                            $stid = $rst['StaffID'];
                            $stName = $rst['StaffFirstName']. ' '.$rst['StaffLastName'];
                            echo "<option value='$stid'>$stName</option>";
                            }
                        ?>
                        </select>
                    </div>
                </div><br><br>
                
                


                <div class="center">
                    <input type="submit" name="updatetrackno" value='Add Tracking Number' class='btn btn-outline-success'/>               
                    <a class ="btn btn-outline-secondary text-center" href="staffallorder.php">Cancel</a>  
                </div>
                
            </div>   

            </form>
    </div>
    </div>
    <br></br> <br></br> <br></br>
</body>
</html>
