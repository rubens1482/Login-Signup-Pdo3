<?php
	require_once("config/session.php");
	require_once("class/class.user.php");
	include "config/config_session.php";
	include "parameters.php";
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	$mail = $userRow['user_email'];
	$name = $userRow['user_name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	
	<script >
	  $( function() {
		  $( "#datamov, #datamov, #datapicker, #data_i, #data_f" ).datepicker({
			altField: "#actualDate",
			dateFormat: "dd-mm-yy",
			altFormat: "dd-mm-YY",
			showWeek: true,	
			changeMonth: true,
			changeYear: true
		});
		$( ".selector" ).datepicker({
		altFormat: "dd-mm-yy",
		altField: "#actualDate"
		});
	  } );
	</script>
	
	<script type="text/javascript">
	  $(function () {
		// toolip
		$('[data-toggle="tooltip"]').tooltip();

	 // datatables
	$('#tb_home').dataTable( {
		"lengthMenu": [[2, 7, 10, 12, 15, 25, -1], [2, 7, 10, 12, 15, 25, "All"]],
		"pageLength": 7,
		"pagingType": "full_numbers",
		"order": [[ 3, "asc" ]],
		"order": [[ 2, "asc" ]],
		"info":     true
	} );
	  })
	</script>
	<!-- 	SCRIPT JAVASCRIPT PARA DATATABLES CSS -->
	<title> welcome - <?php print($userRow['user_email']); ?></title>
</head>
<body> 
<!-- NAVBAR PRINCIPAL COM NOME DA CONTA, DATA ATUAL, MENU DA CONTA E MENU DO USUARIO -->
	

	<div class="container-fluid" style="margin-top:20px; margin-left:90px; margin-right: 90px; padding: 0;">
		<nav class="navbar navbar-inverse navbar-fixed-top " >
			<div class="container">
				<div class="navbar-header" >
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"> ok</span>
					<span class="icon-bar"> vamos </span>
					<span class="icon-bar"> terá </span>
				  </button>
				  <a class="navbar-brand" href="http://www.localhost/Login-Signup-Pdo/home.php">Livro Caixa <?php print $accountRow['conta'] ?></a>
				</div>
				<div id="navbar" class="navbar-collapse collapse" >
					<ul class="nav navbar-nav">
						<li><a href="?mes=<?php echo date('m')?>&ano=<?php echo date('Y')?>"><?php print "Hoje &eacute:"?><strong> <?php echo date('d')?> de <?php echo mostraMes(date('m'))?> de <?php echo date('Y')?></strong></a></li>	
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						  <span class="glyphicon glyphicon-user"></span> Ir Para <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home </a></li>
								<li class="divider"></li>
								<li><a href="list_cat.php"><span class="glyphicon glyphicon-book"></span>  Categorias </a></li>
								<li class="divider"></li>
								<li><a href="filtrarpordata.php"><span class="glyphicon glyphicon-calendar"></span> Filtrar por Data </a></li>
								<li class="divider"></li>
								<li><a href="filtrarporfolha.php"><span class="glyphicon glyphicon-list"></span> Filtrar por Folha </a></li>
								<li class="divider"></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						  <span class="glyphicon glyphicon-user"></span>&nbsp;Conta: <?php echo $accountRow['idconta'] . "-" . $accountRow['conta']; ?>&nbsp;<span class="caret"></span></a>
						  <ul class="dropdown-menu">
							<li><a href="profile_user.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Dados da Conta </a></li>
							<li><a href="logout_c.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Alternar Conta </a></li>
						  </ul>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						  <span class="glyphicon glyphicon-user"></span>&nbsp;Usu&aacute;rio: <?php echo $userRow['user_name']; ?>&nbsp;<span class="caret"></span></a>
							  <ul class="dropdown-menu">
								
								<li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sair </a></li>
							  </ul>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</nav>
	</div>

	<div class="container-fluid" style="margin-top:40px; margin-left:90px; margin-right: 90px; padding: 0; ">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xd-12">
				<div class="panel panel-danger" >
					<!--  CABEÇALHO DOS BALANCOS -->
					<div class="panel-heading"  > 
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xd-6" style="text-align: left;">
								<strong>BALANCOS DE MOVIMENTO</strong>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xd-6" style="text-align: right;">
								<strong>FILTRAGEM POR DATA</strong>
							</div>
						</div>	
					</div>
					<!--  INICIO DO CORPO DO BALANCO -->
					<div class="panel-body" >
						<div class="row">
							<!--  BALANÇO MENSAL -->
							
							
							<div class="row">

								<div class="col-sm-6">
									<div class="well" style="margin-left:10px;">
									<h3>Dados do usuario</h3>
										<form action="profile_user.php" enctype="multipart/form-data" method="post">
											
											<div class="form-group">
												<label>Nome:</label>
												<input type="text" name="user_name" class="form-control" value="<?php echo $name ?>">
											</div>
											
											<div class="form-group">
												<label>e-mail:</label>
												<input type="text" name="user_email" class="form-control" value="<?php echo $mail ?>">
											</div>
											
											<div class="form-group">
												<label>Ketengan:</label>
												<img alt="" width="150" height="175" src="images/ifba.png"></textarea>
											</div>
											<div class="form-group">
								  <label>Foto</label>
								  <input type="file" name="foto" required>
								  <p class="help-block">
									<small>Catatan :</small> <br>
									<small>- Certifique-se de que o arquivo seja do tipo *.JPG ou *.PNG</small> <br>
									<small>- Tamanho Maximo do arquivo 1 Mb</small>
								  </p>
								</div>

											<div class="form-group">
												<label class="control-label">Gambar</label>
												<input name="gmbr" type="file" class="form-control" accept="image/*" id="recipient-name" required>
											</div>					

											<div class="form-group">
												<button type="reset"  class="btn btn-default">Reset</button>
												<button type="submit" name="krm"  class="btn btn-primary">Simpan</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- BALANÇO ANUAL  -->	
					</div>
				</div>
			</div>
		</div>
	</div>




<div class="container-fluid" style="margin-top:0px; margin-left: 120px; margin-right: 120px; padding: 0;">	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<!-- necessário para abrir os DataTables -->
	<script src="assets/js/dataTables/js/jquery.dataTables.js"></script>
	<script src="assets/js/dataTables/js/dataTables.bootstrap.js"></script>
	
	<!-- necessário para abrir o calendario datepicker -->
	<script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
	
	<script type="text/javascript">
	  $(function () {
		// toolip
		$('[data-toggle="tooltip"]').tooltip();
		// datatables
		$('#tb_home_2').dataTable( {
			"lengthMenu": [[2, 5, 10, 12, 15, -1], [2, 5, 10, 12, 15, "All"]],
			"pageLength": 5,
			"pagingType": "full_numbers",
			"paging": true,
			"ordering": true,
			"info":     true
		} );
	  })
	</script>	
</div>	
</body>
</html>