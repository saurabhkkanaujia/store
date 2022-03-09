<?php

use App\Admin;

session_start();
include('config.php');
include('classes/DB.php');
include('classes/Admin.php');

if ($_SESSION['user']['role'] != 'admin') {
    $_SESSION['msg'] = "Please Signin as Admin First";
    header('Location: admin/login.php');
}

$orderObj = new Admin();
$orderArray = $orderObj->fetchOrders();

if (!isset($_SESSION['val'])) {
    $_SESSION['val'] = 1;
}

if (isset($_POST['pagination'])) {
    if ($_POST['pagination'] == 'prev') {
        $_SESSION['val'] -= 1;
    } elseif ($_POST['pagination'] == 'next') {
        $_SESSION['val'] += 1;
    } else {
        $_SESSION['val'] = $_POST['pagination'];
    }
}
$val = $_SESSION['val'];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Dashboard Template · Bootstrap v5.1</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">



    <!-- Bootstrap core CSS -->
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="./assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

    <?php include 'header.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php include 'sidebar.php' ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="d-flex justify-content-between flex-wrap 
                flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Orders</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar"></span>
                            This week
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <form action="index.php" method="POST">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">User ID</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Post Code</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($orderArray as $key => $value) {
                                    if ($key >= 5 * ($val - 1) && $key < (5 * $val)) {
                                        echo "<tr>
                  <td>" . $value['order_id'] . "</td>
                  <td>" . $value['id'] . "</td>
                  <td>" . $value['username'] . "</td>
                  <td>" . $value['email'] . "</td>
                  <td>" . $value['name'] . "</td>
                  <td>" . $value['category'] . "</td>
                  <td>" . $value['quantity'] . "</td>
                  <td>" . $value['billing_address_1'] . "<br>" . $value['billing_address_2'] . "</td>
                  <td>" . $value['billing_postcode'] . "</td>
                  <td>" . $value['billing_phone'] . "</td>
                  <td>" . $value['status'] . "</td>
                  
                  ";
                                        if ($value['status'] == "Pending") {
                                            echo "<td><button class='btn btn-danger' type='submit' 
                                            name = 'delivered' value = " . $value['order_id'] . ">Pending</button>
                  
                  ";
                                        } else {
                                            echo "<td><button class='btn btn-success' type='submit' 
                                            name = 'pending' value = " . $value['order_id'] . ">Delivered</button>
                ";
                                        }
                                    }
                                }

                                ?>
                            </tbody>
                        </table>
                    </form>
                    <nav aria-label="Page navigation example">
                        <form action="" method="POST">
                            <ul class="pagination">
                                <?php if ($val > 1) { ?>
                                    <li class="page-item"><button class="page-link" 
                                    name="pagination" value="prev">Previous</button></li>
                                <?php } ?>

                                <?php $ind = 1;
                                for ($i = 0; $i < count($orderArray); $i += 5) {
                                        ?>

                                    <li class="page-item"><button class="page-link" name="pagination" 
                                    value="<?php echo $ind; ?>"><?php echo $ind; ?></button></li>
                                <?php $ind += 1;
                                } ?>

                                <?php if ((floor(count($orderArray) / 5) + 1) != $val) {
                                        ?>
                                    <li class="page-item"><button class="page-link" 
                                    name="pagination" value="next">Next</button></li>
                                    <?php } ?>
                            </ul>
                        </form>
                    </nav>

            </main>
        </div>
    </div>


<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js" 
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
crossorigin="anonymous"></script>
</body>

</html>