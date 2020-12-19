<?php 
require_once("config/session.php");
	require_once("class/class.user.php");
	include "config/config_session.php";
	include "parameters.php";
	$contapd = $accountRow['idconta'];
	$pdo = new Database();
	$db = $pdo->dbConnection();
	//$stmt = $db->prepare("SELECT * FROM lc_movimento WHERE idconta='$contapd' and mes='$mes_hoje' and ano='$ano_hoje'");
	// SELECT lc_conferencia.Idconta, lc_conferencia.id_nota, lc_conferencia.quant, lc_conferencia.tipo, lc_notas.nvalor, lc_notas.desc_nota, lc_conferencia.quant*lc_notas.nvalor as saldo FROM lc_conferencia INNER JOIN lc_notas on lc_conferencia.id_nota=lc_notas.id_nota WHERE Idconta=9 and tipo=1;
	//$stmt = $db->prepare("SELECT * FROM lc_movimento WHERE month(datamov)='$mes_hoje' and year(datamov)='$ano_hoje' and idconta='$contapd'");
	// SELECT lc_conferencia.Idconta, lc_conferencia.id_nota, lc_conferencia.quant, lc_conferencia.tipo, lc_notas.nvalor, lc_conferencia.quant*lc_notas.nvalor as saldo FROM lc_conferencia INNER JOIN lc_notas on lc_conferencia.id_nota=lc_notas.id_nota WHERE Idconta=9 and tipo=1;
	// SELECT * FROM lc_movimento WHERE idconta=:contapd and month(datamov)=:mes_hoje and year(datamov)=:ano_hoje ORDER BY datamov ASC
	// SELECT lc_notas.id_nota, lc_notas.nvalor, lc_conferencia.Idconta, lc_conferencia.Idconta, lc_conferencia.id_nota, lc_conferencia.quant FROM lc_notas INNER JOIN lc_conferencia ON lc_notas.id_nota=lc_conferencia.id_nota;
	$stmt = $db->prepare("SELECT * FROM lc_notas as c INNER JOIN lc_conferencia as m ON (c.id_nota=m.id_nota) WHERE idconta=:contapd and tipo=1");
	$stmt->bindparam(':contapd', $contapd );
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
		

 if ($stmt->rowCount() > 0) { 
	foreach ($result as $row) {	
echo $row['id_nota'];

			
				?>
				<?php  }} ?>