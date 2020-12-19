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

<!-- SELECT DO ANO, LISTA DOS MESES MENUS DE ATALHO -->	
<div class="container-fluid" style="margin-top:20px; margin-left:90px; margin-right: 90px; padding: 0;">
  
</div>
<!--  BALANCOS MENSAL E ANUAL -->
<div class="container-fluid" >
  
</div>
<!--  FORMULARIO DE FILTROS: DATAS, CATEGORIAS -->
	<!-- INICIO DA TABELA DE DADOS -->	
<div class="container-fluid" >
  <?php //<!-- COMANDO PHP PARA MOSTRAR A TABELA DE DADOS  -->
	include "table_home.php";
	include "operations/add_mov.php"; 
	include "rodape.php";  	  
  ?>
</div>

<div class="container-fluid" style="margin-top:0px; margin-left: 120px; margin-right: 120px; padding: 0; ">	
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