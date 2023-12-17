<?php
    session_start();
    include('server.php');
?>

<!DOCTYPE html>
<html lang="en"></html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WayToCon</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel="stylesheet" href="userregister.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  </head>

  <body>

    <div class="create-acc-container">
      <div class="create-acc-content">
        <div class="create-acc">
        <?php if(isset($_SESSION['error'])) : ?>
            <div class = 'error'>
                <h3>
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
          <h2>Create an Account</h2>
          <form method="post" action="userreg_db.php">
            <div class="user-box">
              <label class="col-md-4 control-label">First Name :</label>
              <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"
                    ><i class="glyphicon glyphicon-user"></i
                  ></span>
                  <input
                    name="first_name"
                    placeholder="First Name"
                    class="form-control"
                    type="text"
                    maxlength="20"
                    required
                  />
                </div>
              </div>
            </div>

            <div class="user-box">
              <label class="col-md-4 control-label">Last Name :</label>
              <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"
                    ><i class="glyphicon glyphicon-user"></i
                  ></span>
                  <input
                    name="last_name"
                    placeholder="Last Name"
                    class="form-control"
                    type="text"
                    maxlength="20"
                    required
                  />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label"
                >Date of Birth :<br
              /></label>
              <div class="col-md-4">
                <input type="date" name="dob" class="form-control" required/>
              </div>
            </div>

            <!-- <div class="form-group">
              <label class="col-md-4 control-label">Gender</label>
              <div class="col-md-4 selectContainer">
                <div class="input-group">
                  <span class="input-group-addon"
                    ><i class="glyphicon glyphicon-list"></i
                  ></span>
                  <select name="gender" class="form-control selectpicker">
                    <option value=" ">Please select your gender</option>
                    <option>Male</option>
                    <option>Female</option>
                  </select>
                </div>
              </div>
            </div> -->

            <div class="form-group">
              <label class="col-md-4 control-label">Gender :</label>
                <label>
                  <input type="radio" name="gender" value="M" checked="" />
                  <span>Male</span>
                </label>
                <label>
                  <input type="radio" name="gender" value="F"/>
                  <span>Female</span>
                </label>
              <br />
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Phone :</label>
              <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"
                    ><i class="glyphicon glyphicon-earphone"></i
                  ></span>
                  <input
                    name="phone"
                    placeholder="089-9XX-XXXX"
                    class="form-control"
                    type="text"
                    maxlength="10"
                    required
                  />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">ID Card :</label>
              <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"
                    ><i class="glyphicon glyphicon-envelope"></i
                  ></span>
                  <input
                    name="id_card"
                    placeholder="ID Card (13 characters)"
                    class="form-control"
                    type="text"
                    minlength="13"
                    maxlength="13"
                    required
                  />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">E-Mail :</label>
              <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"
                    ><i class="glyphicon glyphicon-envelope"></i
                  ></span>
                  <input
                    name="email"
                    placeholder="E-Mail Address"
                    class="form-control"
                    type="text"
                    maxlength="30"
                    required
                  />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Address :</label>
              <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"
                    ><i class="glyphicon glyphicon-pencil"></i
                  ></span>
                  <textarea
                    class="form-control"
                    name="address"
                    placeholder="address"
                    required
                  ></textarea>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Password :</label>
              <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"
                    ><i class="glyphicon glyphicon-lock"></i
                  ></span>
                  <input
                    name="password"
                    placeholder="Enter password (5 - 15 characters)"
                    class="form-control"
                    type="password"
                    minlength="5"
                    maxlength="15"
                    required
                  />
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-4 control-label">Confirm Password :</label>
              <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                  <span class="input-group-addon"
                    ><i class="glyphicon glyphicon-lock"></i
                  ></span>
                  <input
                    name="confirmPassword"
                    placeholder="Confirm password"
                    class="form-control"
                    type="password"
                    required
                  />
                </div>
              </div>
            </div>

            <!-- <a href="#">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              Create Account
            </a> -->









            <div class="center">
                        <!-- <div class="col-md-4 inputGroupContainer"> -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <button type="submit" name="reg_user" class="form-control create-acc">
                                    <span> Create Account </span>
                                </button>
                            </div>
                        <!-- </div> -->
                    </div>










            <!-- <div class="form-group">
              <div class="col-md-12 text-center"> -->
            <p style="text-align: center">
              Already have an account? <a href="userlogin.php">Log in</a>
            </p>
            <!-- </div>
            </div> -->
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
