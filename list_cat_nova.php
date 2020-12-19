<?php
	require_once("config/session.php");
	require_once("class/class.user.php");
	include "config/config_session.php";
	include "parameters.php";
?>
<?php // arquivo de paginação
// ARQUIVO DE PAGINAÇÃO

if (isset($_GET['pagina']) && $_GET['pagina']!=""){
	$pagina = $_GET['pagina'];
} else{
	$pagina = 1;
}
if (isset($_GET['itenspag']) && $_GET['itenspag']!= ''){
		$numporpagina = $_GET['itenspag'];
	} else {
		$numporpagina = 5 ;
	}
//$search = isset($_GET['search']) ? $_GET['search'] : '';
if (isset($_GET['search']) && $_GET['search'] != '') {
	$search = $_GET['search'];						
	$sql = "SELECT * FROM lc_cat WHERE nome LIKE :search OR operacao LIKE :search ORDER BY nome ";	
	$resultado = $db->prepare($sql);
	$resultado->bindValue(':search','%'. $search . '%');
	$resultado->execute();
	$numtotalregistros = $resultado->fetchColumn();
	$numporpagina = $numtotalregistros;
}
else{
	$search = '';
	$sqlcount = "SELECT COUNT(*) FROM lc_cat";
	$sql = "SELECT COUNT(*) FROM lc_cat ORDER BY nome ";
	$resultado = $db->prepare($sql);
	$resultado->execute();
	$numtotalregistros = $resultado->fetchColumn();
}	


	// Quantidade de páginas a exibir
	$numPaginas = ceil($numtotalregistros/$numporpagina);
	//define o limite inicial
	$inicio = ($numporpagina*$pagina)- $numporpagina;
	$limit=" limit " . $inicio . "," . $numporpagina;
	// consulta para gerar os dados da paginação
