<?php
	require_once("config/session.php");
	require_once("class/class.user.php");
	
	include 'functions.php';
	$auth_user = new USER();
	
	$user_id = $_SESSION['user_session'];
	
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	$mail = $userRow['user_email'];
	$name = $userRow['user_name'];
	
	require_once("config/session.php");
	require_once("class/class.account.php");
	
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
	
require_once("class/class.lancamentos.php");
$login = new 	MOVS();
?>
<!-- Bootstrap css -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.min.css">
	<link href="jquery-ui-1.12.1/DataTable/DataTables-1.10.18/dataTables.bootstrap.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="style.css" type="text/css"  />
<!-- Bootstrap -->
	<script src="jquery-ui-1.12.1/DataTable/DataTables-1.10.18/js/dataTables.bootstrap.js"></script>
	<script src="jquery-ui-1.12.1/DataTable/DataTables-1.10.18/js/jquery.bootstrap.js"></script>
	<!-- 	biblioteca jquery para os campos data -->
	
	<script src="jquery-ui-1.12.1/external/jquery/jquery.js"></script>
	<script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
	
	<script language="javascript" src="bootstrap/js/scripts.js"></script>
	<!-- 	fim da biblioteca jquery para os campos data -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	
	<div class="container">
		<h3>Dados do usuario</h3>
		<div class="row">

			<div class="col-sm-8">
				<form action="profile.php" enctype="multipart/form-data" method="post">
					
					<div class="form-group">
					    <label>Nome do Usuario:</label>
					    <input type="text" name="user_name" class="form-control" value="<?php echo $name ?>">
					</div>
					
					<div class="form-group">
					    <label>e-mail:</label>
					    <input type="text" name="user_email" class="form-control" value="<?php echo $mail ?>">
					</div>
					
					<div class="form-group">
					    <label>Ketengan:</label>
					    <textarea type="text" name="ket_gmbr" class="form-control"></textarea>
					</div>

					<div class="form-group">
						<label class="control-label">Gambar</label>
						<input name="gmbr" type="file" class="form-control" accept="image/*" id="recipient-name" required>
					</div>					

					<div class="form-group">
						<button type="reset"  class="btn btn-default">Reset</button>
						<button type="submit" name="krm"  class="btn btn-primary">Simpan</button>
					 </div>

				</form>
			</div>

			<div class="col-sm-4">
			</div>

		</div>
	</div>




