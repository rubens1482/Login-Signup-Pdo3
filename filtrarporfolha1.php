<?php
error_reporting(E_ERROR | E_WARNING);
	require_once("config/session.php");
	require_once("class/class.user.php");
	include "config/config_session.php";
	include "parameters.php";
	
	
?>
<?php
$pdo = new Database();
$db = $pdo->dbConnection();

$primeiro_dia = date("01", mktime(0,00,0,$mes_hoje,'01',$ano_hoje));
$ultimo_dia = date("t", mktime(0,00,0,$mes_hoje,'01',$ano_hoje));

$dia = 01;
$mes = $mes_hoje;
$ano = $ano_hoje;
//$datainicial = date("$dia-$mes-$ano");
//$datafinal = date("t/$mes/$ano");

$tipo1 = 1;
$tipo0 = 0;

// ENTRADAS DA LIVRO ANTERIOR
if (isset($_GET['filtrar_data'])){
	$idlivro = $_GET['livro'];
	$stmt = $db->prepare("SELECT SUM(valor) as entradas_lant FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo1 and idlivro<:idlivro");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo1', $tipo1 );
	$stmt->bindparam(':idlivro', $idlivro );
	$stmt->execute();
	$qrepl=$stmt->fetch(PDO::FETCH_ASSOC);
	$entradas_lant=$qrepl['entradas_lant'];
	
// SAIDAS DA LIVRO ANTERIOR
	$idlivro = $_GET['livro'];
	$stmt = $db->prepare("SELECT SUM(valor) as saidas_lant FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo0 and idlivro<:idlivro");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo0', $tipo0 );
	$stmt->bindparam(':idlivro', $idlivro );
	$stmt->execute();
	$qrspl=$stmt->fetch(PDO::FETCH_ASSOC);
	$saidas_lant=$qrspl['saidas_lant'];

// SALDO DO LIVRO ANTERIOR
	$saldo_lant = $entradas_lant - $saidas_lant;

}else{
	
}


// ENTRADAS DA FOLHA SELECIONADA
if (isset($_GET['filtrar_data'])){
	$idlivro = $_GET['livro'];
	$folha_i = $_GET['folha_i'];
	$folha_f = $_GET['folha_f'];
	$stmt = $db->prepare("SELECT SUM(valor) as entradas_f FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo1 and idlivro=:idlivro and folha>=:folha_i and folha<=:folha_f");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo1', $tipo1 );
	$stmt->bindparam(':idlivro', $idlivro );
	$stmt->bindparam(':folha_i', $folha_i );
	$stmt->bindparam(':folha_f', $folha_f );
	$stmt->execute();
	$qrepf=$stmt->fetch(PDO::FETCH_ASSOC);
	$entradas_f=$qrepf['entradas_f'];
	
// SAIDAS DA FOLHA SELECIONADA
	$idlivro = $_GET['livro'];
	$folha_i = $_GET['folha_i'];
	$folha_f = $_GET['folha_f'];
	$stmt = $db->prepare("SELECT SUM(valor) as saidas_f FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo0 and idlivro=:idlivro and folha>=:folha_i and folha<=:folha_f ");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo0', $tipo0 );
	$stmt->bindparam(':idlivro', $idlivro );
	$stmt->bindparam(':folha_i', $folha_i );
	$stmt->bindparam(':folha_f', $folha_f );
	$stmt->execute();
	$qrspf=$stmt->fetch(PDO::FETCH_ASSOC);
	$saidas_f=$qrspf['saidas_f'];
	
// SAIDAS DA FOLHA SELECIONADA
	$saldo_pf = $entradas_f - $saidas_f;

}else{
	
}


