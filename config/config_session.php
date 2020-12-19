<?php
	require_once("config/session.php");
	
	// VARIAVEL DE SESSÃO DO USUARIO
	$auth_user = new USER();
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	
	// VARIAVEL DE SESSÃO DA CONTA
	
	$auth_account = new ACCOUNT();
	
	$account_id = $_SESSION['account_session'];
	
	$stmt = $auth_account->SqlQuery("SELECT * FROM lc_contass WHERE idconta=:idconta");
	$stmt->execute(array(":idconta"=>$account_id));
	
	$accountRow=$stmt->fetch(PDO::FETCH_ASSOC);
	
	$contapd = $accountRow['idconta'];
	$name = $accountRow['proprietario'];
	
	
	$auth_dados = new MOVS();
	//$account_idlivro = $contapd;
	
	$stmt = $auth_dados->Lquery("SELECT MAX(idlivro) as MaxL FROM lc_movimento WHERE idconta=:idconta");
	$stmt->execute(array(":idconta"=>$contapd));
	
	$livroRow=$stmt->fetch(PDO::FETCH_ASSOC);
	
	$livro = $livroRow['MaxL'];
	/*
	$stmt = $auth_dados->Lquery("SELECT idlivro as livro FROM lc_movimento WHERE idconta=:idconta and month(datamov)=:mes_hoje and year(datamov)=:ano_hoje");
	$stmt->execute(array(":idconta"=>$contapd, ':mes_hoje'=> $mes_hoje, ':ano_hoje'=>$ano_hoje));
	
	$livroRow=$stmt->fetch(PDO::FETCH_ASSOC);
	
	$livromes = $livroRow['livro'];
	
	
	$stmt = $auth_dados->Lquery("SELECT MAX(idlivro) FROM lc_movimento WHERE idconta=:idc");
	$stmt->execute(array(":idc"=>$idc));
	
	$livro_row=$stmt->fetch(PDO::FETCH_ASSOC);
	
	$idlivro = $livro_row['idlivro'];
	
	
	*/
	/*
	if(){
		
	//$conta_livro = $contapd;
	
	$stmt = $auth_dados->Lquery("SELECT MAX(livro) FROM lc_movimento WHERE idconta=:contapd");
	$stmt->execute(array(":idconta"=>$contapd));
	
	$livro_conta=$stmt->fetch(PDO::FETCH_ASSOC);
	
	$livroset = $livro_conta['livro'];	
	*/
?>