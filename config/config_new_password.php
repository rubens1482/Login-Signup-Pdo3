<?php
session_start();
require_once("class.user.php");
$login = new USER();



if(isset($_POST['btn-forget']))
{
	$umail = strip_tags($_POST['txt_uname_email']);
		
	if($login->geraChaveAcesso($umail))
	{
		$login->redirect('index.php');
		
	}
	else
	{
		$status = "Dados Incorretos !";
	}	
}
?>