<?php
require_once "config/config_account.php";
?>
<!DOCTYPE html>
<html lang="pt_Br">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Sistema de Livro Caixa em PHP </title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<script src="assets/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script> 
<style type="text/css">
	.login-form {
		width: 385px;
		margin: 70px auto;
	}
    .login-form form {        
    	margin-bottom: 15px;
		margin-top: 15px;
        background: #f8e6e0;
        box-shadow: 5px 5px 5px 5px rgba(0.5, 2, 6, 0.4);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .login-btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .input-group-addon .fa {
        font-size: 18px;
    }
    .login-btn {
        font-size: 15px;
        font-weight: bold;
    }
	.social-btn .btn {
		border: none;
        margin: 10px 3px 0;
        opacity: 1;
	}
    .social-btn .btn:hover {
        opacity: 0.9;
    }
	.social-btn .btn-primary {
        background: #507cc0;
    }
	.social-btn .btn-info {
		background: #64ccf1;
	}
	.social-btn .btn-danger {
		background: #df4930;
	}
    .or-seperator {
        margin-top: 20px;
        text-align: center;
        border-top: 1px solid #ccc;
    }
    .or-seperator i {
        padding: 0 10px;
        background: #f7f7f7;
        position: relative;
        top: -11px;
        z-index: 1;
    }   
</style>
</head>
<body>
</br>
<div class="login-form">
    <form  method="post" id="login-form">
        <h2 class="text-center">Sign in Account</h2> 

		<div id="error">
        <?php
			if(isset($status))
			{
				?>
                <div class="alert alert-danger">
                   <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $status; ?> !
                </div>
                <?php
			}
		?>
        </div>
		
        <div class="form-group">
        	<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" name="txt_account_email" placeholder="Account Name" required="required">				
            </div>
        </div>
		<div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="txt_password" placeholder="Password Account" required="required">				
            </div>
        </div>        
        <div class="form-group">
            <button type="submit" name="btn-login" class="btn btn-primary login-btn btn-block">Sign in</button>
        </div>
        <div class="or-seperator"><i>or</i></div>
		<div class="clearfix">
            <label class="pull-left checkbox-inline">
			
			<a href="sign-up_c.php" class="pull-left">Criar conta</a>
            <a href="#" class="pull-right">Forgot Password?</a>
        </div>
		
        
    </form>
    <p class="text-center text-muted small">Don't have an account? <a href="sign-up_c.php">Sign up here!</a></p>
</div>
</body>
</html>                            