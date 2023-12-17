<?php
include('server.php');
session_start();
    if(!isset($_SESSION['StaffEmail'])){
        $_SESSION['message'] = 'You must log in first';
        header('location:stafflogin.php');
    }
$pdid = $_GET['id'];
$sql = "SELECT * FROM giftshop g JOIN giftshopcollection gcol ON g.ProductCollectionID = gcol.ProductCollectionID WHERE ProductID = '$pdid'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="icon" type="image/x-icon" href="image/template.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="updateproduct.css">
</head>

<body>
    <?php include_once('staffheader.php'); ?>
    <div class="h5 text-center mb-5 mt-5"> Edit Product Information </div>
    <form action="updateproduct_db.php" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="form-group">

                        <div class="box">
                            <label class="label">Product ID :</label>
                            <input class="tex1" type="text" name="id" value="<?= $row['ProductID'] ?>" readonly />
                        </div>

                        <div class="form-group">
                            <div class="box upload-box1">
                                <label class="label1" for="newproduct_image">Product Image:</label>
                                <img id="output" class="img-fluid" src="image/<?= $row['ProductPic'] ?>" />
                                <input type="hidden" name="old_product_image" value="<?= $row['ProductPic'] ?>">
                                <label class="label1" for="newproduct_image">Change Picture:</label>
                                <input type="file" id="newproduct_image" name="newproduct_image" accept="image/png, image/jpg" onchange="loadFile(event)">

                                <script>
                                    var loadFile = function(event) {
                                        var image = document.getElementById('output');
                                        var input = event.target;

                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function(e) {
                                                var img = new Image();

                                                img.onload = function() {
                                                    var maxWidth = 250;
                                                    var maxHeight = 300;
                                                    var width = img.width;
                                                    var height = img.height;

                                                    if (width > maxWidth || height > maxHeight) {
                                                        var ratio = Math.min(maxWidth / width, maxHeight / height);
                                                        width *= ratio;
                                                        height *= ratio;
                                                    }

                                                    image.style.width = width + 'px';
                                                    image.style.height = height + 'px';
                                                    image.src = e.target.result;
                                                };

                                                img.src = e.target.result;
                                            };

                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    };
                                </script>




                            </div>
                        </div>


                        <h2>Product Name</h2>
                        <div class="box">
                            <input class="tex1" type="text" id="newproduct_Name" name="newproduct_Name" value="<?= $row['ProductName']?>" placeholder="Product Name" required>
                        </div>

                        <h2>Product Details</h2>
                        <div class="box">
                            <label class="label">Collection:</label>
                            <select id="newproduct_collection" name="newproduct_colID" required>
                                <option value="<?= $row['ProductCollectionID'] ?>"><?= $row['ProductColName'] ?></option>
                                <?php
                                $sql_collection = "SELECT * FROM giftshopcollection ORDER BY ProductColName";
                                $result_collection = mysqli_query($con, $sql_collection);
                                while ($collection_row = mysqli_fetch_array($result_collection)) {
                                ?>
                                    <option value="<?= $collection_row['ProductCollectionID'] ?>"><?= $collection_row['ProductColName'] ?></option>
                                <?php
                                }
                                mysqli_close($con);
                                ?>
                                <option value="new_collection">Other</option>
                            </select>

                            <div id="inputField" style="display: none;">
                                <input class="tex1" type="text" id="new_collectionName" name="new_collectionName" placeholder="New Collection Name">
                            </div>
                            <script>
                                document.getElementById('newproduct_collection').addEventListener('change', function() {
                                    var x = document.getElementById("inputField");
                                    if (this.value === "new_collection") {
                                        x.style.display = "block";
                                    } else {
                                        x.style.display = "none";
                                    }
                                });
                            </script>

                            <br>
                            <textarea class="textarea2" id="newproduct_detail" name="newproduct_detail" rows="10" cols="103" placeholder="Product Detail" required><?= $row['ProductDescription'] ?></textarea>
                        </div>

                        <h2>Price</h2>
                        <div class="box2">
                            <div class="form-group">
                                <input class="tex" type="number" id="newproduct_price" name="newproduct_price" min="1" value=<?= $row['ProductPrice'] ?> placeholder="Price" required size="20">
                                <label class="label2">THB</label>
                            </div>
                        </div>


                        <h2>Stock</h2>
                        <div class="box2">
                            <div class="form-group">
                                <input class="num" type="number" id="newproduct_stock_item" name="newproduct_stock_item" min="0" max="9999" value=<?= $row['Stock'] ?> placeholder="Quantity (0 - 9999)" required>
                                <label class="label2">Items</label>
                            </div>
                        </div>

                        <br><br>
                        <div class="form-group2">
                            <input class="add_pd" type="submit" name="update_product" id="update_product" value="Update">
                            <button class="cancel_add" type="reset" onclick="location.href='all_product.php'">Cancel</button>
                        </div>


                        <br><br><br><br>
                    </div>
                </div>
            </div>
        </div>
    </form>

</body>

</html>