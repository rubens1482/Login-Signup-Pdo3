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

// ENTRADAS ENTRE A DATA INICIAL E A DATA FINAL  "CORRIGIDO"
if (isset($_GET['filtrar_data'])){
	$data_i = invertData($_GET['data_i']);
	$data_f = invertData($_GET['data_f']);
	$stmt = $db->prepare("SELECT SUM(valor) as entradas_ep FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo1 and datamov>=:data_i and datamov<=:data_f");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo1', $tipo1 );
	$stmt->bindparam(':data_i', $data_i );
	$stmt->bindparam(':data_f', $data_f );
	$stmt->execute();
	$qreep=$stmt->fetch(PDO::FETCH_ASSOC);
	$entradas_ep=$qreep['entradas_ep'];
// SAIDAS ENTRE A DATA INICIAL E A DATA FINAL	 "CORRIGIDO"
	$data_i = invertData($_GET['data_i']);
	$data_f = invertData($_GET['data_f']);
	$stmt = $db->prepare("SELECT SUM(valor) as saidas_ep FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo0 and datamov>=:data_i and datamov<=:data_f");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo0', $tipo0 );
	$stmt->bindparam(':data_i', $data_i );
	$stmt->bindparam(':data_f', $data_f );
	$stmt->execute();
	$qrsep=$stmt->fetch(PDO::FETCH_ASSOC);
	$saidas_ep=$qrsep['saidas_ep'];
// DEFINIÇÃO DO FILTRO PARA ENTRADA ANTERIOR POR PERIODO
}else{
	
}

// ENTRADAS ANTES DA DATA INICIAL  "CORRIGIDO"
if (isset($_GET['filtrar_data'])){
	$data_i = invertData($_GET['data_i']);
	
	//$data_f = invertData($_POST['data_f']);
	// ENTRADAS ANTES DA DATA INICIAL
	$stmt = $db->prepare("SELECT SUM(valor) as entradas_di FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo1 and datamov<:data_i");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo1', $tipo1 );
	$stmt->bindparam(':data_i', $data_i );
	$stmt->execute();
	$qredi=$stmt->fetch(PDO::FETCH_ASSOC);
	$entradas_di=$qredi['entradas_di'];	
	echo $entradas_di;
// SAIDA ANTES DA DATA INICIAL  "CORRIGIDO"
	$data_i = invertData($_GET['data_i']);
	$stmt = $db->prepare("SELECT SUM(valor) as saidas_di FROM lc_movimento WHERE idconta=:contapd and tipo=:tipo0 and datamov<:data_i");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo0', $tipo0 );
	$stmt->bindparam(':data_i', $data_i );
	$stmt->execute();
	$qrsdi=$stmt->fetch(PDO::FETCH_ASSOC);
	$saidas_di=$qrsdi['saidas_di'];
// SALDO ANTERIOR A DATA INICIAL
	$saldo_dti = $entradas_di-$saidas_di;		
	
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
	<?php 
	// include "form_meses.php";
	include "navbarblack.php";  
	?>  
	<div class="container-fluid" style="margin-top:20px; margin-left:90px; margin-right: 90px; padding: 0;">
	  <?php 
	   include "modal_pdf.php";  
	  ?>
	</div>	
	<!-- DIV SELECT DO ANO, LISTA DOS MESES MENUS DE ATALHO -->
	<div class="container-fluid" id="div_geral" >
		<?php 
		include "balanco_fd.php";
		?>
	</div>
	<!--  FORMULARIO DE FILTROS: DATAS, CATEGORIAS -->
	
		<!-- FORMULARIO DE BUSCA, DATA INICIAL, DATA FINAL E FILTRO DE CATEGORIAS  ?mes=<?php //echo $mes_hoje?>&ano=<?php //echo $ano_hoje?>-->
		<?php
			include "table_filtrardata.php";
		?>
			
	<!-- INICIO DA TABELA DE DADOS  -->
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
			$('#tb_home_f').dataTable( {
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