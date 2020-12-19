<?php
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

// ENTRADAS DA FOLHA SELECIONADA
if (isset($_GET['filtrar_data'])){
	$folha_i = $_GET['folha_i'];
	$folha_f = $_GET['folha_f'];
	$stmt = $db->prepare("SELECT SUM(valor) as entradas_f FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo1 and folha>=:folha_i and folha<=:folha_f");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo1', $tipo1 );
	$stmt->bindparam(':folha_i', $folha_i );
	$stmt->bindparam(':folha_f', $folha_f );
	$stmt->execute();
	$qrepf=$stmt->fetch(PDO::FETCH_ASSOC);
	$entradas_f=$qrepf['entradas_f'];
// SAIDAS DA FOLHA SELECIONADA
	$folha_i = $_GET['folha_i'];
	$folha_f = $_GET['folha_f'];
	$stmt = $db->prepare("SELECT SUM(valor) as saidas_f FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo0 and folha>=:folha_i and folha<=:folha_f ");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo0', $tipo0 );
	$stmt->bindparam(':folha_i', $folha_i );
	$stmt->bindparam(':folha_f', $folha_f );
	$stmt->execute();
	$qrspf=$stmt->fetch(PDO::FETCH_ASSOC);
	$saidas_f=$qrspf['saidas_f'];

}else{
	
}
// ENTRADAS ANTES DA FOLHA DIGITADA  "CORRIGIDO"
if (isset($_GET['filtrar_data'])){
	$folha_i = $_GET['folha_i'];
	$stmt = $db->prepare("SELECT SUM(valor) as entradas_fo FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo1 and folha<:folha_i");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo1', $tipo1 );
	$stmt->bindparam(':folha_i', $folha_i );
	$stmt->execute();
	$qrefo=$stmt->fetch(PDO::FETCH_ASSOC);
	$entradas_fo=$qrefo['entradas_fo'];	
	echo $entradas_fo;
// SAIDA ANTES DA FOLHA DIGITADA  "CORRIGIDO"
	$folha_i = $_GET['folha_i'];
	$stmt = $db->prepare("SELECT SUM(valor) as saidas_fo FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo0 and folha<:folha_i");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo0', $tipo0 );
	$stmt->bindparam(':folha_i', $folha_i );
	$stmt->execute();
	$qrsfo=$stmt->fetch(PDO::FETCH_ASSOC);
	$saidas_fo=$qrsfo['saidas_fo'];
// SALDO ANTERIOR A FOLHA DIGITADA
	$saldo_dfo = $entradas_fo-$saidas_fo;		
	
}else{
	
}
	
