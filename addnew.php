<?php
// require_once("class.cat.php");
// $cat = new EVENTS_CAT();
// COMANDO PARA ADICIONAR CATEGORIAS NOVAS
/*
if(isset($_POST['btn-addcat'])){
	$nome = strip_tags($_POST['nome']);
	$operacao = strip_tags($_POST['operacao']);
	
	if($nome=="")	{
		$error[] = "Digite o nome !";	
	}
	else if($operacao=="")	{
		$error[] = "falta a operacao !";	
	}
	else
	{
		try
		{
			$stmt = $cat->Sql_Query("SELECT nome, operacao FROM lc_cat WHERE nome=:nome and operacao=:operacao");
			$stmt->execute(array(':nome'=>$nome, ':operacao'=>$operacao));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
				
			if($row['nome']==$nome) {
				$error[] = "categoria ja existe !";
			}
			else if($row['operacao']==$operacao) {
				$error[] = "Operacao já existe para esta categoria!";
			}
			else
			{
				if($cat->new_cat($nome,$operacao)){	
					$cat->redirect('list_cat.php');
				} else {
					echo $error;
					$cat->redirect('list_cat.php?Categoria_nao_inserida');	
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}	
}
// EVENTO PARA ATUALIZAR INFORMAÇÕES DA CATEGORIA
*/

/*
if (isset($_POST['btn_update_cat'])){
	
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$operacao = $_POST['operacao'];
	
	if($cat->update_cat($id,$nome,$operacao)){
		$cat->redirect('list_cat.php?pagina=1');
	}else{
		$status = "Dados Incorretos !";
	}
}
// EVENTO PARA DELETAR CATEGORIA
*/
/*
if (isset($_POST['btn_delete'])){
	
	$id = $_POST['id'];
	/*
	$nome = $_POST['nome'];
	$operacao = $_POST['operacao'];
	*/

	if($cat->delete_cat($id)){
		$cat->redirect('list_cat.php?pagina=1');
	} else {
		$status = "Categoria não deletada!";	
	}
} 
// EVENTO PARA ADICIONAR MOVIMENTO
*/
if (isset($_POST['btn_addmov'])){

require_once("class/class.lancamentos.php");	

$mov = new MOVS ();

	$tipo = $_POST['tipo'];
	$folha = $_POST['folha'];
	$url = $_POST['url'];
	//$hoje = $_POST['hoje'];
	$cat = $_POST['cat'];
	$descricao = $_POST['descricao'];
	$valor = $_POST['valor'];
	$datamov = $_POST['datamov'];
	$idconta = $_POST['idconta'];
	$idlivro = $_POST['idlivro'];
	
	$t = explode("-", $datamov);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];
	
	//$url = "index.php?mes=" . $mes . "&ano=" . $ano ;
	/*
	require_once('class.cat.php');
	*/
	include 'functions.php';
	$mov = new 	MOVS();
			
		if($mov->new_mov($tipo,$dia,$mes,$ano,$idlivro,$folha,$cat,$descricao,str_replace(",",".",$valor ),invertData($datamov),$idconta)){
			$mov->redirect($url);
		}else{
			$status = "Dados Incorretos !";
		}
}
// EVENTO PARA EDITAR MOVIMENTO
if (isset($_POST['btn_edit_mov'])){

	$id = $_POST['id'];
	$tipo = $_POST['tipo'];
	$folha = $_POST['folha'];
	$url = $_POST['url'];
	$cat = $_POST['cat'];
	$descricao = $_POST['descricao'];
	$valor = $_POST['valor'];
	$datamov = $_POST['hoje'];
	$idconta = $_POST['idconta'];
	$idlivro = $_POST['idlivro'];

	$t = explode("-", $datamov);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];
	//$url = "home.php?mes=" . $mes . "&ano=" . $ano ;
		
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
	
	/*
	require_once('class.cat.php');
	*/
	include 'functions.php';
	
	$mov = new 	MOVS();
		
		if($mov->update_mov($id,$tipo,$dia,$mes,$ano,$idlivro,$folha,$cat,$descricao,str_replace(",",".",$valor ),invertData($datamov),$idconta)){
			$status = "Dados Corretos !";
			echo $status;
			$mov->redirect($url);
		}else{
			$status = "Dados Incorretos !";
			return aviso($status);
		}
}
// EVENTO PARA DELETAR MOVIMENTO
if (isset($_POST['btn_del_mov'])){
	
	$id = $_POST['id'];
	$datamov = $_POST['hoje'];
	$url = $_POST['url'];
	

	$t = explode("-", $datamov);
	$dia = $t[0];
	$mes = $t[1];
	$ano = $t[2];
	$url = "home.php?mes=" . $mes . "&ano=" . $ano ;
	
	if($cat->delete_mov($id)){
		$cat->redirect("home.php?mes=" . $mes . "&ano=" . $ano );
	} else {
		$status = "Movimento não deletado!";
		return aviso($status);
	} 
}
?>