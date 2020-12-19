<?php
//$pdo = new Database();
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
<?php

$Saldos = new LANCAMENTOS();

$ano = $ano_hoje;
$mes = $mes_hoje;
$idconta = $account_id;
$tipo_e = 1;
$tipo_s = 0;

if($Saldos->entradas_aa($ano,$idconta,$tipo_e) > 0 )
{
	echo  $entradas_aa ;

}

if($Saldos->saidas_aa($ano,$idconta,$tipo_s))
{
	echo "Saidas Ano Anterior: " . $saidas_aa;
}
?>
large medium and small form input
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet"
  href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
<link rel="stylesheet"
  href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
<script type="text/javascript"
  src="http://code.jquery.com/jquery.min.js"></script>
<script
  src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<style type="text/css">
.bs-example {<!--from  w  ww . j  a  v a 2s  . c  o m-->
  margin: 20px;
}
</style>
</head>
<body>
  <div class="bs-example">
    <form>
      <div class="row">
        <div class="col-xs-6">
          <input type="text" class="form-control input-lg"
            placeholder="Larger input">
        </div>
        <div class="col-xs-6">
          <select class="form-control input-lg">
            <option>Larger select</option>
          </select>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-xs-6">
          <input type="text" class="form-control" placeholder="Default input">
        </div>
        <div class="col-xs-6">
          <select class="form-control">
            <option>Default select</option>
          </select>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-xs-6">
          <input type="text" class="form-control input-sm"
            placeholder="Smaller input">
        </div>
        <div class="col-xs-6">
          <select class="form-control input-sm">
            <option>Smaller select</option>
          </select>
        </div>
      </div>
    </form>
  </div>
</body>
</html>
