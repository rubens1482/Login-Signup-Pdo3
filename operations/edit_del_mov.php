

<!-- Edit -->
    <div class="modal fade" id="edit<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Editar Registro n&#186; <?php echo $row['id'] ?></h4></center>
                </div>
                <div class="modal-body" >
					<div class="container-fluid" >
						<form method="POST" action="addnew.php" >
							<div class="row">
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;">Tipo:</label>
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
									<input type="text" class="form-control" name="folha" value="<?php echo $row['folha'] ?>">
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
										$stmt = $db->prepare("SELECT id, nome, operacao FROM lc_cat ");
										$stmt->execute();
										$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
										if ($stmt->rowCount() > 0) { 
									?>		
									<select name="cat"  type="text" class="form-control input-sm" >
										<?php foreach ($result as $row) { ?>
									  <option value="<?php echo $row['id']; ?>"><?php echo $row['nome']; ?></option>
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
									<input type="text" class="form-control" name="descricao">
								</div>
							</div>
							<div style="height:10px;"></div>
							<div class="row">
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;">Valor:</label>
								</div>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="valor" value="">
								</div>
							</div>
							<div style="height:10px;"></div>
							<div class="row">
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;">Data:</label>
								</div>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="datamov" id="datamov">
								</div>
							</div>
							<div style="height:10px;"></div>
							<div class="row">
								<div class="col-lg-2">
									<label class="control-label" style="position:relative; top:7px;">Conta:</label>
								</div>
								<div class="col-lg-10">
								<?php
									$pdo = new Database();
									$db = $pdo->dbConnection();
									$stmt = $db->prepare("SELECT idconta, conta FROM lc_contass ");
									$stmt->execute();
									$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
									if ($stmt->rowCount() > 0) { 
								?>	
									<select name="idconta"  class="form-control input-sm" type="text">
											<?php foreach ($result as $row) { ?>
										<option value="<?php echo $row['idconta']; ?>"><?php echo $row['conta']; ?></option>
											<?php } ?>		
									</select>		
								</div>
								<?php } ?>	
							</div>
						</form>
					</div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
					<button type="submit" class="btn btn-danger" name="btn_del_mov"><span class="glyphicon glyphicon-check"></span> Apagar</button>
                    <button type="submit" class="btn btn-warning" name="btn_update_mov"><span class="glyphicon glyphicon-check"></span> Save</button>
                </div>
				</form>
            </div>
        </div>
    </div>
<!-- /.modal -->