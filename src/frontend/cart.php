<?php

use App\Cart;
use App\Products;

include('../index.php');

$fetchProd = new Products();
if (!isset($productArr)) {
    $productArr = array();
}
foreach ($_SESSION['cart'] as $key => $value) 
{
    $queryWithID = "WHERE id = " . $value['id'] . " ";
    array_push($productArr, ['0' => $fetchProd->fetchProducts($queryWithID)[0], '1' => $value['qty']]); 
}

if (isset($_POST['qtyField']) && isset($_POST['qtyBtn'])) {
    switch ($_POST['qtyBtn']) {
        case '+':
            quantity('+', $_POST['productID']);
            header("Location: cart.php");
            break;
        case '-':
            quantity('-', $_POST['productID']);
            header("Location: cart.php");
            break;
    }
}

if (isset($_POST['rmBtn'])) {

    $cartData = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $cart = new Cart($cartData);

    $cart->removeProduct($_POST['productID']);

    $_SESSION['cart'] = $cart->getCart();
    header("Location: cart.php");
}

function quantity($op, $id)
{
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['id'] == $id) {
            echo "jjjj=" . $_SESSION['cart'][$key]['qty'];
            if ($op == '+') {
                $_SESSION['cart'][$key]['qty'] += 1;
            } else {
                $_SESSION['cart'][$key]['qty'] -= 1;
                if ($_SESSION['cart'][$key]['qty'] == 0) {
                    $cartData = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
                    $cart = new Cart($cartData);

                    $cart->removeProduct($id);
                    $_SESSION['cart'] = $cart->getCart();
                }
            }
        }
    }
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart Page - Ustora Demo</title>

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
</head>

