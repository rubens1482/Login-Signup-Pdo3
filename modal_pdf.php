<!-- Edit -->
    <div class="modal fade" id="modal_pdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Exportar p/ PDF Ref.: <?php echo $mes_hoje ?>/<?php echo $ano_hoje ?> - Conta: <?php echo $contapd ?></h4></center>
                </div>
                <div class="modal-body" >
					<div class="panel panel-primary">
						<div class="panel-body">
							<form class="form-inline" name="form_filtro_cat" method="POST" action="rel_pdf.php">
								
									<div class="panel-body">					
										Męs: <input type="text" name="mes" value="<?php echo $mes_hoje?>" class="form-control input-sm" size="1">
										Ano: <input type="text" name="ano" value="<?php echo $ano_hoje?>" class="form-control input-sm" size="1">
										Conta: <input type="text" name="conta" value="<?php echo $contapd?>" class="form-control input-sm" size="1">
										<button type="submit" class="btn btn-warning btn-sm" name="btn_pdf" ><span class="glyphicon glyphicon-check"></span> Imprimir em PDF </button>
												
									</div>
								
							</form>	
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
<!-- /.modal -->