// SALDO ANTERIOR CASO O MÊS SEJA JANEIRO OU OUTROS MESES...
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
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	
	<script type="text/javascript" language="javascript">
	  $( function() {
		  $( "#datamov, #datamov, #datapicker" ).datepicker({
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
	<script type="text/javascript" language="javascript">
		function valida_form (){
			if(document.getElementById("data_i").value == ""){
			alert('Por favor, preencha o campo Data Inicial');
			document.getElementById("data_i").focus();
			return false
			} else {
				if(document.getElementById("data_f").value == ""){
					alert('Preencha o campo Data Final');
					document.getElementById("data_f").focus();
					return false
				}
			}
		}
	</script>
<title>welcome - <?php print($userRow['user_email']); ?></title>
</head>
<body>
<!-- NAVBAR PRINCIPAL COM NOME DA CONTA, DATA ATUAL, MENU DA CONTA E MENU DO USUARIO -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"> ok</span>
				<span class="icon-bar"> vamos </span>
				<span class="icon-bar"> terá </span>
			  </button>
			  <a class="navbar-brand" href="http://www.localhost/Login-Signup-Pdo/home.php">Livro Caixa <?php print $accountRow['conta'] ?></a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="?mes=<?php echo date('m')?>&ano=<?php echo date('Y')?>"><?php print "Hoje &eacute:"?><strong> <?php echo date('d')?> de <?php echo mostraMes(date('m'))?> de <?php echo date('Y')?></strong></a></li>	
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					  <span class="glyphicon glyphicon-user"></span>&nbsp;Conta: <?php echo $accountRow['idconta'] . "-" . $accountRow['conta']; ?>&nbsp;<span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
						<li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
					  </ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
						  <ul class="dropdown-menu">
							<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
							<li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
						  </ul>
					</li>
				</ul>
			</div>
		</div>
    </nav>   

<div class="container-fluid" id="div_geral" style="margin-top:60px; margin-left:90px; margin-right: 90px; margin-bottom: 0; padding: 0;">
	<!-- SELECT DO ANO, LISTA DOS MESES MENUS DE ATALHO -->
	<div class="container-fluid" id="menu_ano_mes">	
		
			<div class="panel panel-danger">
				<div class="panel-body">
				<form class="form-inline">
					<label for="email">
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
					<div class="btn-group">
						<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Ir Para: <span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><a href="list_cat.php"> Adicionar Categorias </a></li>
							<li class="divider"></li>
							<li><a href="filtrarpordata.php"> Filtrar por Data </a></li>
							<li class="divider"></li>
							<li><a href="home.php"> Home </a></li>
							<li class="divider"></li>
							<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> profile</a></h5></li>
							<li class="divider"></li>
						</ul>
					</div>
					<button type="button" 
						class="btn btn-md btn-default" 
						data-toggle="button"><strong><?php echo mostraMes($mes_hoje)?>/<?php echo $ano_hoje?></strong>
					</button>
					</form>
				</div>
			</div>
				
	</div><!--   -->	    
	<!--  BALANCOS MENSAL E ANUAL -->
	<div class="container-fluid" id="balancos">
		<div class="panel panel-danger" >
			<div class="panel-heading"  > 
				BALANCOS DE MOVIMENTO 
			</div>
				<div class="panel-body" >
					<div class="row">
						<!--  BALANÇO MENSAL -->
						<div class="col-sm-6" style=" border-top: 1px dashed #f00; border-bottom: 1px dashed #f00;">
							<fieldset class="scheduler-border" >
							<legend style="border-color: #ccc;"> <?php if (isset($_GET['filtrar_data'])) { echo "BALANCO - Folha " . $folha_i . " à " . $folha_f; }else{ echo "BALANCO MENSAL " . $mes_hoje . "/" . $ano_hoje ;}?></legend>
								<!--  SALDO ANTERIOR  BALANÇO MENSAL -->
								<div class="row" >
									<div class="col-sm-6" style="text-align: left;" >
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Anterior:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong>
											<span style="font-size:14px; color:<?php echo "#006400" ?>">
												<?php if (isset($_GET['filtrar_data'])){ $saldoanterior = $saldo_dfo?>
												<?php echo formata_dinheiro($saldoanterior) ?>
												<?php }else{ $saldoanterior = $saldo_ant?>
												<?php echo formata_dinheiro($saldoanterior) ?>
												<?php }?>	
											</span>
										</strong>	
									</div>
								</div>
								<!--  ENTRADAS BALANÇO MENSAL -->
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
								<!--  SAIDAS BALANÇO MENSAL -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left;">
										<strong><span style="font-size:14px; color:<?php echo "#C00" ?>">Saidas:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
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
									<hr style="border-top: 1px dotted #8c8b8b; ">
								</div>
								<!--  SALDO ATUAL BALANÇO MENSAL  -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left;">
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Atual:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong>
											<span style="font-size:14px; color:<?php echo "#006400" ?>">
												<?php if (isset($_GET['filtrar_data'])){ $saldo_atual = $saldo_dfo+$entradas_f-$saidas_f?>
												<?php echo formata_dinheiro($saldo_atual) ?>
												<?php }else{ $saldo_atual = $resultado_mes?>
												<?php echo formata_dinheiro($saldo_atual) ?>
												<?php }?>
											</span>
										</strong>
									</div>
								</div>
							</fieldset>	
						</div>
						<!-- BALANÇO ANUAL  -->	
						<div class="col-sm-6" style=" border-top: 1px dashed #f00; border-bottom: 1px dashed #f00;">
							<fieldset class="scheduler-border" >
							<legend style="border-color: #ccc;"> BALANCO ACUMULADO ATÉ <?php echo $mes_hoje . "/" . $ano_hoje?></legend>
								<!--  SALDO ANTERIOR  BALANÇO ANUAL -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left;">
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Anterior:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>"><?php print formata_dinheiro($saldo_aa) ?></span></strong>
									</div>
								</div>
								<!--  ENTRADAS  BALANÇO ANUAL -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left;">
										<strong><span style="font-size:14px; color:<?php echo "#0000FF" ?>">Entradas:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong><span style="font-size:14px; color:<?php echo "#0000FF" ?>"><?php print formata_dinheiro($ent_acab) ?></span></strong>
									</div>
								</div>
								<!--  SAIDAS BALANÇO ANUAL -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left;">
										<strong><span style="font-size:14px; color:<?php echo "#C00" ?>">Saidas:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong><span style="font-size:14px; color:<?php echo "#C00" ?>"><?php print formata_dinheiro($sai_acab) ?></span></strong>	
									</div>
									<hr style="border-top: 1px dotted #8c8b8b;">
								</div>
								<!--  SALDO ATUAL BALANÇO ANUAL -->
								<div class="row">
									<div class="col-sm-6" style=" text-align: left;">
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Atual:</span></strong>
									</div>
									<div class="col-sm-6" style=" text-align: right;">
										<strong><span style="font-size:14px; color:<?php echo "#006400" ?>"><?php print formata_dinheiro($saldo_acab) ?></span></strong>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
			<div class="panel-footer" >
				<a href="add_cat.php" class="btn btn-success btn-md">
					<span class="glyphicon glyphicon-pencil"></span> + Categoria
				</a>
				<a href="javascript:;" onclick="abreFecha('add_conta')" class="btn btn-success btn-md" >
					<span class="glyphicon glyphicon-pencil"></span> + Conta 
				</a>
				<a href="javascript:;" onclick="abreFecha('add_movimento')" class="btn btn-success btn-md" >
					<span class="glyphicon glyphicon-edit"></span> Adicionar Movimento 
				</a>
				<a href="javascript:;" onclick="abreFecha('add_movimento')" >ok</a>
				<a href="#modal_date" class="btn btn-sm btn-success " name="modal_periodo" data-toggle="modal">
					<i class="glyphicon glyphicon-plus"></i> pdf
				</a>
				<a href="#" class="btn btn-default btn-sm">Decline</a>
				<span ><a href="#addmov" data-toggle="modal" class="btn btn-primary btn-sm" name="btn-add-mov" style="border: solid 1px; border-radius: 1px; box-shadow: 1px 1px 1px 1px black; border-radius:3px 3px 3px 3px;"><span class="glyphicon glyphicon-plus" ></span> Novo </a></span>
				<?php include "operations/add_mov.php" ?>
				<?php include "modal_date.php" ?>
			</div>
		</div>	
	</div>
<!--  FORMULARIO DE FILTROS: DATAS, CATEGORIAS -->
	<div class="container-fluid" id="filtros_dados_datas">
		<!-- FORMULARIO DE BUSCA, DATA INICIAL, DATA FINAL E FILTRO DE CATEGORIAS  ?mes=<?php //echo $mes_hoje?>&ano=<?php //echo $ano_hoje?>-->
		<form class="form-inline" name="form_filtro_cat" method="get" action="" onsubmit="return valida_form(this)">
			<div class="panel panel-danger">
				<div class="panel-body">	
					<span><strong> filtrar por cod/desc: </strong></span><input type="text" name="busca" class="form-control input-sm" style="width:180px;" value="">
					<span><strong> Folha Inicial: </strong></span><input type="text" name="folha_i" id="folha_i" class="form-control input-sm"  style="width:70px;" value="" >
					<span><strong> Folha Final: </strong></span><input type="text" name="folha_f" id="folha_i" class="form-control input-sm"  style="width:70px;" value="" >

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
	<!-- INICIO DA TABELA DE DADOS  -->
	<div class="container-fluid" id="tabela_dados">
		<div class="panel panel-info" >
			<!--  CABEÇALHO DA TABELA DE DADOS -->
			<div class="panel-heading"  >
				<div class="row">
					<div class="col-sm-6" >
						<strong>RELATORIO DE CAIXA <?php if (isset($_GET['data_i'])){ ?>Data Inicial:  <?php echo invertData($data_i) ?><?php }else{ ?> :  <?php echo $mes_hoje ?>/<?php echo $ano_hoje ?><?php }?></strong>
					</div>
					<div class="col-sm-6" style="text-align: right;">
						<strong>
							<?php if (isset($_GET['filtrar_data'])){ $saldoanterior = $saldo_dfo?>
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
					<table class="table table-responsive table-bordered table-striped table-condensed table-hover" >
						<thead>
							<th style=" text-align: center;">Seq.</th>
							<th style=" text-align: center;">Id.</th>
							<th style=" text-align: center;">Data</th>
							<th style=" text-align: left;">Descricao</th>
							<th style=" text-align: center;">Categoria</th>
							<th style=" text-align: center;">Folha</th>
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
							if(isset($_GET['folha_i']) && $_GET['folha_i'] != ''){
								$folha_i = $_GET['folha_i'];
							} else{
								$data_i = '';
							}
							// COMANDOS SQL PARA VERIFICAR CAMPO BUSCA, DATA INICIAL E DATA FINAL
							if(isset($_GET['folha_i']) && isset($_GET['folha_f'])){
								$stmt = $db->prepare("SELECT * FROM lc_movimento WHERE idconta=:contapd and descricao LIKE :busca and folha>=:folha_i and folha<=:folha_f ORDER BY datamov ASC");
								$stmt->bindparam(':contapd', $contapd );
								$stmt->bindvalue(':busca', '%'.$busca.'%' );
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
								<td style=" text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $row['folha']; ?></strong></td>
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
			<!--  RODAPÉ DA TABELA DE DADOS -->
			<div class="panel-footer" >
				<div class="container-fluid" >
					<table class="table table-responsive table-bordered table-striped table-condensed table-hover" >
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
							<td style="width:100px; text-align: center; "><?php echo "" ?></td>
						</tr>
						<tr>
							<td style="width:180px; text-align: right; " COLSPAN="4"><strong> SALDO ANTERIOR </strong></td>
							<td style="width:100px; text-align: center; ">
							<strong>
								<span style="font-size:12px; color:<?php echo "#006400" ?>">
									<?php if (isset($_GET['filtrar_data'])){ $saldoanterior = $saldo_dfo?>
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
									<?php if (isset($_GET['filtrar_data'])){ $saldo_atual = $saldo_dfo+$entradas_ep-$saidas_ep?>
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
</div>
</script>

</body>

</html>