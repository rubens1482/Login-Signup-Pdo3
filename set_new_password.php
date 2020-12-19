<?php
$chave = "";
if (isset($_GET["chave"])){
	//$chave = preg_replace('/[^[:alnum:]]/','',$_GET["chave"]);
	$chave = strip_tags($_GET["chave"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Alterar Senha </title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="style_c.css" type="text/css"  />
</head>
<body>

<div class="signin-form">
	<div class="container">
       <form class="form-signin" method="post" id="login-form" action="new_password.php">
        <h2 class="form-signin-heading"> Alteração de Senha </h2><hr />
        
        <div class="form-group">
			<input type="text" class="form-control" name="chave" placeholder="Digite seu e-mail" value="<?php echo $chave ?>" required />
			<span id="check-e"></span>
        </div>
        <div class="form-group">
			<input type="text" class="form-control" name="email" placeholder="Digite seu e-mail" required />
			<span id="check-e"></span>
        </div>
        
        <div class="form-group">
			<input type="password" class="form-control" name="new_password" placeholder="Nova Senha" />
			</div>
			<hr />
        <div class="form-group">
            <button type="submit" name="btn-set" class="btn btn-default">
                	<i class="glyphicon glyphicon-log-in"></i> &nbsp; SIGN IN
            </button>
        </div>  
      	<br />
            <label>Ja possui Login ? <a href="index.php">Logar</a></label>
			
      </form>
    </div>
</div>
<?php 
} else {
	?>
		<h1>Pagina não encontrada</h1>
<?php
}
?>
</body>
</html>