<body>

    <?php include 'front_header.php' ?>
    <!-- End mainmenu area -->

    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Shopping Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->


    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Search Products</h2>
                        <form action="#">
                            <input type="text" placeholder="Search products...">
                            <input type="submit" value="Search">
                        </form>
                    </div>

                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Products</h2>
                        <div class="thubmnail-recent">
                            <img src="img/product-thumb-1.jpg" class="recent-thumb" alt="">
                            <h2><a href="single-product.html">Sony Smart TV - 2015</a></h2>
                            <div class="product-sidebar-price">
                                <ins>$700.00</ins> <del>$800.00</del>
                            </div>
                        </div>
                        <div class="thubmnail-recent">
                            <img src="img/product-thumb-1.jpg" class="recent-thumb" alt="">
                            <h2><a href="single-product.html">Sony Smart TV - 2015</a></h2>
                            <div class="product-sidebar-price">
                                <ins>$700.00</ins> <del>$800.00</del>
                            </div>
                        </div>
                        <div class="thubmnail-recent">
                            <img src="img/product-thumb-1.jpg" class="recent-thumb" alt="">
                            <h2><a href="single-product.html">Sony Smart TV - 2015</a></h2>
                            <div class="product-sidebar-price">
                                <ins>$700.00</ins> <del>$800.00</del>
                            </div>
                        </div>
                        <div class="thubmnail-recent">
                            <img src="img/product-thumb-1.jpg" class="recent-thumb" alt="">
                            <h2><a href="single-product.html">Sony Smart TV - 2015</a></h2>
                            <div class="product-sidebar-price">
                                <ins>$700.00</ins> <del>$800.00</del>
                            </div>
                        </div>
                    </div>

                    <div class="single-sidebar">
                        <h2 class="sidebar-title">Recent Posts</h2>
                        <ul>
                            <li><a href="#">Sony Smart TV - 2015</a></li>
                            <li><a href="#">Sony Smart TV - 2015</a></li>
                            <li><a href="#">Sony Smart TV - 2015</a></li>
                            <li><a href="#">Sony Smart TV - 2015</a></li>
                            <li><a href="#">Sony Smart TV - 2015</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="woocommerce">

                            <table cellspacing="0" class="shop_table cart">
                                <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($productArr as $key => $value) {
                                        echo '<form action="" method="POST">
                                            <tr class="cart_item">
                                                <td class="product-remove">
                                                    <button type="submit"
                                                     name = "rmBtn" value="remove" 
                                                     class="remove">x</button>
                                                </td>
    
                                                <td class="product-thumbnail">
                                                    <a href="single-product.html"><img width="145" 
                                                    height="145" alt="poster_1_up" 
                                                    class="shop_thumbnail" 
                                                    src="../uploads/' . $value[0]['imgName'] . '"></a>
                                                </td>
    
                                                <td class="product-name">
                                                    <a href="single-product.html">' . $value[0]['name'] . '</a>
                                                </td>
    
                                                <td class="product-price">
                                                    <span class="amount">₹' . $value[0]['price'] . '</span>
                                                </td>
    
                                                <td class="product-quantity">
                                                    <div class="quantity buttons_added">
                                                        <input type="submit" class="minus" name="qtyBtn" value="-">
                                                        <input type="hidden" name="productID" value=' . $value[0]['id'] . '>
                                                        <input type="number" size="4" class="input-text qty text" title="Qty" name="qtyField" value="' . $value[1] . '" min="0" step="1">
                                                        <input type="submit" class="plus" name="qtyBtn" value="+">
                                                    </div>
                                                </td>
    
                                                <td class="product-subtotal">
                                                    <span class="amount">₹' . $value[1] * $value[0]['price'] . '</span>
                                                </td>
                                            </tr>
                                            </form>';
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="12">
                                            <span>Total Sum = <?php echo totalSum($productArr); ?></span>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td class="actions" colspan="6">
                                            
                                            <a href="checkout.php" class="btn btn-primary">Checkout</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="cart-collaterals">


                                <div class="cross-sells">
                                    <h2>You may be interested in...</h2>
                                    <ul class="products">
                                        <li class="product">
                                            <a href="single-product.html">
                                                <img width="325" height="325" alt="T_4_front" class="attachment-shop_catalog wp-post-image" src="img/product-2.jpg">
                                                <h3>Ship Your Idea</h3>
                                                <span class="price"><span class="amount">£20.00</span></span>
                                            </a>

                                            <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="22" rel="nofollow" href="single-product.html">Select options</a>
                                        </li>

                                        <li class="product">
                                            <a href="single-product.html">
                                                <img width="325" height="325" alt="T_4_front" class="attachment-shop_catalog wp-post-image" src="img/product-4.jpg">
                                                <h3>Ship Your Idea</h3>
                                                <span class="price"><span class="amount">£20.00</span></span>
                                            </a>

                                            <a class="add_to_cart_button" data-quantity="1" data-product_id="22" rel="nofollow" href="single-product.html">
                                                Select options
                                            </a>
                                        </li>
                                    </ul>
                                </div>


                                <div class="cart_totals ">
                                    <h2>Cart Totals</h2>

                                    <table cellspacing="0">
                                        <tbody>
                                            <tr class="cart-subtotal">
                                                <th>Cart Subtotal</th>
                                                <td><span class="amount">₹<?php echo totalSum($productArr); ?></span></td>
                                            </tr>

                                            <tr class="shipping">
                                                <th>Shipping and Handling</th>
                                                <td>Free Shipping</td>
                                            </tr>

                                            <tr class="order-total">
                                                <th>Order Total</th>
                                                <td><strong><span class="amount">₹<?php echo totalSum($productArr); ?></span></strong> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>





                            </div>
                        </div>
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
                            <li><a href="#">My account</a></li>
                            <li><a href="#">Order history</a></li>
                            <li><a href="#">Wishlist</a></li>
                            <li><a href="#">Vendor contact</a></li>
                            <li><a href="#">Front page</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Categories</h2>
                        <ul>
                            <li><a href="#">Mobile Phone</a></li>
                            <li><a href="#">Home accesseries</a></li>
                            <li><a href="#">LED TV</a></li>
                            <li><a href="#">Computer</a></li>
                            <li><a href="#">Gadets</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="footer-newsletter">
                        <h2 class="footer-wid-title">Newsletter</h2>
                        <p>Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!</p>
                        <div class="newsletter-form">
                            <form action="#">
                                <input type="email" placeholder="Type your email">
                                <input type="submit" value="Subscribe">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End footer top area -->

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
    </div> <!-- End footer bottom area -->

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