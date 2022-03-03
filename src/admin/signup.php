<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Signup</title>    

    <!-- Bootstrap core CSS -->
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">


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
    <link href="../assets/css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<main class="form-signin">
  <form action="../index.php" method="post">
    <h1 class="h3 mb-3 fw-normal">Sign Up</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Username">
      <label for="floatingInput">Username</label>
    </div>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" name="full_name" placeholder="Full Name">
      <label for="floatingInput">Full Name</label>
    </div>

    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>    

    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" name="re_password" placeholder="Re-enter Password">
      <label for="floatingPassword">Re-enter Password</label>
    </div>


    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> I accept the Terms and Conditions.
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit" value="signup">Sign Up</button>
    <p class="mt-5 mb-3 text-muted">&copy; CEDCOSS Technologies</p>
  </form>
</main>


    
  </body>
</html>