<?php
session_start();
require_once('class/class.account.php');
$conta = new ACCOUNT();

if($conta->is_loggedin_c()!="")
{
	$conta->redirect('home.php');
}

if(isset($_POST['btn-signup-c']))
{
	$account = strip_tags($_POST['txt_account']);
	$prop = strip_tags($_POST['txt_prop']);
	$pass_c = strip_tags($_POST['txt_pass_c']);	
	
	if($account=="")	{
		$error[] = "Insira nome da conta !";	
	}
	else if($prop=="")	{
		$error[] = "Insira o Proprietario da conta !";	
	}
	//else if(!filter_var($prop, FILTER_VALIDATE_EMAIL))	{
	//    $error[] = 'Please enter a valid email address !';
	//}
	else if($pass_c=="")	{
		$error[] = "Defina sua senha !";
	}
	else if(strlen($pass_c) < 5){
		$error[] = "Senha não pode conter menos que 6 caracteres";	
	}
	else
	{
		try
		{
			$stmt = $conta->SqlQuery("SELECT conta, proprietario FROM lc_contass WHERE conta=:account OR proprietario=:prop");
			$stmt->execute(array(':account'=>$account, ':prop'=>$prop));
			$rowc=$stmt->fetch(PDO::FETCH_ASSOC);
				
			if($rowc['conta']==$account) {
				$error[] = "sorry username already taken !";
			}
			else if($rowc['proprietario']==$prop) {
				$error[] = "sorry email id already taken !";
			}
			else
			{
				if($conta->register($account,$prop,$pass_c)){	
					$conta->redirect('sign-up_c.php?joined');
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Livro Caixa: Sign up</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>

<div class="signin-form">

<div class="container">
    	
        <form method="post" class="form-signin">
            <h2 class="form-signin-heading">Sign up.</h2><hr />
            <?php
			if(isset($error))
			{
			 	foreach($error as $error)
			 	{
					 ?>
                     <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                     </div>
                     <?php
				}
			}
			else if(isset($_GET['joined']))
			{
				 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                 </div>
                 <?php
			}
			?>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_account" placeholder="Id Conta" value="<?php if(isset($error)){echo $account;}?>" />
            </div>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_prop" placeholder="Proprietario" value="<?php if(isset($error)){echo $prop;}?>" />
            </div>
            <div class="form-group">
            	<input type="password" class="form-control" name="txt_pass_c" placeholder="Senha" />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
            	<button type="submit" class="btn btn-primary" name="btn-signup-c">
                	<i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
                </button>
            </div>
            <br />
            <label>have an account ! <a href="login_c.php">Login na Conta</a></label>
        </form>
       </div>
</div>

</div>

</body>
</html>