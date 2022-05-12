<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-danger">
        <div class="container">
            <a href="index.php" class="navbar-brand"><img src="images/course.jpg" width="60px" height="60px" alt=""></a></a>
            <a href="" class="navbar-brand"><b>Course Finder</b></a>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="">title</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="">instructor</label>
                                <input type="text" name="instructor" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="">images</label>
                                <input type="file" name="images" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="">description</label>
                                <input type="text" name="description" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="">price</label>
                                <input type="text" name="price" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="">duration</label>
                                <input type="text" name="duration" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="">discountprice</label>
                                <input type="text" name="discountprice" class="form-control">
                            </div>
                            <div class="mb-3">

                                <input type="submit" name="send" class="btn btn-warning w-100">
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['send'])) {
                            $image = $_FILES['images']['name'];
                            $temp_image = $_FILES['images']['tmp_name'];
                            move_uploaded_file($temp_image, "images/$image");
                            $data = [
                                'title' => $_POST['title'],
                                'instructor' => $_POST['instructor'],
                                'description' => $_POST['description'],
                                'price' => $_POST['price'],
                                'discountprice' => $_POST['discountprice'],
                                'duration' => $_POST['duration'],
                                'images' => $image,
                            ];
                            insert("courses", $data);
                        }
                        ?>

                    </div>
                </div>
            </div>

            <div class="col-9">
                <h5>Manage Course</h5>
                <div class="row">
                    <?php
                    $callingCourse = calling("courses");
                    foreach ($callingCourse as $value) {
                    ?>
                        <div class="col-3">
                            <div class="card">
                             <img src="images/<?= $value['images']; ?>" style="object-fit:cover;height:180px" alt="" class="w-100">
                                <div class="card-body">
                                    <h6><?= $value['title']; ?></h6>
                                    <h4>Rs.<?= $value['discountprice']; ?> <del><?= $value['price']; ?>/-</del></h4>
                                    <form action="paytmkit/pgRedirect.php" method="POST">
                                        <input type="text" name="ORDER_ID" value="<?= uniqid();?>" hidden>
                                        <input type="text" name="CUST_ID" value="<?= uniqid();?>" hidden>
                                        <input type="text" name="TXN_AMOUNT" value="<?= $value['discountprice'];?>" hidden>
                                        <input type="submit" value="paynow" class="btn btn-success">
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>