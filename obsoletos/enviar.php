<?php
if (isset($_POST['btn_edit_mov'])){

	
	$id = $_POST['id'];
	$tipo = $_POST['tipo'];
	$folha = $_POST['folha'];
	$cat = $_POST['cat'];
	$descricao = $_POST['descricao'];
	$valor = $_POST['valor'];
	$datamov = $_POST['hoje'];
	$idconta = $_POST['idconta'];
	
	$t = explode("-", $datamov);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];
	$url = "home.php?mes=" . $mes . "&ano=" . $ano ;
	
	
	echo "id:" . $id . "</br>";
	echo "data:" . $datamov . "</br>";
	echo "tipo:" . $tipo . "</br>";
	echo "cat:" . $cat . "</br>";
	echo "descricao:" . $descricao . "</br>";
	echo "valor:" . $valor . "</br>";
	echo "folha:" . $folha . "</br>";
	echo "idconta:" . $idconta . "</br>";
	echo "dia:" . $dia . "</br>";
	echo "mes:" . $mes . "</br>";
	echo "ano:" . $ano . "</br>";
	echo $url;
	
	
	
	
	
	require_once('class.cat.php');
	include 'functions.php';
	$mov = new 	EVENTS_CAT();
		
	
		if($mov->update_mov($id,$tipo,$dia,$mes,$ano,$folha,$cat,$descricao,$valor,invertData($datamov),$idconta)){
			$mov->redirect($url);
		}else{
			$status = "Dados Incorretos !";
		}
	
	
}
?>