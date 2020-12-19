

<!-- Edit -->
    <div class="modal fade" id="edit<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Editar Categoria n&#186; <?php echo $row['id'] ?></h4></center>
                </div>
                <div class="modal-body" >
					<div class="container-fluid" >
						<form method="POST" action="categories.php" >
							<div class="row" >
								<div class="col-lg-2">
									<label style="position:relative; top:7px;">Descrição:</label>
								</div>
								<div class="col-lg-10">
									<input type="hidden" name="id" class="form-control" value="<?php echo $row['id']; ?>">
									<input type="text" name="nome" class="form-control" value="<?php echo $row['nome']; ?>">
								</div>
							</div>
							<div style="height:10px;"></div>
							<div class="row" >
								<div class="col-lg-2" >
									<label style="position:relative; bottom:1px;">Operacao:</label>
								</div>
								<div class="col-lg-10" >
									<label for="operacao<?php echo $row['id']?>" style="color:#030"><input <?php if($row['operacao']=="credito") echo "checked=checked"?> type="radio" name="operacao" value="credito" id="operacao<?php echo $row['id']?>" /> Credito</label>&nbsp; 
									<label for="operacao<?php echo $row['id']?>" style="color:#C00"><input <?php if($row['operacao']=="debito") echo "checked=checked"?> type="radio" name="operacao" value="debito" id="operacao<?php echo $row['id']?>" /> Debito</label>
								</div
							</div>
							<div style="height:10px;"></div>	
					</div> 
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
					<button type="submit" class="btn btn-danger" name="btn_delete"><span class="glyphicon glyphicon-check"></span> Apagar</button>
                    <button type="submit" class="btn btn-warning" name="btn_update_cat"><span class="glyphicon glyphicon-check"></span> Save</button>
                </div>
				</form>
            </div>
        </div>
    </div>
<!-- /.modal -->