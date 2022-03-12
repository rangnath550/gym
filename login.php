<?php 
include('common/config.php');
if(isset($_REQUEST['login']))
{
	$name=$_REQUEST['username'];
	$pass=$_REQUEST['password'];
	
	$d=$p->prepare("SELECT * FROM admin WHERE username='$name'");
	$d->execute();
	$row_count=$d->rowCount();
	
	if($row_count!=0)
	{
		$rt=$d->fetch();
		$uid=$rt['id'];
		$password=$rt['password'];
		if($password==$pass)
		{ 
			$_SESSION['username']=$uid;
		    header('location:index.php');
		}
		else
		{
			$errmsg="Invalid";
		}

	}
	else
	{
		$errmsg="Email not registered";
	}
}
?>
<?php
if(isset($errmsg))
{
	 ?>
	    <p style="color:red"><?php echo $errmsg; ?></p>
	 <?php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
 
   <?php include('common/css.php'); ?>
    
	
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
	
</head>

  <body class="login-body">

    <div class="container">

      <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">sign in now</h2>
        <div class="login-wrap">
            <input type="text" name="username" class="form-control" placeholder="User ID" autofocus>
            <input type="password" name="password" class="form-control" placeholder="Password">
           
            <button class="btn btn-lg btn-login btn-block" type="submit" name="login">Sign in</button>
            
        </div>

          <!-- Modal -->
        

      </form>

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

     <!-- Rangnath has changed the vode -->
  </body>
</html>
