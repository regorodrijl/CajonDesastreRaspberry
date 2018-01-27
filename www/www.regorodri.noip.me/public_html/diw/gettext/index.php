<?php
 	require_once( 'php/php-gettext/language.php' );
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="<?php _e("giltesa");?>">
        <title><?php _e("Translation with php-gettext");?></title>
        <meta name="description" content="<?php _e("Example of translation of a page using php-gettext library.");?>">
        <link type="image/x-icon" rel="icon" href="img/favicon.ico">

        <link type="text/css" href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="css/bootstrap/signin.css" rel="stylesheet">

        <!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script async type="text/javascript" src="js/bootstrap/ie-emulation-modes-warning.js"></script>
        <script async type="text/javascript" src="js/bootstrap/ie10-viewport-bug-workaround.js"></script>
        <!--[if lt IE 9]>
          <script async type="text/javascript" src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script async type="text/javascript" src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <div class="container">

          <form class="form-signin" role="form">
            <h2 class="form-signin-heading"><?php _e("Please sign in");?></h2>
            <input type="email" class="form-control" placeholder="<?php _e("Email address");?>" required autofocus>
            <input type="password" class="form-control" placeholder="<?php _e("Password");?>" required>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me"> <?php _e("Remember me");?>
              </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit"><?php _e("Sign in");?></button>
          </form>

        </div> <!-- /container -->

        <script type="text/javascript" src="js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
    </body>
</html>