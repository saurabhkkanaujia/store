<?php

use App\Products;

session_start();
include('config.php');
include('classes/DB.php');
include('classes/Admin.php');
include('classes/Products.php');
if ($_SESSION['user']['role'] != 'admin') {
    $_SESSION['msg'] = "Please Signin as Admin First";
    header('Location: admin/login.php');
}
$fetchObj = new Products();
echo isset($_SESSION['message']) ? $_SESSION['message'] : "";


if (empty($_SESSION['prodArr'])) {
    $query = "";
    $prodArr = $fetchObj->fetchProducts($query);
    $_SESSION['prodArr'] = $prodArr;
}

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

if ((isset($_POST['action'])) && ($_POST['action'] == 'searchProd')) {
    $searchVal = $_POST['searchField'];
    $query = "WHERE id LIKE '%" . $_POST['searchField'] . "%' OR 
    name LIKE '%" . $_POST['searchField'] . "%' OR category LIKE '%" . $_POST['searchField'] . "%' ";
    $prodArr = $fetchObj->fetchProducts($query);
    $_SESSION['prodArr'] = $prodArr;
}

$prodArr = $_SESSION['prodArr'];

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
    <link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">


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

        .prodImg {
            height: 100px;
            width: 100px;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

    <?php include 'header.php' ?>

    <?php include 'sidebar.php' ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap
         flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Products</h1>
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

        <form action="" method="POST" class="row row-cols-lg-auto g-3 align-items-center">
            <div class="col-12">
                <label class="visually-hidden" for="inlineFormInputGroupUsername">Search</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="inlineFormInputGroupUsername" 
                    name="searchField" placeholder="Enter id,name...">
                </div>
            </div>



            <div class="col-12">
                <button type="submit" name="action" value="searchProd" class="btn btn-primary">Search</button>
            </div>
            <div class="col-12">
                <a class="btn btn-success" href="add-product.php">Add Product</a>
                <span class="text-success"><?php $prodMsg = isset($_SESSION['prodMsg']) ? $_SESSION['prodMsg'] : "";
                                            $_SESSION['prodMsg'] = "";
                                            echo $prodMsg; ?></span>
            </div>
        </form>
        <div class="table-responsive">
            <form action="index.php" method="POST">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($prodArr as $key => $value) {
                            if ($key >= 5 * ($val - 1) && $key < (5 * $val)) {
                                echo "<tr>
                  <td>" . $value['id'] . "</td>
                  <td>" . $value['name'] . "</td>
                  <td><img class='img-fluid prodImg' src='./uploads/" . $value['imgName'] . "'></td>
                  <td>" . $value['category'] . "</td>
                  <td>" . $value['price'] . "</td>
                  <td>
                    <a class = 'btn btn-primary' href='edit-product.php?id=" . $value['id'] . "'>Edit</a>
                    <button class = 'btn btn-danger' type='submit' name = 'deleteProd' 
                    value = " . $value['id'] . ">Delete</button>
                  </td>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
            <nav aria-label="Page navigation example">
                <form action="" method="POST">
                    <ul class="pagination">
                        <?php if ($val > 1) {
                            ?>
                            <li class="page-item"><button class="page-link" 
                            name="pagination" value="prev">Previous</button></li>
                        <?php } ?>

                        <?php $ind = 1;
                        for ($i = 0; $i < count($prodArr); $i += 5) {
                            ?>

                            <li class="page-item"><button class="page-link" name="pagination" 
                            value="<?php echo $ind; ?>">
                            <?php echo $ind; ?></button></li>
                        <?php $ind += 1;
                        } ?>

                        <?php if ((floor(count($prodArr) / 5) + 1) != $val) {
                            ?>
                            <li class="page-item"><button class="page-link" 
                            name="pagination" value="next">Next</button></li>
                        <?php } ?>
                    </ul>
                </form>
            </nav>
        </div>
    </main>
    </div>
    </div>


    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
    crossorigin="anonymous"></script>
</body>

</html>