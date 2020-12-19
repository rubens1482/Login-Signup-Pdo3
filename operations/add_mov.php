<?php
/*
require_once("config/session.php");
$account_id = $_SESSION['account_session'];
	
$stmt = $auth_account->SqlQuery("SELECT * FROM lc_contass WHERE idconta=:idconta");
$stmt->execute(array(":idconta"=>$account_id));

$accountRow=$stmt->fetch(PDO::FETCH_ASSOC);
$contapd = $accountRow['idconta'];
*/
	function selected( $value, $selected ){
		return $value==$selected ? ' selected="selected"' : '';
	}
?>
<link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.min.css">
<script src="jquery-ui-1.12.1/external/jquery/jquery.js"></script>
<script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>


	<script language="Javascript">
		function BuscaSelect(campo) {
				campo=campo.value;
				campo=campo.toLowerCase();
				tamanho=addmov.cat.length;

		   for (i=0;i<tamanho;i++) {
			  aux=eval("addmov.combo.options["+i+"].text").toLowerCase();

			  if (aux.indexOf(campo)==0) {
				 addmov.combo.selectedIndex=i;
				 i=tamanho; 
				} 
		   } 
		}
	</script>

	
<!-- Add New -->
    <div class="modal fade" id="addmov" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel"> Inserir Movimento </h4></center>
				</div>
				<div class="modal-body">
				
					<div class="container-fluid" style="border: 3px;">
						<form class="form-inline" method="POST" action="movements.php" name="addmov" onsubmit="return valida_dados(this)">
							<div class="row">
								<div class="col-lg-2" >
									<label class="control-label" style="position:relative; top:7px; text-align: right;">Tipo:</label>
								</div>
								<div class="col-lg-10">
									<select name="tipo"  id="tipo" type="number" class="form-control input-sm">
									  <option value="0">saida</option>
									  <option value="1">entrada</option>
									</select>
								</div>
							</div>
							<div style="height:10px;"></div>						
							<div class="row">
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;">Folha:</label>
								</div>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="folha" id="folha">
									<input type="text" class="form-control" name="url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
								</div>
							</div>
							<div style="height:10px;"></div>
							<div class="row">
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;">Categoria:</label>
								</div>
								<div class="col-lg-10">
									<?php
										$pdo = new Database();
										$db = $pdo->dbConnection();
										$stmt = $db->prepare("SELECT id, nome, operacao FROM lc_cat ORDER BY nome");
										$stmt->execute();
										$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
										if ($stmt->rowCount() > 0) { 	
									?>								
									<select name="cat"  type="text" class="form-control input-sm" >
										<?php foreach ($result as $row) { ?>
										
									  <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?> - <?php echo $row['nome']; ?></option>
										<?php } ?>
									</select>
										<?php } ?>									
								</div>
							</div>
							<div style="height:10px;"></div>
							<div class="row">
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;">Descricao:</label>
								</div>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="descricao" id="descricao">
								</div>
							</div>
							<div style="height:10px;"></div>
							<div class="row">
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;">Valor:</label>
								</div>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="valor" id="valor">
								</div>
							</div>
							<div style="height:10px;"></div>
							<div class="row">
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;">Data:</label>
								</div>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="datamov" id="datamov" value="<?php echo $dia_hoje;?>-<?php echo $mes_hoje;?>-<?php echo $ano_hoje;?>">
								</div>
							</div>
							<div style="height:10px;"></div>
							<div class="row">
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;">Conta:</label>
								</div>
								<div class="col-lg-3">
									<?php
										$pdo = new Database();
										$db = $pdo->dbConnection();
										$stmt = $db->prepare("SELECT idconta, conta FROM lc_contass ");
										$stmt->execute();
										$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
										if ($stmt->rowCount() > 0) { 
									?>	
									<select name="idconta"  class="form-control input-sm" type="text">
											<?php foreach ($result as $row) : ?>
										<option <?php if($accountRow['idconta']==$row['idconta']) echo "selected"?> value="<?php echo $row['idconta']; ?>"><?php echo $row['idconta']; ?> - <?php echo $row['conta']; ?></option>
											<?php endforeach ?>		
									</select>		
								</div>
								<?php } ?>
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;">Livro:</label>
								</div>
								<div class="col-lg-3">	
									<input type="number" class="form-control" name="idlivro"  value="<?php echo $livro ?>" id="livro" size="1">
								</div>
							</div>
					</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
							<button type="submit" name="btn_addmov" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
						</div>
						</form>
				</div>	
			</div>		
		</div>
	</div>
