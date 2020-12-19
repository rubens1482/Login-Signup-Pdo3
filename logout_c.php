<?php 
require_once('config/session.php');
	
	require_once('class/class.account.php');
	$account_logout = new ACCOUNT();
	
	if($account_logout->is_loggedin_c()!="")
	{
		$account_logout->redirect('home.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$account_logout->doLogout_c();
		$account_logout->redirect('login_c.php');
	}
?>