if (isset($_GET['search']) && $_GET['search'] != '') {
	$search = $_GET['search'];	
	$querypaginada = $db->prepare("SELECT * FROM lc_cat WHERE nome LIKE :search OR operacao LIKE :search" . $limit);
	$querypaginada->bindValue(':search','%'. $search . '%');
	$querypaginada->execute();
	$numtotalregistros = $resultado->fetchColumn();
	$numporpagina = $numtotalregistros;
}
else{
	$search = '';
	$sqllist = "";
	$querypaginada = $db->prepare("SELECT * FROM lc_cat" . $limit);
	$querypaginada->execute();
}
	//$itenstotais = $querypaginada->fetch(PDO::FETCH_ASSOC);	
	//$itenstotais = $querypaginada->fetchAll(PDO::FETCH_OBJ);
	
	$pripagina = ($numPaginas - $numPaginas) + 1;
	$ultpagina = $numPaginas;
	$proxima = $pagina + 1;
	$anterior = $pagina - 1;

	$limiteDeLinks = 7;

	$lim_inicial = (($pagina > 1) ? $pagina - $limiteDeLinks : 1);
	$lim_final = ((($pagina + $limiteDeLinks) < $numPaginas) ? $pagina + $limiteDeLinks : $numPaginas);	
	
	$inicial = $inicio + 1;
	//if ($pagina = 1) {
		$final = $inicio + $numporpagina ;
	
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
							<li><a href="list_cat.php"> Adicionar Categorias </a></li>
							<li class="divider"></li>
							<li><a href="filtrarpordata.php"> Filtrar por Data </a></li>
							<li class="divider"></li>
							<li><a href="filtrarporfolha.php"> Filtrar por Folha </a></li>
							<li class="divider"></li>
							<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> profile</a></h5></li>
							<li class="divider"></li>
						</ul>
					</li>
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
					  <span class="glyphicon glyphicon-user"></span>&nbsp;Usu&aacute;rio: <?php echo $userRow['user_name']; ?>&nbsp;<span class="caret"></span></a>
						  <ul class="dropdown-menu">
							<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
							<li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
						  </ul>
					</li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>	
	<!-- FIM DA NAVBAR BLACK -->	
	<div class="container-fluid" style="margin-top:40px; margin-left:90px; margin-right: 90px; padding: 0; ">
		<div class="bs-example">
			<div class="panel panel-default">
				<!-- Default panel contents -->
				<div class="panel-heading">User Information</div>
					<div class="panel-body">
						<div class="container-fluid" >
							<form  class="form-inline" name="form_filtro_cat" method="get" action="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>">
								<div class="row">
								a
								</div>
								<div class="form-group" style="text-align: left;">
									<span><strong><label> Pagina: </label></strong></span>
										<select class="form-control input-sm" name="pagina" style="text-align: left;">
											<?php $p=1;
												for ($p=1;$p<=$numPaginas;$p++){
												?>
												<option value="<?php echo $p?>" <?php if ($p==$pagina) echo "selected=selected"?> ><?php echo $p?></option>
											<?php }?>
										</select>
									<span><strong> De </strong></span><input type="text" name="npag"  class="form-control input-sm" placeholder="nº paginas" style="width:50px;" value="<?php echo $numPaginas ?>" > paginas ||
								</div>
								<div class="form-group" style="text-align: center;">
										<span><input type="text" name="itenspag" class="form-control input-sm" placeholder="Itens por pagina" style="width:50px;" value="<?php echo $numporpagina ?>"><strong> Itens/paginas: </strong></span> ||
								</div>
								<div class="form-group" style="text-align: right;">
										<span><strong> Itens  <?php echo $inicial . " a " . $final ?> </strong></span>
								</div>
								<div class="form-group" style="text-align: center;">
									<span><strong> Busca: </strong></span><input type="text" name="search" class="form-control input-sm"  style="width:180px;" value="<?php echo $search ?>">	
								</div>
					
								<button type="submit" name="busca_filtro" class="btn btn-default">Filtrar</button>
					
								<span ><a href="#addnew" data-toggle="modal" class="btn btn-primary" ><span class="glyphicon glyphicon-plus" ></span> Novo </a></span>
							</form>
				
						</div>
					</div>
					
		<!-- Table -->
			</div>	
		</div>
		</div>
		<!-- DIV FORMULÁRIO DA LISTAGEM DAS CATEGORIAS -->
		<div class="container-fluid" style="margin-top:0px; margin-left:90px; margin-right: 90px; padding: 0; ">
			<div class="panel panel-primary" >
				<!-- BOTÕES SUPERIORES DA PAGINAÇÃO -->
				<div class="panel-heading" style="background-color: #C5F5DC; ">	
					<?php $busca = "&num_pag=" . $numPaginas . "&itenspag=" . $numporpagina?>
					<?php include "botoes_paginacao.php"; ?>
				</div><!-- FIM DA TAG DOS BOTÕES SUPERIORES -->
				<!-- CORPO DO PAINEL, FORMULARIO DE BUSCA, BOTÔES "FILTRAR" E "NOVO" E LISTA DAS CATEGORIAS -->
				<div class="page-header" >
					<!-- FORMULARIO DE BUSCA, PAGINAS, ITENS, ETC. -->
					
					<!-- TABELA DE DADOS DAS CATEGORIAS -->
					<div class="container-fluid" >
						<table class="table table-bordered table-striped table-condensed table-hover" >
							<thead>
								<th>ID</th>
								<th>Descrição</th>
								<th>Tipo Operação</th>
								<th>Botões</th>
							</thead>
							<tbody>
							<?php
							// aqui começa o loop dos dados
							while ($row = $querypaginada->fetch(PDO::FETCH_ASSOC)) { ?>
								<tr>
									<td><a href="#edit<?php echo $row['id']; ?>" data-toggle="modal" name="btn_edit_cat" ><b><i><u><?php echo $row['id']; ?></u></i></b></a></td>
									<td><?php echo $row['nome']; ?></td>
									<td><?php echo $row['operacao']; ?></td>
									<td>
										<a href="#edit<?php echo $row['id']; ?>" data-toggle="modal" name="btn_edit_cat" class="btn btn-warning" style="border: solid 1px; border-radius: 1px; box-shadow: 1px 1px 1px 1px black; border-radius:3px 3px 3px 3px;"><span class="glyphicon glyphicon-edit"></span> Alterar </a> || 
										
										<?php include('operations/edit_del_cat.php'); ?>
									</td>
								</tr>
							<?php } ?>

							</tbody>
						</table>
					</div>
				</div> 
				<!-- BOTÔES INFERIORES DA PAGINAÇÃO -->
				<div class="panel-footer">
				<?php $busca = "&npag=" . $numPaginas . "&itenspag=" . $numporpagina?>
					<?php include "botoes_paginacao.php"; ?>
					<?php include('operations/add_cat.php'); ?>
				</div><!-- FIM DA TAG DOS BOTÔES INFERIORES -->
			</div>
		</div>
<!--  BALANCOS MENSAL E ANUAL -->

<!--  FORMULARIO DE FILTROS: DATAS, CATEGORIAS -->
	<!-- INICIO DA TABELA DE DADOS -->	
</body>
</html>