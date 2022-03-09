<?php

use App\Products;

session_start();
include('config.php');
include('classes/DB.php');
include('classes/User.php');
include('classes/Login.php');
include('classes/Admin.php');
include('classes/Products.php');

$queryWithID = "WHERE id = " . $_GET['id'] . " ";
$fetchProd = new Products();
$productArr = $fetchProd->fetchProducts($queryWithID);
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
          <h1 class="h2">Edit Product</h1>

          <span class="text-danger"><?php $prodMsg = isset($_SESSION['prodMsg']) ? $_SESSION['prodMsg'] : "";
                                    $_SESSION['prodMsg'] = "";
                                    echo $prodMsg; ?>
          </span>

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

        <form action="index.php" method="POST" class="row g-3">
          <div class="col-md-6">
            <label for="id" class="form-label">Product ID</label>
            <input type="text" class="form-control" id="id" name="id" 
            value="<?php echo $productArr[0]['id']; ?>" disabled>
          </div>
          <div class="col-md-6">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $productArr[0]['name']; ?>">
          </div>
          <div class="col-md-6">
            <label for="category" class="form-label">Product Category</label>
            <input type="text" class="form-control" id="category" name="category" 
            value="<?php echo $productArr[0]['category']; ?>">
          </div>
          <div class="col-md-6">
            <label for="price" class="form-label">Product Price</label>
            <input type="number" class="form-control" id="price" name="price" 
            value="<?php echo $productArr[0]['price']; ?>">
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary" name="updateProduct" 
            value="<?php echo $productArr[0]['id']; ?>">Update Product</button>
          </div>

        </form>
      </main>
    </div>
  </div>


  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js" 
  integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>