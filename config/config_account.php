<?php
session_start();
require_once("class/class.account.php");
$login_c = new ACCOUNT();

if($login_c->is_loggedin_c()!="")
{
	$login_c->redirect('index.php');
}

if(isset($_POST['btn-login']))
{
	$account = strip_tags($_POST['txt_account_email']);
	$prop = strip_tags($_POST['txt_account_email']);
	$pass_c = strip_tags($_POST['txt_password']);
		
	if($login_c->doLogin_c($account,$prop,$pass_c))
	{
		$login_c->redirect('index.php');
	}
	else
	{
		$error = "Login ou Senha Incorretos !";
	}	
}
?>