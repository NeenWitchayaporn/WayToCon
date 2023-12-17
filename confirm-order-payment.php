<?php 
    include('server.php'); 
    session_start();
    
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['UserEmail']);
        header('location:userlogin.php');
    }

    if(!isset($_SESSION['UserEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:userlogin.php');
    }

    if(!isset($_GET['id'])){
        header('location:userallorder.php');
    }  
    $sid = $_GET['id'];
    $sql = "SELECT * FROM giftshoporder g WHERE OrderID = '$sid'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Order | WayToCon</title>
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
<?php include_once('header.php'); ?>
    <div class="h5 text-center mb-5 mt-5"> Confirm Payment </div>
    <form action="confirmorder_db.php" method ="POST">
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
                    <label class="address">Shipping Detail :</label>
                    <div class="col-sm-8">
                        <textarea class="form-control mt-2" name="address" readonly><?=$row['Address']?></textarea>
                    </div>
                </div><br>
                <hr><br>

                <div class="form-group">
                    <label class="trackno">Purchase DateTime:</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="purchasedt" type="datetime-local" required/>
                    </div>
                </div><br>


                <div class="form-group">
                    <label class="staff">Pyament Amount :</label>
                    <div  class="col-sm-8">
                        <input class="form-control mt-2" name="payment" type="number" step="0.01" min="0" required/>
                    </div>
                </div><br><br>
                
                


                <div class="center">
                    <input type="submit" name="confirmpay" value='Confirm Payment' class='btn btn-outline-success'/>               
                    <a class ="btn btn-outline-secondary text-center" href="userallorder.php">Cancel</a>  
                </div>
                
            </div>   

            </form>
    </div>
    </div>
    <br></br> <br></br> <br></br>
</body>
</html>
