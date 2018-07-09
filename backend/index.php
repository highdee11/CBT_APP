<?php  require("db/connect.php");     if(login()){  header("location:includes/Dashboard.php"); }?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UI-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
  <link rel="stylesheet" href="css/style.css" />
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src='js/jquery-3.1.0.min.js'></script>
	<script src='js/jquery-ui.js'></script>
	<script src='js/bootstrap.min.js'></script>
  <script type='text/javascript' src='js/login.js'></script>
</head>
<body >
    <div class='col-lg-12 col-xs-12 col-md-12  col-sm-12 ' id="body"></div>
	<div class='col-lg-12 col-xs-12 col-md-12  col-sm-12 ' id='cover'>
			<div class='col-lg-12 col-xs-12 col-md-12  col-sm-12  head'></div>
			<div class="col-lg-12 col-xs-12 col-md-12  col-sm-12  body">
                    <div class="col-lg-2 col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-5 col-sm-offset-5 col-sm-4  col-lg-offset-5 status hidden ">
                        <div class="loader col-lg-12 col-md-12  col-sm-12  col-xs-12 "></div>
                        <div class="loaderTxt" id="loaderTxt">verifying login....</div>
                    </div>
					<div class='col-lg-2 col-xs-10 col-xs-offset-1  col-lg-offset-5  col-md-4 col-md-offset-5 col-sm-offset-5 col-sm-4 form_body'>
                            <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12 col-xs-12 user">
                                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-4 col-xs-offset-4 col-md-offset-4 col-sm-offset-4 col-lg-offset-4 img"><span class='glyphicon glyphicon-user'></span></div>
                                <div class='col-lg-12 col-xs-12 col-md-12 col-sm-12 name'>Admin</div>
                            </div>
							<form class='col-lg-12 col-xs-12 col-md-12 col-sm-12' id="loginForm">
							<div class='form-group col-lg-12 col-xs-12 col-md-12 col-sm-12'>
								<input type='text' id="Adminuser" name='Adminuser' class='form-  input-xs' placeholder="Enter Username"  autocomplete="nope"/>
							</div>
							<div class='form-group col-lg-12 col-xs-12 col-md-12 col-sm-12'>
								<input type='password' id="password" name='Adminpassw' class='form-  input-xs' placeholder="Enter Password" autocomplete="new-password"/>
							</div>
							<button id="login" type='submit' class='btn btn-success btn-xs' >Login</button>
						</form>
					</div>
			</div>
        
	</div>
</body>
</html>