// ENTRADAS ANTES DA FOLHA DIGITADA  "CORRIGIDO"
if (isset($_GET['filtrar_data'])){
	$idlivro = $_GET['livro'];
	$folha_i = $_GET['folha_i'];
	$stmt = $db->prepare("SELECT SUM(valor) as entradas_afod FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo1 and idlivro=:idlivro and folha<:folha_i");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo1', $tipo1 );
	$stmt->bindparam(':idlivro', $idlivro );
	$stmt->bindparam(':folha_i', $folha_i );
	$stmt->execute();
	$qreafod=$stmt->fetch(PDO::FETCH_ASSOC);
	$entradas_afod=$qreafod['entradas_afod'];	

// SAIDA ANTES DA FOLHA DIGITADA  "CORRIGIDO"
	$idlivro = $_GET['livro'];
	$folha_i = $_GET['folha_i'];
	$stmt = $db->prepare("SELECT SUM(valor) as saidas_afod FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo0 and idlivro=:idlivro and folha<:folha_i");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo0', $tipo0 );
	$stmt->bindparam(':idlivro', $idlivro );
	$stmt->bindparam(':folha_i', $folha_i );
	$stmt->execute();
	$qrsafod=$stmt->fetch(PDO::FETCH_ASSOC);
	$saidas_afod=$qrsafod['saidas_afod'];
	

}else{
	
}
// SALDO ANTERIOR A FOLHA DIGITADA
if ($_GET['filtrar_data']){
	$idlivro = $_GET['livro'];
		if($idlivro == 1){
			$saldo_afod = $entradas_afod-$saidas_afod;
		}else{
			$saldo_afod = $saldo_lant+$entradas_afod-$saidas_afod;
		}
}
// SALDO CABE�ALHO DO LIVRO E DA FOLHA DIGITADA
/*
if (isset($_GET['filtrar_data'])){
	$idlivro = $_GET['livro'];
	
	if($idlivro == 1){
		$saldo_pfd = $saldo_afod;
	} else{
		$saldos_pfd = $saldo_lant + $saldo_afod;
	}
}
*/	
// SALDO ANTERIOR CASO O M�S SEJA JANEIRO OU OUTROS MESES...
	if ($mes_hoje == 1){
		$saldo_ant=$saldo_aa;
	} else {
		$saldo_ant=$saldo_aca+$saldo_aa;
	}
	
	if ($mes_hoje == 1){
		$resultado_mes=$saldo_aa+$saldo_m;
	} else {
		$resultado_mes=$saldo_aa+$saldo_aca+$saldo_m;
	}
	
