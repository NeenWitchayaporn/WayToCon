<?php
session_start();
if(!isset($_SESSION['StaffEmail'])){
    $_SESSION['message'] = 'You must log in first';
    header('location:stafflogin.php');
}
include('server.php');
$error = array();
if (isset($_POST['create_new_product'])) {
    $pdname = mysqli_real_escape_string($con, $_POST['newproduct_Name']);
    $pdcolID = mysqli_real_escape_string($con, $_POST['newproduct_colID']);
    $pddetail = mysqli_real_escape_string($con, $_POST['newproduct_detail']);
    $pdprice = mysqli_real_escape_string($con, $_POST['newproduct_price']);
    $stock = mysqli_real_escape_string($con, $_POST['newproduct_stock_item']);

    if (empty($pdname)) {
        array_push($error, "Please input the Product Name");
    }
    if (empty($pdcolID)) {
        array_push($error, "Please input the Product Collection");
    }
    if (empty($pddetail)) {
        array_push($error, "Please input the Product Detail");
    }
    if (empty($pdprice)) {
        array_push($error, "Please input the Product Price");
    }
    if (empty($stock)) {
        array_push($error, "Please input the Product Stock");
    }

    if (is_uploaded_file($_FILES['newproduct_image']['tmp_name'])) {
        $new_image_name = $_FILES['newproduct_image']['name'];
        $image_upload_path = "./image/" . $new_image_name;
        move_uploaded_file($_FILES['newproduct_image']['tmp_name'], $image_upload_path);
    } else {
        $new_image_name = "";
    }

    $pdname_query = mysqli_real_escape_string($con, $pdname);
    $new_image_query = mysqli_real_escape_string($con, $new_image_name);

    $pd_query = "SELECT * FROM giftshop WHERE ProductName = '$pdname_query' OR ProductPic = '$new_image_query'";
    $query = mysqli_query($con, $pd_query);
    $result = mysqli_fetch_assoc($query);

    if ($result) {
        if ($result['ProductName'] == $pdname) {
            array_push($error, "This Product Name is already in use");
        }
        if ($result['ProductPic'] == $new_image_name) {
            array_push($error, "This Picture of Product is already added");
        }
    }

    if (count($error) == 0) {

        $other = $_POST['new_collectionName'];
        if (!empty($other)) {
            $other = mysqli_real_escape_string($con, $other);
            $query = "INSERT INTO giftshopcollection (ProductColName) VALUES ('$other')";
            $result = mysqli_query($con, $query);

            if ($result) {
                $productCollectionID = mysqli_insert_id($con);

                // Insert the ProductCollectionID into the giftshop table
                $query = "INSERT INTO giftshop (ProductName, ProductCollectionID, ProductPrice, ProductDescription, ProductPic, Stock)
                VALUES ('$pdname', '$productCollectionID', '$pdprice','$pddetail','$new_image_name', '$stock')";

                $result2 = mysqli_query($con, $query);

                if (!$result2) {
                    die('Error: ' . mysqli_error($con));
                } else {
                    echo "<script> alert('Add New Product Successfully');</script>";
                    echo "<script>window.location='all_product.php';</script>";
                }
            }
        } else {
            $query = "INSERT INTO giftshop (ProductName, ProductCollectionID, ProductPrice, ProductDescription, ProductPic, Stock)
            VALUES ('$pdname', '$pdcolID', '$pdprice','$pddetail','$new_image_name', '$stock')";
            $result = mysqli_query($con, $query);
            if (!$result) {
                die('Error: ' . mysqli_error($con));
            } else {
                echo "<script> alert('Add New Product Successfully');</script>";
                echo "<script>window.location='all_product.php';</script>";
            }
        }
    } else {
        echo "<script> alert('Error! Please Try Again');</script>";
        echo "<script>window.location='staff_add_newPro.php';</script>";
    }
}
?>
