<?php 
    include('server.php');
    session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }

    if(!isset($_SESSION['Role'])){
        $_SESSION['message'] = "You don't have permission";
        header('location:stafflogin.php');
    }

    $staffquery = 'SELECT * FROM staff s JOIN position p ON s.PositionID = p.PositionID';
    $result =  mysqli_query($con,$staffquery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WayToCon Staff</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "staffmember.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</head>
<body>
    <?php include_once('staffheader.php'); ?>
    <div class="container">
    
        <div class="h5 text-center mb-5 mt-5"> All Staff Member </div>
        <div class="card mb-4">
        <table id="datatablesSimple" class="table table-striped">
            <thead>
                <tr class="table-secondary">
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tfoot>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Email</th>

            </tfoot>

        <?php while($row = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?=$row['StaffID']?></td>
                <td><?=$row['StaffFirstName']?></td>
                <td><?=$row['StaffLastName']?></td>
                <td><?=$row['PositionName']?></td>
                <td><?=$row['StaffPhone']?></td>
                <td><?=$row['StaffEmail']?></td>
                <td><a class ='edit_staff mt=1' href="updatestaff.php?id=<?=$row['StaffID']?>">Edit</a></td>
                <td><a class ='delete_staff mt=1' href="deletestaff.php?id=<?=$row['StaffID']?>" onclick="confirmdel(this.href);return false;">Delete</a>   </td>
            </tr>
        <?php } ?>
        </table>
        </div>
        <a class ='add_staff mt-1 mb-3' href="addstaff.php">Add New Staff</a> <br><br> 
   
        </div>
</body>
</html>


<script> 
function confirmdel(page){
    var agree = confirm('Are you sure to delete this staff?');
    if(agree)
    {
        window.location = page;
    }
}

</script>