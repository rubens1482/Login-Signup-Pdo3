
<!-- Add New -->
<html>
<head>
	<link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.min.css">
	<script src="jquery-ui-1.12.1/external/jquery/jquery.js"></script>
	<script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script>
	  $( function() {
		  $( "#datamov, #datamov, #datapicker, #data_i, #data_f" ).datepicker({
			altField: "#actualDate",
			dateFormat: "dd-mm-yy",
			altFormat: "dd-mm-YY",
			showWeek: true,	
			changeMonth: true,
		changeYear: true
		});
		$( ".selector" ).datepicker({
		altFormat: "dd-mm-yy",
		altField: "#actualDate"
		});
	  } );
	</script>
</head>
</html>

    <div class="modal fade" id="addmovs" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog " style="margin: auto;">
            <div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<center><h4 class="modal-title" id="myModalLabel"> Adicionar Movimento de Caixa </h4></center>
					</div>
                <div class="modal-body" >
				<div id="error">
					<?php
						if(isset($status))
						{
							?>
							<div class="alert alert-danger">
							   <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $status; ?> !
							</div>
							<?php
						}
					?>
				</div>
					<div class="container-fluid">
								<!-- FORM ADICIONAR MOVIMENTOS -->
						<form method="post" action="addnew.php" >
							<div class="row">
							
								
									<div class="form-group">
										
											<label for="tipo" class="control-label ">Tipo</label>
										
										<!-- TIPO -->
										
											
											<select name="tipo" id="tipo" class="form-control input-sm" type="number">
											  <option value="0">debito</option>
											  <option value="1">credito</option>
											</select>
										
									</div>	
																
									<div class="form-group">
									<td >
										<label for="text" class="control-label">folha</label>
									
									<!-- FOLHA -->
									
										<input type="text" class="form-control"  name="folha" placeholder="folha">
									
									</div>									
																	
										<div class="form-group">
										<td >
											<label for="cat" class="control-label ">Cat.</label>
										
										<?php
											$pdo = new Database();
											$db = $pdo->dbConnection();
											$stmt = $db->prepare("SELECT id, nome, operacao FROM lc_cat ");
											$stmt->execute();
											$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
											if ($stmt->rowCount() > 0) { 
										?>											
										
										<!-- CATEGORIA -->
											<select name="cat"  class="form-control input-sm" type="text">
												<?php foreach ($result as $row) { ?>
											  <option value="<?php echo $row['id']; ?>"><?php echo $row['nome']; ?></option>
												<?php } ?>
											</select>
												<?php } ?>
										
										</div>								
																
										<div class="form-group">
										<td >
											<label for="text" class="control-label">Descricao</label>
										
										<!-- DESCRICAO -->
											
											<input type="text" name="descricao" class="form-control" style="width: 450px;">
											
										</div>
								
										<div class="form-group">
										<td >
											<label for="text" class="control-label"> Valor </label>
										
										<!-- VALOR -->
										
											<span class="glyphicon glyphicon-user"></span>
											<input type="text" name="valor" class="form-control" >
											
											
										</div>
								
									
										<div class="form-group">
										<td >
											<label for="valor" class="control-label "> Data </label>
										
										<!-- DATAMOV -->
										
											<input type="text" class="form-control" name="datamov"  id="datamov" value="" >
											 
										</div>
									
															

										<div class="form-group">
										<td >
											<label for="text" class="control-label">Conta</label>
										
										<?php
										$pdo = new Database();
										$db = $pdo->dbConnection();
										$stmt = $db->prepare("SELECT idconta, conta FROM lc_contass ");
										$stmt->execute();
										$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
											if ($stmt->rowCount() > 0) { 
										?>
										
										<!-- CONTA -->
											<select name="idconta" id="idconta" class="form-control input-sm" type="text">
											<?php foreach ($result as $row) { ?>
												<option value="<?php echo $row['idconta']; ?>"><?php echo $row['conta']; ?></option>
												<?php } ?>
											</select>
												<?php } ?>
											
										</div>	
								</tr>
							</table>
							</div>
					</div>
				</div> 
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
				<button type="submit" class="btn btn-default" data-dismiss="modal" name="btn-addmov"><span class="glyphicon glyphicon-remove"></span> Save </button>
				
			</div>	
	
		</div>
		</form>		
	</div>      
	
