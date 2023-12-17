<?php
    session_start();
    
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['StaffEmail']);
        header('location:stafflogin.php');
    }

    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }
    
    if(!isset($_SESSION['Role'])){
        $_SESSION['message'] = "You don't have permission";
        header('location:stafflogin.php');
    }

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
    <div class="h5 text-center mb-5 mt-5"> Add New Staff </div>
    <form action="addstaff_db.php" method ="POST">
        <div class='container'>
        <div class='row'>
            <div class='col-sm-1'></div>
            <div class='col-sm-10'>
                <div class="form-group">
                    <label class="first_name">First Name :</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="first_name" placeholder="First Name" type="text" maxlength="20" required />
                    </div>
                </div><br>
                

                <div class="form-group">
                    <label class="last_name">Last Name :</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="last_name" placeholder="Last Name" type="text" maxlength="20" required />
                    </div>
                </div><br>
            
                <div class="form-group">
                    <label class="dob">Date of Birth :<br/></label>
                    <div class="col-sm-4">
                        <input class="form-control mt-2" type="date" name="dob" required/>
                    </div>
                </div><br>
                
                <div class="form-group">
                    <label class="gender">Gender :<br/></label>
                    <div class='form-check form-check-inline'>
                        <label class="form-check-label"><input class="form-check-input" type="radio" name="gender" value="M" checked="" />
                        <span>Male</span>
                        </label>
                    </div>
                    <div class='form-check form-check-inline'>
                        <label class="form-check-label"><input class="form-check-input" type="radio" name="gender" value="F"/>
                        <span>Female</span>
                        </label>
                    </div>
                </div><br>

                <div class="form-group">
                    <label class="position">Position<br/></label>
                    <div  class="col-sm-6">
                        <select class="form-control mt-2" name="position">
                            <option value=1>Staff</option>
                            <option value=2>Administrator</option>
                        </select>
                    </div>
                </div><br>
                
                <div class="form-group">
                    <label class="">Phone :<br/></label>
                    <div class="col-sm-6">
                        <input class="form-control mt-2" name="phone" placeholder="089-9XX-XXXX"  type="text" maxlength="10" required/>
                    </div>
                </div><br>

                <div class="form-group">
                    <label class="">ID Card :<br/></label>
                    <div class="col-sm-6" >
                        <input class="form-control mt-2" name="id_card" placeholder="ID Card (13 characters)" type="text" minlength="13" maxlength="13" required/>
                    </div>
                </div><br>
                
                <div class="form-group">
                    <label class="">E-Mail :<br/></label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="email" placeholder="E-Mail Address" type="text" maxlength="30" required/>
                    </div>
                </div><br>

                <div class="form-group">
                    <label class="">Salary :</label>
                    <div  class="col-sm-4">
                        <input class="form-control mt-2" type="number" name="salary" placeholder="Salary (THB)" step="0.01" min='0' required>
                    </div>
                </div><br>
                <div class="form-group">
                    <label class="">Work Date :<br/></label>
                    <div class="col-sm-4">
                    <input class="form-control mt-2" type="date" name="workdate" required/> 
                    </div>

                </div><br>
                <div class="form-group">
                    <label class="">End Work Date (optional) : <br/></label>
                    <div class="col-sm-4">
                        <input class="form-control mt-2" type="date" name="endworkdate"/>
                    </div>
                    
                </div><br>

                <div class="form-group">
                    <label class="">Password :</label>
                    <div class="col-sm-8">
                        <input class="form-control mt-2" name="password" placeholder="Enter password (5 - 15 characters)" type="password" minlength="5" maxlength="15" required/>
                    </div>
                    
                </div><br>

                <div class="center">
                    <input type="submit" name="add_staff" value='Add Staff' class='add_staff mt-4'/>               
                    <a class ="cancel_staff mr-4" href="staffmember.php">Cancel</a>  
                </div>
                
            </div>   

            </form>
    </div>
    </div>
    <br></br> <br></br> <br></br>
</body>
</html>