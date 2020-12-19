<?php
$pdo = new Database();
$db = $pdo->dbConnection();
	// SOMA ENTRADAS ANO ANTERIOR
$stmt = $db->prepare("SELECT sum(valor) as saidas_aa FROM lc_movimento WHERE idconta='$contapd' && tipo=0 && year(datamov)<'$ano_hoje'");
$stmt->execute();
$linha=$stmt->fetch(PDO::FETCH_ASSOC);
	print "Saidas Ano Anterior: " . formata_dinheiro($linha['saidas_aa']);
$saidas_aa = $linha['saidas_aa'];
print "Saidas Ano Anterior: " . formata_dinheiro($saidas_aa);
print "<br>";
	// SOMA SAIDAS ANO ANTERIOR
$stmt = $db->prepare("SELECT sum(valor) as entradas_aa FROM lc_movimento WHERE idconta='$contapd' && tipo=1 && year(datamov)<'$ano_hoje'");
$stmt->execute();
$linha=$stmt->fetch(PDO::FETCH_ASSOC);
	print "Saidas Ano Anterior: " . formata_dinheiro($linha['saidas_aa']);
$entradas_aa = $linha['entradas_aa'];
print "Entradas Ano Anterior: " . formata_dinheiro($entradas_aa);
print "<br>----------------------------------------------------";
$saldo_aa = $entradas_aa-$saidas_aa;
print "<br>" . formata_dinheiro($saldo_aa);


$stmt = $db->prepare("SELECT SUM(valor) as entradas_m FROM lc_movimento WHERE idconta=$contapd && tipo=1 && mes='$mes_hoje' && ano='$ano_hoje'");
$stmt->execute();
$linha=$stmt->fetch(PDO::FETCH_ASSOC);
	print "Saidas Ano Anterior: " . formata_dinheiro($linha['saidas_aa']);
$entradas_m = $linha['entradas_m'];
print "<br>Entradas". $mes_hoje ."/". $ano_hoje . ":"  . formata_dinheiro($entradas_m);

$stmt = $db->prepare("SELECT SUM(valor) as saidas_m FROM lc_movimento WHERE idconta=$contapd && tipo=0 && mes='$mes_hoje' && ano='$ano_hoje'");
$stmt->execute();
$linha=$stmt->fetch(PDO::FETCH_ASSOC);
	print "Saidas Ano Anterior: " . formata_dinheiro($linha['saidas_aa']);
$saidas_m = $linha['saidas_m'];
print "<br>Saidas" . $mes_hoje ."/". $ano_hoje . ":" .  formata_dinheiro($saidas_m);

//require_once("class.lancamentos.php");
?>