// SALDO ANTERIOR CASO O M�S SEJA JANEIRO OU OUTROS MESES...
	if ($mes_hoje == 1){
		$saldo_ant=$saldo_aa;
	} else {
		$saldo_ant=$saldo_aca+$saldo_aa;
	}
	if ($mes_hoje == 1){
		$resultado_mes=$saldo_aa+$saldo_m;
	} else {
		$resultado_mes=$saldo_aa+$saldo_aca+$saldo_m;
	}
	
	if (isset($_GET["filtrar_data"])){
		$fhi = $folha_i;
		$fhf = $folha_f;
	}else{
		$fhi = 5;
		$fhf = 7;
	}
	
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
		  $( "#datamov, #datamov, #datapicker, #data_ini, #data_fim" ).datepicker({
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
	
	<script type="text/javascript" language="javascript">
		function valida_form (){
			var i = document.getElementById('folha_i').value;
			var f = document.getElementById('folha_f').value;
			
			if(document.getElementById("folha_i").value == ""){
			alert('Por favor, preencha o campo Folha Inicial');
			document.getElementById("folha_i").focus();
			return false
			} else {
				if(document.getElementById("folha_f").value == ""){
					alert('Preencha o campo Folha Final');
					document.getElementById("folha_f").focus();
					return false
				}
			}
			
			if(i > f){
			 alert('folha inicial maior que folha final');
			 document.getElementById("folha_i").focus();
			 return false; //Parar a execucao
			 }
			
		}
	</script>
	
	<script type="text/javascript" language="javascript">
		function validar(){
			 var i = document.getElementById('folha_i').value;
			 var f = document.getElementById('folha_f').value;

			 if(i > f){
			 alert("folha inicial maior que folha final");
			 document.getElementById("folha_i").focus();
			 return false; //Parar a execucao
			 }
		}
	</script>
	<!-- 	SCRIPT JAVASCRIPT PARA DATATABLES CSS -->
	<title> welcome - <?php print($userRow['user_email']); ?></title>
</head>
<body> 
	<!-- NAVBAR PRINCIPAL COM NOME DA CONTA, DATA ATUAL, MENU DA CONTA E MENU DO USUARIO -->
	<nav class="navbar navbar-default navbar-fixed-top " >
		<div class="container">
			<div class="navbar-header" >
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"> ok</span>
				<span class="icon-bar"> vamos </span>
				<span class="icon-bar"> ter� </span>
			  </button>
			  <a class="navbar-brand" href="http://www.localhost/Login-Signup-Pdo/index.php">Livro Caixa <?php print $accountRow['conta'] ?></a>
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
							<li><a href="list_cat.php"><span class="glyphicon glyphicon-book"></span> Categorias </a></li>
							<li class="divider"></li>
							<li><a href="filtrarpordata.php"><span class="glyphicon glyphicon-calendar"></span> Filtrar por Data </a></li>
							<li class="divider"></li>
							
							<li><a href="profile_user.php"><span class="glyphicon glyphicon-user"></span> Meu Perfil</a></h5></li>
							<li class="divider"></li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					  <span class="glyphicon glyphicon-user"></span>&nbsp;Conta: <?php echo $accountRow['idconta'] . "-" . $accountRow['conta']; ?>&nbsp;<span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Dados da Conta </a></li>
						<li><a href="logout_c.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Alterar Conta </a></li>
					  </ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					  <span class="glyphicon glyphicon-user"></span>&nbsp;Usu&aacute;rio: <?php echo $userRow['user_name']; ?>&nbsp;<span class="caret"></span></a>
						  <ul class="dropdown-menu">
							<li><a href="profile_user.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
							<li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
						  </ul>
					</li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>	
	<!-- FIM DA NAVBAR DEFAULT -->
	
	<!-- INICIO DA DIV BALAN�O DE MOVIMENTO FILTRAR POR DATA -->
	<div class="container-fluid" style="margin-top:40px; margin-left:90px; margin-right: 90px; padding: 0; ">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xd-12">
				<div class="panel panel-info" >
					<!--  CABE�ALHO DOS BALANCOS -->
					<div class="panel-heading"  > 
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xd-6" style="text-align: left;">
								<strong> BALANCOS DE MOVIMENTO </strong>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xd-6" style="text-align: right;">
								<strong> FILTRAGEM POR FOLHA </strong>
							</div>
						</div>	
					</div>
					<!--  INICIO DO CORPO DO BALANCO -->
					<div class="panel-body" >
						<div class="row">
							<!--  BALAN�O MENSAL -->
							<div class="col-sm-6" style=" border-top: 1px dashed #f00; border-bottom: 1px dashed #f00;">
								<!--  SALDO ANTERIOR  BALAN�O MENSAL -->
								<div class="row" >
									<div class="col-sm-12" style="text-align: left; border-bottom: 1px dashed #f00;" >
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">BALANCO MENSAL</span></strong>
									</div>
								</div>
								<div class="row" >
									<div class="col-sm-6" style="text-align: left;" >
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Anterior:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong>
											<span style="font-size:14px; color:<?php echo "#006400" ?>">
												<?php if (isset($_GET['filtrar_data'])){ $saldoanterior = $saldo_afod?>
												<?php echo formata_dinheiro($saldoanterior) ?>
												<?php }else{ $saldoanterior = $saldo_ant?>
												<?php echo formata_dinheiro($saldoanterior) ?>
												<?php }?>	
											</span>
										</strong>	
									</div>
								</div>
									<!--  ENTRADAS BALAN�O MENSAL -->
								<div class="row">
									<div class="col-sm-6" style="text-align: left;">
										<strong><span style="font-size:14px; color:<?php echo "#0000FF" ?>">Entradas:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong>
											<span style="font-size:14px; color:<?php echo "#0000FF" ?>">
												<?php if (isset($_GET['filtrar_data'])){ $entradas_per = $entradas_f?>
												<?php echo formata_dinheiro($entradas_per) ?>
												<?php }else{ $entradas_per = $entradas_m?>
												<?php echo formata_dinheiro($entradas_per) ?>
												<?php }?>	
											</span>
										</strong>
									</div>
								</div>
								<!--  SAIDAS BALAN�O MENSAL -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left; border-bottom: 1px dashed #f00;">
										<strong><span style="font-size:14px; color:<?php echo "#C00" ?>">Saidas:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right; border-bottom: 1px dashed #f00;">
										<strong>
											<span style="font-size:14px; color:<?php echo "#C00" ?>">
												<?php if (isset($_GET['filtrar_data'])){ $saidas_per = $saidas_f?>
												<?php echo formata_dinheiro($saidas_per) ?>
												<?php }else{ $saidas_per = $saidas_m?>
												<?php echo formata_dinheiro($saidas_per) ?>
												<?php }?>	
											</span>
										</strong>
									</div>
								</div>
									<!--  SALDO ATUAL BALAN�O MENSAL  -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left;">
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Atual:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong>
											<span style="font-size:14px; color:<?php echo "#006400" ?>">
												<?php if (isset($_GET['filtrar_data'])){ $saldo_atual = $saldo_afod+$entradas_f-$saidas_f?>
												<?php echo formata_dinheiro($saldo_atual) ?>
												<?php }else{ $saldo_atual = $resultado_mes?>
												<?php echo formata_dinheiro($saldo_atual) ?>
												<?php }?>
											</span>
										</strong>
									</div>
								</div>		
							</div>
							<!-- BALAN�O ANUAL  -->	
							<div class="col-sm-6" style=" border-top: 1px dashed #f00; border-bottom: 1px dashed #f00;">
								
								<div class="row" >
									<div class="col-sm-12" style="text-align: left; border-bottom: 1px dashed #f00;" >
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">BALANCO ANUAL</span></strong>
									</div>
								</div>
								<!--  SALDO ANTERIOR  BALAN�O ANUAL -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left;">
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Anterior:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>"><?php print formata_dinheiro($saldo_aa) ?></span></strong>
									</div>
								</div>
								<!--  ENTRADAS  BALAN�O ANUAL -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left;">
										<strong><span style="font-size:14px; color:<?php echo "#0000FF" ?>">Entradas:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong><span style="font-size:14px; color:<?php echo "#0000FF" ?>"><?php print formata_dinheiro($ent_acab) ?></span></strong>
									</div>
								</div>
								<!--  SAIDAS BALAN�O ANUAL -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left; border-bottom: 1px dashed #f00;">
										<strong><span style="font-size:14px; color:<?php echo "#C00" ?>">Saidas:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right; border-bottom: 1px dashed #f00;">
										<strong><span style="font-size:14px; color:<?php echo "#C00" ?>"><?php print formata_dinheiro($sai_acab) ?></span></strong>	
									</div>
								</div>
								<!--  SALDO ATUAL BALAN�O ANUAL -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left;">
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Atual:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>"><?php print formata_dinheiro($saldo_acab) ?></span></strong>
									</div>
								</div>	
							</div>
							<!--  FIM DO BALANCO ANUAL -->
						</div>
						<br>
						<div class="row" >
							<div class="col-sm-12" style="text-align: left; border-bottom: 1px dashed #f00;" >
								<form class="form-inline" style="text-align: center;">
									<label for="ano">
									Ano:
									</label>
									<select class="form-control" id="sel1" onchange="location.replace('?mes=<?php echo $mes_hoje?>&ano='+this.value)">
										<?php
											for ($i=2004;$i<=2050;$i++){
											?>
											<option value="<?php echo $i?>" <?php if ($i==$ano_hoje) echo "selected=selected"?> ><?php echo $i?></option>
										<?php }?>
									</select>
									<label for="mes">
										Mes:
									</label>
									<div class="btn-group">
										<?php
											for ($i=1;$i<=12;$i++){
										?>
										<?php if($mes_hoje==$i){?>
										<!-- MES SELECIONADO -->
										<a href="?mes=<?php echo $i?>&ano=<?php echo $ano_hoje?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-calendar"></span>
										<?php }else{?>
										<!-- OUTROS MESES -->
										<a href="?mes=<?php echo $i?>&ano=<?php echo $ano_hoje?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-calendar"></span>
										<?php } ?>	
										<?php echo mostraMes($i);?>
										</a>
										<?php } ?>
									</div>	
									<a href="#modal_pdf" class="btn btn-sm btn-success " name="modal_periodo" data-toggle="modal">
										<i class="glyphicon glyphicon-plus"></i> pdf	
									</a>
									<a href="#addmov" class="btn btn-sm btn-success " name="add_mov" data-toggle="modal" style="border: solid 1px; border-radius: 1px; box-shadow: 1px 1px 1px 1px black; border-radius:3px 3px 3px 3px;">
										<i class="glyphicon glyphicon-plus"></i> Novo
									</a>
									<a href="list_cat.php" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span>Categorias</a>
								</form>	
							</div>
						</div>
						
					</div>
					<div class="panel-footer" style="text-align: center;">
						<form class="form-inline" name="form_filtro_cat" method="get" action="" onsubmit="return valida_form(this)">
							<div class="panel panel-danger">
								<div class="panel-body">	
									<span><strong> filtrar por cod/desc: </strong></span><input type="text" name="busca" class="form-control input-sm" style="width:180px;" value="">
									<span><strong> Livro: </strong></span><input type="text" name="livro" id="livro" class="form-control input-sm"  style="width:70px;" value="" >
									<span><strong> Folha Inicial: </strong></span><input type="text" name="folha_i" id="folha_i" class="form-control input-sm"  style="width:70px;" value="" >
									<span><strong> Folha Final: </strong></span><input type="text" name="folha_f" id="folha_f" class="form-control input-sm"  style="width:70px;" value="" >

									<input type="hidden" name="data_hoje" value="<?php echo $dia_hoje . "-" . mostraMes($mes_hoje) ."-" . $ano_hoje ?>">
									<a href="#modal_date" class="btn btn-sm btn-success " name="modal_date" data-toggle="modal">
										<i class="glyphicon glyphicon-plus"></i> pdf
									</a>
									<button type="submit" name="filtrar_data" class="btn btn-default btn-sm"  value="Filtrar" style="border: solid 1px; border-radius:1px; box-shadow: 1px 1px 1px 1px black; width:80px;" >Filtrar</button>	
									<button type="submit" name="filtrar_pdf" class="btn btn-danger btn-sm"  value="Filtrar_pdf" style="border: solid 1px; border-radius:1px; box-shadow: 1px 1px 1px 1px black; width:80px;" >Filtrar PDF</button>
									<?php //echo formata_dinheiro($entradas_di); ?> 
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- FIM DA DIV BALAN�O DE MOVIMENTO FILTRAR POR DATA -->
	
	<!-- INICIO DA TABELA DE DADOS -->
	<div class="container-fluid" style="margin-top:0px; margin-left:90px; margin-right: 90px; padding: 0; ">
		<div class="panel panel-info" >
		<!--  CABE�ALHO DA TABELA DE DADOS -->
			<div class="panel-heading"  >
				<div class="row">
					<div class="col-sm-6" >
						<strong>RELATORIO DE CAIXA <?php if (isset($_GET['data_i'])){ ?>Data Inicial:  <?php echo invertData($data_i) ?><?php }else{ ?> :  <?php echo $mes_hoje ?>/<?php echo $ano_hoje ?><?php }?></strong>
					</div>
					<div class="col-sm-6" style="text-align: right;">
						<strong>
							<?php if (isset($_GET['filtrar_data'])){ $saldoanterior = $saldo_pf?>
								SALDO ANTERIOR:  <?php echo formata_dinheiro($saldoanterior) ?>
							<?php }else{ $saldoanterior = $saldo_ant?>
								SALDO ANTERIOR:  <?php echo formata_dinheiro($saldoanterior) ?>
							<?php }?>
						</strong>
					</div>
				</div>
			</div>
			<!--  CORPO DA TABELA DE DADOS -->
			<div class="panel-body" >
				<div class="container-fluid" >
					<table id="tb_home_filtrar" class="table table-responsive table-bordered table-striped table-condensed table-hover" >
						<thead>
							<th style=" text-align: center;">Seq.</th>
							<th style=" text-align: center;">Id.</th>
							<th style=" text-align: center;">Data</th>
							<th style=" text-align: left;">Descricao</th>
							<th style=" text-align: center;">Categoria</th>
							<th style=" text-align: center;">Livro/Folha</th>
							<th style=" text-align: center;">Entradas</th>
							<th style=" text-align: center;">Saidas</th>
							<th style=" text-align: center;">Saldo</th>
						</thead>					
						<tbody>
							<?php
								$pdo = new Database();
								$db = $pdo->dbConnection();
							
								// VERIFICAR SE O CAMPO BUSCA FOI PREENCHIDO
								if(isset($_GET['busca']) && $_GET['busca'] != ''){
									$busca = $_GET['busca'];
								} else{
									$busca = '';
								}
								// VERIFICAR SE A DATA INICIAL FOI PREENCHIDA
								if(isset($_GET['data_i']) && $_GET['data_i'] != ''){
									$data_i = invertData($_GET['data_i']);
								} else{
									$data_i = '';
								}
								// VERIFICAR SE A DATA FINAL FOI PREENCHIDA
								if(isset($_GET['data_f']) && $_GET['data_f'] != ''){
									$data_f = invertData($_GET['data_f']);
								} else{
									$data_f = '';
								}
								// COMANDOS SQL PARA VERIFICAR CAMPO BUSCA, DATA INICIAL E DATA FINAL
								if(isset($_GET['folha_i']) && isset($_GET['folha_f'])){
									$stmt = $db->prepare("SELECT * FROM lc_movimento WHERE idconta=:contapd and descricao LIKE :busca and idlivro=:idlivro and folha>=:folha_i and folha<=:folha_f ORDER BY datamov ASC");
									$stmt->bindparam(':contapd', $contapd );
									$stmt->bindvalue(':busca', '%'.$busca.'%' );
									$stmt->bindparam(':idlivro', $idlivro );
									$stmt->bindparam(':folha_i', $folha_i );
									$stmt->bindparam(':folha_f', $folha_f );
									$stmt->execute();
									$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	
								}else{
									
									$stmt = $db->prepare("SELECT * FROM lc_movimento WHERE idconta=:contapd and month(datamov)=:mes_hoje and year(datamov)=:ano_hoje ORDER BY datamov ASC");
									$stmt->bindparam(':contapd', $contapd );
									$stmt->bindparam(':mes_hoje', $mes_hoje );
									$stmt->bindparam(':ano_hoje', $ano_hoje );
									
									$stmt->execute();
									$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
								}
									 
								$cont=0;
								$seq=0;
								$saldo=0;
								
								foreach ($result as $row) {
								$cont++;
								$seq++;
								
								$cat = $row['cat'];
								$stmt = $db->prepare("SELECT * FROM lc_cat WHERE id='$cat'");
								$stmt->execute();
								$qr2=$stmt->fetch(PDO::FETCH_ASSOC);
								$categoria = $qr2['nome'];	
							?>
							
							<tr >
								<td style=" text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $seq; ?></strong></td>
								<td style=" text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>">
									<a style=" text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>" href="#edit<?php echo $row['id']; ?>" data-toggle="modal" name="btn_edit_mov" ><strong style="font-size:12px;"><i><u><?php echo $row['id']; ?></u></i></strong></a>									
								<?php include('operations/edit_mov.php'); ?>
								</td>
								<td style=" text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo InvertData($row['datamov']); ?></strong></td>
								<td style=" text-align: left; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $row['descricao']; ?></strong></td>
								<td style=" text-align: left; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $row['cat']; ?> - <a style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>" href="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>&filtro_cat=<?php echo $cat?>"><strong style="font-size:12px;"><?php echo $categoria?></a></td>
								<td style=" text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $row['idlivro']; ?>-<?php echo $row['folha']; ?></strong></td>
								<td style=" text-align: center;">
									<p style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><?php if ($row['tipo']==1) echo "+" ; else echo ""?><strong style="font-size:12px;"><?php if ($row['tipo']==1) echo formata_dinheiro($row['valor']); else echo "";?></strong></p>
								</td>
								<td style=" text-align: center;">
									<p style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#030"?>"><?php if ($row['tipo']==0) echo "-"; else echo ""?><strong style="font-size:12px;"><?php if ($row['tipo']==0) echo formata_dinheiro($row['valor']); else echo ""?></strong></p>
								</td>
								<?php if ($row['tipo']==1) formata_dinheiro($saldo=$saldo+$row['valor']); else formata_dinheiro($saldo=$saldo-$row['valor']); ?>
								<?php if(isset($_POST["filtrar_data"])) $acumulado = $saldoanterior + $saldo; else $acumulado = $saldoanterior+$saldo;?>
								<td style=" text-align: center;">
									<p style="color:<?php if ($acumulado>0) echo "#00f"; else echo"#C00" ?>"><strong style="font-size:12px;"><?php echo formata_dinheiro($acumulado);?></strong></p>
								</td>							
							</tr>					
							<?php  } ?>						
						</tbody>
					</table>
				</div>
			</div>
			<!--  RODAP� DA TABELA DE DADOS -->
			<div class="panel-footer" >
				<div class="container-fluid" >
					<table id="tb_home_f" class="table table-responsive table-bordered table-striped table-condensed table-hover" >
						<tr>
							<td style="width:220px; text-align: right; " COLSPAN="4"><strong> A TRANSPORTAR TOTAIS DO DIA </strong></td>
							<td style="width:100px; text-align: center; ">
								<strong>
									<span style="font-size:12px; color:<?php echo "#0000FF" ?>">
										<?php if (isset($_GET['filtrar_data'])){ $entradas_per = $entradas_f?>
										<?php echo formata_dinheiro($entradas_per) ?>
										<?php }else{ $entradas_per = $entradas_m?>
										<?php echo formata_dinheiro($entradas_per) ?>
										<?php }?>
									</span>
								</strong>
							</td>
							<td style="width:100px; text-align: center; ">
								<strong>
									<span style="font-size:12px; color:<?php echo "#C00" ?>">
										<?php if (isset($_GET['filtrar_data'])){ $saidas_per = $saidas_f?>
										<?php echo formata_dinheiro($saidas_per) ?>
										<?php }else{ $saidas_per = $saidas_m?>
										<?php echo formata_dinheiro($saidas_per) ?>
										<?php }?>
									</span>
								</strong>
							</td>

							<td style="width:100px; text-align: center; ">
								<strong>
									<span style="font-size:12px; color:<?php echo "#C00" ?>">
										<?php if (isset($_GET['filtrar_data'])){ $saldomesf = $saldo_afod ?>
										<?php echo formata_dinheiro($saldomesf) ?>
										<?php }else{ $saidas_per = $saidas_m?>
										<?php echo formata_dinheiro($saidas_per) ?>
										<?php }?>
									</span>
								</strong>
							</td>
						</tr>
						<tr>
							<td style="width:180px; text-align: right; " COLSPAN="4"><strong> SALDO ANTERIOR </strong></td>
							<td style="width:100px; text-align: center; ">
								<strong>
									<span style="font-size:12px; color:<?php echo "#006400" ?>">
										<?php if (isset($_GET['filtrar_data'])){ $saldoanterior = $saldo_afod?>
										<?php echo formata_dinheiro($saldoanterior) ?>
										<?php }else{ $saldoanterior = $saldo_ant?>
										<?php echo formata_dinheiro($saldoanterior) ?>
										<?php }?>
									</span>
								</strong>
							</td>
							<td style="width:100px; text-align: center; "></td>
							<td style="width:100px; text-align: center; "></td>
						</tr>
						<tr>
							<td style="width:180px; text-align: right; " COLSPAN="4"><strong> SALDO ATUAL </strong></td>
							<td style="width:100px; text-align: center; "></td>
							<td style="width:100px; text-align: center; "></td>
							<td style="width:100px; text-align: center; ">
								<strong>
									<span style="font-size:14px; color:<?php echo "#006400" ?>">
										<?php if (isset($_GET['filtrar_data'])){ $saldo_atual = $saldo_afod+$entradas_f-$saidas_f?>
										<?php echo formata_dinheiro($saldo_atual) ?>
										<?php }else{ $saldo_atual = $resultado_mes?>
										<?php echo formata_dinheiro($saldo_atual) ?>
										<?php }?>
									</span>
								</strong>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<!-- INICIO DO FORMULARIO MODAL FILTRAR POR DATA -->
    <div class="modal fade" id="modal_date" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Exportar p/ PDF Ref.: <?php echo $mes_hoje ?>/<?php echo $ano_hoje ?> - Conta: <?php echo $contapd ?></h4></center>
                </div>
                <div class="modal-body" >
					<div class="panel panel-primary">
						<div class="panel-body">
							<form class="form-inline" name="form_filtro_cat" method="POST" action="rel_cx_periodo.php">
								
								<div class="controls">
									<label class="control-label" for="inputName">Data Inicial:</label>
									<input type="text" name="data_ini" id="data_ini" value="<?php echo invertData($dti) ?>" class="form-control input-sm" size="8">
									<label class="control-label" for="inputName">Data Final:</label>
									<input type="text" name="data_fim" id="data_fim" value="<?php echo invertData($dti) ?>" class="form-control input-sm" size="8">
								</div>
								<br>
								<div class="controls">
									<label class="control-label" for="inputName">Pesquisar: </label>
									<input type="text" name="busca" placeholder="busca" class="form-control input-sm">
									<label class="control-label" for="inputName">Conta:</label>
									<input type="text" name="conta" value="<?php echo $contapd?>" class="form-control input-sm" size="1">
									<button type="submit" class="btn btn-warning btn-sm" name="btn_date_pdf" ><span class="glyphicon glyphicon-check"></span> Imprimir em PDF </button>	
								</div>
							</form>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<!-- /.modal -->
	
<?php include "operations/add_mov.php" ?>

<?php include "modal_pdf.php" ?>

	<div class="container-fluid" style="margin-top:0px; margin-left: 120px; margin-right: 120px; padding: 0; ">	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- necess�rio para abrir os DataTables -->
		<script src="assets/js/dataTables/js/jquery.dataTables.js"></script>
		<script src="assets/js/dataTables/js/dataTables.bootstrap.js"></script>
		
		<!-- necess�rio para abrir o calendario datepicker -->
		<script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
		
		<script type="text/javascript">
		  $(function () {
			// toolip
			$('[data-toggle="tooltip"]').tooltip();
			// datatables
			$('#tb_home_filtrar').dataTable( {
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