<?php
	require_once("config/session.php");
	require_once("class/class.user.php");
	include "config/config_session.php";
	include "parameters.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/jquery.min.js"></script>
	
	<script>
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

        // datatables
        $('#tb_home_2').dataTable( {
			"bJQueryUI": true,
			"sDom": '<"H"Tlfr>t<"F"ip>',
			"sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
			"sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "lengthMenu": [[2, 5, 10, 12, 15, 25, -1], [2, 5, 10, 12, 15, 25, "All"]],
            "pageLength": 5,
			"pagingType": "full_numbers",
			"sSearch": "Pesquisar: ",
			"order": [[ 3, "desc" ]],
			"order": [[ 2, "asc" ]],
			"info":     true
        } );
      })
    </script>
	<title> welcome - <?php print($userRow['user_name']); ?></title>
</head>
<body>
	
<!-- NAVBAR PRINCIPAL COM NOME DA CONTA, DATA ATUAL, MENU DA CONTA E MENU DO USUARIO -->
<nav class="navbar navbar-default navbar-fixed-top">
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
		</div><!--/.nav-collapse -->
	</div>
</nav>   
<!-- SELECT DO ANO, LISTA DOS MESES MENUS DE ATALHO -->	
<div class="container-fluid" style="margin-top:20px; margin-left:90px; margin-right: 90px; padding: 0;">
	<?php 
	include "form_meses.php";
	include "modal_pdf.php"; 
	?>
</div>	
<!--  BALANCOS MENSAL E ANUAL -->
<div class="container-fluid" >
	<?php 
		include "balanco2.php";
		include "table_home_2.php";
		include "add_mov.php";
	?>
	<footer class="footer" border="1">
			<table class="table table-responsive table-bordered table-striped table-condensed table-hover" >
				<tr>
					<td style="width:180px; text-align: right; " COLSPAN="4"><strong> A TRANSPORTAR TOTAIS DO DIA </strong></td>
					<td style="width:100px; text-align: center; "><?php echo formata_dinheiro($entradas_m); ?></td>
					<td style="width:100px; text-align: center; "><?php echo formata_dinheiro($saidas_m) ?></td>
					<td style="width:100px; text-align: center; "><?php echo ""; ?></td>
				</tr>
				<tr>
					<td style="width:180px; text-align: right; " COLSPAN="4"><strong> SALDO ANTERIOR </strong></td>
					<td style="width:100px; text-align: center; "></td>
					<td style="width:100px; text-align: center; "></td>
					<td style="width:100px; text-align: center; "><?php echo formata_dinheiro($saldoanterior) ?></td>
				</tr>
				<tr>
					<td style="width:180px; text-align: right; " COLSPAN="4"><strong> SALDO ATUAL </strong></td>
					<td style="width:100px; text-align: center; "><?php echo formata_dinheiro($resultado_mes) ?></td>
					<td style="width:100px; text-align: center; "></td>
					<td style="width:100px; text-align: center; "></td>
				</tr>
			</table>	
	</footer>
	<script src="assets/js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="assets/js/bootstrap.min.js"></script>
	
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