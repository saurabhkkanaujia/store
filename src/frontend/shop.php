<?php

use App\Products;

session_start();
include('../config.php');
include('../classes/DB.php');
include('../classes/User.php');
include('../classes/Login.php');
include('../classes/Admin.php');
include('../classes/Products.php');

$_SESSION['path'] = $_SERVER['PHP_SELF'];

$fetchObj = new Products();
if (!(isset($_SESSION['shopProdArr'])) || !empty($_SESSION['shopProdArr'])) 
{
    $query = "";
    $prodArr1 = $fetchObj->fetchProducts($query);
    $_SESSION['shopProdArr'] = $prodArr1;
}

if (!isset($_SESSION['mval'])) {
    $_SESSION['mval'] = 1;
}

if (isset($_POST['pagination'])) {
    if ($_POST['pagination'] == 'prev') {
        $_SESSION['mval'] -= 1;
    } elseif ($_POST['pagination'] == 'next') {
        $_SESSION['mval'] += 1;
    } else {
        $_SESSION['mval'] = $_POST['pagination'];
    }
}
$val = $_SESSION['mval'];

if ((isset($_POST['action'])) && ($_POST['action'] == 'searchProd')) {
    $searchVal = $_POST['searchField'];
    $dropdown = $_POST['dropdown'];
    switch ($dropdown) {
        case "price":
            $filter = "price";
            break;
        case "recent":
            $filter = "id DESC";
            break;

        case "category":
            $filter = "category";
            break;
        default:
            $filter = "id DESC";
    }

    $query = "WHERE id LIKE '%" . $_POST['searchField'] . "%' OR name LIKE '%" . $_POST['searchField'] . "%' OR category LIKE '%" . $_POST['searchField'] . "%' ORDER BY " . $filter . "";
    $prodArr = $fetchObj->fetchProducts($query);
    $_SESSION['shopProdArr'] = $prodArr;
}

$prodArr = $_SESSION['shopProdArr'];



?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop Page- Ustora Demo</title>

    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .prodImg {
            height: 150px;
        }
    </style>
</head>

<body>

    <?php include 'front_header.php' ?>
    <!-- End mainmenu area -->

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Shop</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="single-product-area">

        <div class="zigzag-bottom"></div>

        <div class="container">
            <form action="" method="POST" class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-md-4">
                    <label class="visually-hidden" for="inlineFormInputGroupUsername">Search</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="inlineFormInputGroupUsername" name="searchField" placeholder="Enter id,name...">
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="visually-hidden" for="inlineFormSelectPref">Sort By</label>
                    <select class="form-select" id="inlineFormSelectPref" name="dropdown">
                        <option selected>Sort By</option>
                        <option value="price">Price</option>
                        <option value="recent">Recently Added</option>
                        <option value="category">Category</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" name="action" value="searchProd" class="btn btn-primary">Search</button>
                </div>


            </form>

            <div class="row">
                <?php
                foreach ($prodArr as $key => $value) {
                    if ($key >= 4 * ($val - 1) && $key < (4 * $val)) {

                        echo '<form action="../index.php" method="POST">

                            <div class="col-md-3 col-sm-6">
                                    <div class="single-shop-product">
                                        <div class="product-upper">
                                        <img class="img-fluid prodImg" src="../uploads/' . $value['imgName'] . '">
                                        </div>
                                        <h2><a href="single-product.php?id=' . $value['id'] . '" name="prodName">' . $value['name'] . '</a></h2>
                                        <div class="product-carousel-price">
                                            <ins>₹' . $value['price'] . '</ins> <del>$999.00</del>
                                        </div>
                
                                        <div class="product-option-shop">
                                            <button class="add_to_cart_button" rel="nofollow"
                                             name="action" value="addToCart">Add to cart </button>
                                            <input type="hidden" name="prodID" value=' . $value['id'] . '>                                        
                                        </div>
                                    </div>
                                </div>
                                </form>';
                    }
                }
                ?>

            </div>



            <div class="row">
                <div class="col-md-12">
                    <div class="product-pagination text-center">
                        <nav aria-label="Page navigation example">
                            <form action="" method="POST">
                                <ul class="pagination">
                                    <?php if ($val > 1) { ?>
                                        <li class="page-item"><button class="page-link" name="pagination" value="prev">Previous</button></li>
                                    <?php } ?>

                                    <?php $ind = 1;
                                    for ($i = 0; $i < count($prodArr); $i += 4) { ?>

                                        <li class="page-item"><button class="page-link" name="pagination" value="<?php echo $ind; ?>"><?php echo $ind; ?></button></li>
                                    <?php $ind += 1;
                                    } ?>

                                    <?php if ((floor(count($prodArr) / 4) + 1) != $val) { ?>
                                        <li class="page-item"><button class="page-link" name="pagination" value="next">Next</button></li>
                                    <?php } ?>
                                </ul>
                            </form>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="footer-top-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="footer-about-us">
                        <h2>u<span>Stora</span></h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis sunt id doloribus vero quam laborum quas alias dolores blanditiis iusto consequatur, modi aliquid eveniet eligendi iure eaque ipsam iste, pariatur omnis sint! Suscipit, debitis, quisquam. Laborum commodi veritatis magni at?</p>
                        <div class="footer-social">
                            <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">User Navigation </h2>
                        <ul>
                            <li><a href="">My account</a></li>
                            <li><a href="">Order history</a></li>
                            <li><a href="">Wishlist</a></li>
                            <li><a href="">Vendor contact</a></li>
                            <li><a href="">Front page</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Categories</h2>
                        <ul>
                            <li><a href="">Mobile Phone</a></li>
                            <li><a href="">Home accesseries</a></li>
                            <li><a href="">LED TV</a></li>
                            <li><a href="">Computer</a></li>
                            <li><a href="">Gadets</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="footer-newsletter">
                        <h2 class="footer-wid-title">Newsletter</h2>
                        <p>Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!</p>
                        <div class="newsletter-form">
                            <input type="email" placeholder="Type your email">
                            <input type="submit" value="Subscribe">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="copyright">
                        <p>&copy; 2015 uCommerce. All Rights Reserved. <a href="http://www.freshdesignweb.com" target="_blank">freshDesignweb.com</a></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="footer-card-icon">
                        <i class="fa fa-cc-discover"></i>
                        <i class="fa fa-cc-mastercard"></i>
                        <i class="fa fa-cc-paypal"></i>
                        <i class="fa fa-cc-visa"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest jQuery form server -->
    <script src="https://code.jquery.com/jquery.min.js"></script>

    <!-- Bootstrap JS form CDN -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <!-- jQuery sticky menu -->
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.sticky.js"></script>

    <!-- jQuery easing -->
    <script src="js/jquery.easing.1.3.min.js"></script>

    <!-- Main Script -->
    <script src="js/main.js"></script>
</body>

</html>