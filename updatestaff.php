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
    $sid = $_GET['id'];
    $sql = "SELECT * FROM Staff WHERE StaffID = '$sid'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel = "stylesheet" href = "staffmember.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<?php include_once('staffheader.php'); ?>
    <div class="h5 text-center mb-5 mt-5"> Edit Staff Information </div>
    <form action="updatestaff_db.php" method ="POST">
        <div class='container'>
        <div class='row'>
            <div class='col-sm-1'></div>
            <div class='col-sm-10'>
                <div class="form-group">
                    <label class="id">Staff ID :</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="id" type="text" value=<?=$row['StaffID']?> readonly/>
                    </div>
                </div><br>
                <div class="form-group">
                    <label class="first_name">First Name :</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="first_name" type="text" maxlength="20" value="<?=$row['StaffFirstName']?>"/>
                    </div>
                </div><br>
                

                <div class="form-group">
                    <label class="last_name">Last Name :</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="last_name" type="text" maxlength="20" value="<?=$row['StaffLastName']?>" />
                    </div>
                </div><br>
            
                <div class="form-group">
                    <label class="dob">Date of Birth :<br/></label>
                    <div class="col-sm-4">
                        <input class="form-control mt-2" type="date" name="dob" value="<?php echo $row['StaffDOB']; ?>"/>
                    </div>
                </div><br>
                
                <div class="form-group">
                    <label class="gender">Gender :<br/></label>
                    <div class='form-check form-check-inline'>
                        <label class="form-check-label"><input class="form-check-input" type="radio" name="gender" value="M" <?php if ($row['StaffGender'] === 'M') echo 'checked'; ?>/>
                        <span>Male</span>
                        </label>
                    </div>
                    <div class='form-check form-check-inline'>
                        <label class="form-check-label"><input class="form-check-input" type="radio" name="gender" value="F" <?php if ($row['StaffGender'] === 'F') echo 'checked'; ?>/>
                        <span>Female</span>
                        </label>
                    </div>
                </div><br>

                <div class="form-group">
                    <label class="position">Position<br/></label>
                    <div  class="col-sm-6">
                        <select class="form-control mt-2" name="position">
                            <option value=1 <?php if ($row['PositionID'] == 1) echo 'selected'; ?>>Staff</option>
                            <option value=2 <?php if ($row['PositionID'] == 2) echo 'selected'; ?>>Administrator</option>
                        </select>
                    </div>
                </div><br>
                
                <div class="form-group">
                    <label class="">Phone :<br/></label>
                    <div class="col-sm-6">
                        <input class="form-control mt-2" name="phone" type="text" maxlength="10" value="<?=$row['StaffPhone']?>"/>
                    </div>
                </div><br>

                <div class="form-group">
                    <label class="">ID Card :<br/></label>
                    <div class="col-sm-6" >
                        <input class="form-control mt-2" name="id_card" type="text" minlength="13" maxlength="13" value="<?=$row['StaffIDcard']?>"/>
                    </div>
                </div><br>
                
                <div class="form-group">
                    <label class="">E-Mail :<br/></label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="email" type="text" maxlength="30" value="<?=$row['StaffEmail']?>"/>
                    </div>
                </div><br>

                <div class="form-group">
                    <label class="">Salary :</label>
                    <div  class="col-sm-4">
                        <input class="form-control mt-2" type="number" name="salary" step="0.01" min='0' value=<?=$row['StaffSalary']?>>
                    </div>
                </div><br>
                <div class="form-group">
                    <label class="">Work Date :<br/></label>
                    <div class="col-sm-4">
                    <input class="form-control mt-2" type="date" name="workdate" value="<?php echo $row['StaffWorkDate']; ?>"/> 
                    </div>

                </div><br>
                <div class="form-group">
                    <label class="">End Work Date (optional) : <br/></label>
                    <div class="col-sm-4">
                        <input class="form-control mt-2" type="date" name="endworkdate" value="<?php echo $row['EndWorkDate']; ?>"/>
                    </div>
                    
                </div><br>

                <!-- <div class="form-group">
                    <label class="">Password :</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="password" type="password" minlength="5" maxlength="15" />
                    </div>
                    
                </div><br> -->

                <div class="center">
                    <input type="submit" name="update_staff" value='Update' class='add_staff mt-4'/>               
                    <a class ="cancel_staff mr-4" href="staffmember.php">Cancel</a>  
                </div>
                
            </div>   

            </form>
    </div>
    </div>
    <br></br> <br></br> <br></br>
</body>
</html>