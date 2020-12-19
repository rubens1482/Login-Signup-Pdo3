<?php
	require_once("session.php");
	require_once("class.user.php");
	
	include 'functions.php';
	$auth_user = new USER();
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	
	require_once("session.php");
	require_once("class.account.php");
	
	$auth_account = new ACCOUNT();
	
	$account_id = $_SESSION['account_session'];
	
	$stmt = $auth_account->SqlQuery("SELECT * FROM lc_contass WHERE idconta=:idconta");
	$stmt->execute(array(":idconta"=>$account_id));
	
	$accountRow=$stmt->fetch(PDO::FETCH_ASSOC);
	$contapd = $accountRow['idconta'];
	//
	if (isset($_GET['dia'])) 
    $dia_hoje = $_GET['dia'];
else
    $dia_hoje = date('d');

if (isset($_GET['mes']))
    $mes_hoje = $_GET['mes'];
else
    $mes_hoje = date('m');

if (isset($_GET['ano']))
    $ano_hoje = $_GET['ano'];
else
    $ano_hoje = date('Y');
	//

$pdo = new Database();
$db = $pdo->dbConnection();
$tipo1 = 1;
$tipo0 = 0;

if (isset($_POST['enviar'])){
	$datai = invertData($_POST['datai']);
	$dataf = invertData($_POST['dataf']);
	
	// ENTRADAS ANTES DA DATA INICIAL
	$stmt = $db->prepare("SELECT SUM(valor) as entradas_di FROM lc_movimento WHERE idconta=:contapd and tipo=tipo1 and datamov<:datai");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':tipo1', $tipo1 );
	$stmt->bindparam(':datai', $datai );
	$stmt->execute();
	$qredi=$stmt->fetch(PDO::FETCH_ASSOC);
	$entradas_di=$qredi['entradas_di'];
	echo "entradas:  " . formata_dinheiro($entradas_di);
	echo "<br>";
// SAIDA ANTES DA DATA INICIAL
	$stmt = $db->prepare("SELECT SUM(valor) as saidas_di FROM lc_movimento WHERE idconta=:contapd and tipo=0 and datamov<:datai");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->bindparam(':datai', $datai );
	$stmt->execute();
	$qrsdi=$stmt->fetch(PDO::FETCH_ASSOC);
	$saidas_di=$qrsdi['saidas_di'];
	
	echo "Saidas  " . formata_dinheiro($saidas_di);
	echo "<br>";
	echo "Salda  " . formata_dinheiro($entradas_di-$saidas_di);
}else{
	echo "data não enviada";
}

	
?>
<html>
<form method="post" action="#">
conta:<input type="text" name="conta" value="<?php echo $contapd ?>">
<br>
data inicial:<input type="text" name="datai" value="<?php echo $datai ?>">
<br>
<input type="text" name="dataf">
<input type="submit" name="enviar" value="enviar">
<?php echo $contapd; ?>
</form>
</html>