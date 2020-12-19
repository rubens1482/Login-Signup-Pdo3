<link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.min.css">
<script src="jquery-ui-1.12.1/external/jquery/jquery.js"></script>
<script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script>
  $( function() {
	  $( "#datamov, #datam, #hoje, #data_i, #data_f" ).datepicker({
		altField: "#actualDate",
		dateFormat: "dd-mm-yy",
		altFormat: "dd-mm-YY",
		changeMonth: true,
		changeYear: true,
	});
	$( ".selector" ).datepicker({
	altFormat: "dd-mm-yy",
	altField: "#actualDate"
	});
  } );
</script>

<!-- Edit -->

    <div class="modal fade" id="edit<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Editar registro n&deg; <?php echo $row['id']; ?></h4></center>
                </div>
                <div class="modal-body">
				
					<div class="container-fluid">
						<form method="POST" action="movements.php">
							<!-- id -->
							<div class="row">
								<div class="col-lg-2">
									<label style="position:relative; top:7px;">Cod:</label>
								</div>
								<div class="col-lg-10">
									<input type="text" name="id" class="form-control" value="<?php echo $row ['id']; ?>" >
								</div>
							</div>
							<div style="height:10px;"></div>
							<!-- Tipo -->
							<div class="row">
								<div class="col-lg-2">
									<label style="position:relative; top:7px;">Tipo:</label>
								</div>
								<div class="col-lg-10">
									<label for="tipo<?php echo $row['tipo']?>" style="color:#030;"><input <?php if($row['tipo']=="1") echo "checked=checked"?> type="checkbox" name="tipo" style="text-align: left;" value="1" id="tipo<?php echo $row['tipo']?>" /> Entradas </label>&nbsp; 
									<label for="tipo<?php echo $row['tipo']?>" style="color:#C00;"><input <?php if($row['tipo']=="0") echo "checked=checked"?> type="checkbox" name="tipo" style="text-align: left;" value="0" id="tipo<?php echo $row['tipo']?>" /> Saidas </label>
								</div>
							</div>
							<div style="height:10px;"></div>
							<!-- Folha -->
							<div class="row">
								<div class="col-lg-2">
									<label style="position:relative; top:7px;">Folha:</label>
								</div>
								<div class="col-lg-10">
									<input type="number" name="folha" class="form-control" value="<?php echo $row ['folha']; ?>">
								</div>
							</div>
							<div style="height:10px;"></div>
							<div class="row">
								
								<div class="col-lg-10">
									<input type="hidden" class="form-control" name="url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
								</div>
							</div>
							<div style="height:10px;"></div>
							<!-- Categoria -->
							<div class="row">
								<div class="col-lg-2">
									<label style="position:relative; top:7px;">Categoria</label>
								</div>
								<div class="col-lg-10">
									<?php 
									$cat = $row['cat']; 
									?>
									<?php
										$pdo = new Database();
										$db = $pdo->dbConnection();
										$stmt = $db->prepare("SELECT * FROM lc_cat ORDER BY nome");
										$stmt->execute();
										$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
										
									?>
									<select name="cat" style="width:250px;" type="text" class="form-control input-sm" >
										<?php foreach ($result as $linha){ ?>
										<option  <?php if($row['cat']==$linha['id']) echo "selected"?> value="<?php echo $linha['id'] ?>"><?php echo $linha['nome'] ?>-<?php echo $linha['id'] ?> - </option>
										<?php } ?>		
									</select>	
								</div>	
							</div>
							<div style="height:10px;"></div>
							<!-- Descrição -->
							<div class="row">
								<div class="col-lg-2">
									<label style="position:relative; top:7px;">Descricao:</label>
								</div>
								<div class="col-lg-10">
									<input type="text" name="descricao" class="form-control" value="<?php echo $row['descricao']; ?>">
								</div>
							</div>
							<div style="height:10px;"></div>
							<!-- Valor -->
							<div class="row">
								<div class="col-lg-2">
									<label style="position:relative; top:7px;">Valor:</label>
								</div>
								<div class="col-lg-10">
									<input type="text" name="valor" class="form-control" value="<?php echo $row['valor']; ?>">
								</div>
							</div>
							<div style="height:10px;"></div>
							<!-- Data movimento -->
							<div class="row">
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;"> Data </label>
								</div>
								<div class="col-lg-10">	
									<input type="text" class="form-control" name="hoje" id="hoje" value="<?php echo invertData($row['datamov']);?>">
								</div>
							</div>
							<div style="height:10px;"></div>
							<div class="row">
								<div class="col-lg-2">
									<label style="position:relative; top:7px;">Conta</label>
								</div>
								<div class="col-lg-10">
								
								<?php
								$pdo = new Database();
								$db = $pdo->dbConnection();
								$stmt = $db->prepare("SELECT * FROM lc_contass");
								$stmt->execute();
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
								?>	
									<select name="idconta"  type="text" class="form-control input-sm" >
									<?php foreach ($result as $rows){ ?>				
									<option <?php if($rows['idconta']==$row['idconta']) echo "selected"?> value="<?php echo $rows['idconta'] ?>"><?php echo $rows['idconta'] ?> - <?php echo $rows['proprietario'] ?></option>
									<?php } ?>			
									</select>	
								</div>	
							</div>	
							<!-- livro -->
							<div style="height:10px;"></div>
							<div class="row">
								<div class="col-lg-2">
									<label style="position:relative; top:7px;">Livro</label>
								</div>
								<div class="col-lg-10">	
									<input type="number" class="form-control" name="idlivro"  value="<?php echo $livro ?>" id="livro" size="1">
								</div>
							</div>	
							
					</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
							<button type="submit" class="btn btn-danger" name="btn_del_mov"><span class="glyphicon glyphicon-check"></span> Apagar</button>
							<button type="submit" class="btn btn-warning" name="btn_edit_mov"><span class="glyphicon glyphicon-check"></span> Save</button>
						</div>
						</form>
				</div>
			</div>
		</div>
	</div>
<!-- /.modal -->