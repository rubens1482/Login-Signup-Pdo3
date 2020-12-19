<div class="panel panel-default" >
	<div class="panel-heading"  > 
		BALANCOS DE MOVIMENTO
	</div>
	<div class="panel-body" >
		<div class="row">
			<!--  BALANÇO MENSAL -->
			<div class="col-sm-6" style=" border-top: 1px dashed #f00; border-bottom: 1px dashed #f00;">
				<fieldset class="scheduler-border" >
					<legend style="border-color: #ccc;"> BALANCO MENSAL </legend>
					<!--  SALDO ANTERIOR  BALANÇO MENSAL -->
					<div class="row" >
						<div class="col-sm-6" style="text-align: left;" >
							<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Anterior:</span></strong>
						</div>
						<div class="col-sm-6" style=" text-align: right;">
							<strong><span style="font-size:14px; color:<?php echo "#006400" ?>"><?php print formata_dinheiro($saldo_ant) ?></span></strong>
						</div>
					</div>
					<!--  ENTRADAS BALANÇO MENSAL -->
					<div class="row">
						<div class="col-sm-6" style="text-align: left;">
							<strong><span style="font-size:14px; color:<?php echo "#0000FF" ?>">Entradas:</span></strong>
						</div>
						<div class="col-sm-6" style=" text-align: right;">
							<strong><span style="font-size:14px; color:<?php echo "#0000FF" ?>"><?php print formata_dinheiro($entradas_m) ?></span></strong>
						</div>
					</div>
					<!--  SAIDAS BALANÇO MENSAL -->
					<div class="row">
						<div class="col-sm-6" style=" text-align: left;">
							<strong><span style="font-size:14px; color:<?php echo "#C00" ?>">Saidas:</span></strong>
						</div>
						<div class="col-sm-6" style=" text-align: right;">
							<strong><span style="font-size:14px; color:<?php echo "#C00" ?>"><?php print formata_dinheiro($saidas_m) ?></span></strong>
						</div>
						<hr style="border-top: 1px dotted #8c8b8b; ">
					</div>
					<!--  SALDO ATUAL BALANÇO MENSAL  -->
					<div class="row">
						<div class="col-sm-6" style=" text-align: left;">
							<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Atual:</span></strong>
						</div>
						<div class="col-sm-6" style=" text-align: right;">
							<strong><span style="font-size:14px; color:<?php echo "#006400" ?>"><?php print formata_dinheiro($resultado_mes) ?></span></strong>
						</div>
					</div>
				</fieldset>	
			</div>
			<!-- BALANÇO ANUAL  -->	
			<div class="col-sm-6" style=" border-top: 1px dashed #f00; border-bottom: 1px dashed #f00;">
				<fieldset class="scheduler-border" >
				<legend style="border-color: #ccc;"> BALANCO ANUAL </legend>
					<!--  SALDO ANTERIOR  BALANÇO ANUAL -->
					<div class="row">
						<div class="col-sm-6" style=" text-align: left;">
							<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Anterior:</span></strong>
						</div>
						<div class="col-sm-6" style=" text-align: right;">
							<strong><span style="font-size:14px; color:<?php echo "#006400" ?>"><?php print formata_dinheiro($saldo_aa) ?></span></strong>
						</div>
					</div>
					<!--  ENTRADAS  BALANÇO ANUAL -->
					<div class="row">
						<div class="col-sm-6" style=" text-align: left;">
							<strong><span style="font-size:14px; color:<?php echo "#0000FF" ?>">Entradas:</span></strong>
						</div>
						<div class="col-sm-6" style=" text-align: right;">
							<strong><span style="font-size:14px; color:<?php echo "#0000FF" ?>"><?php print formata_dinheiro($ent_acab) ?></span></strong>
						</div>
					</div>
					<!--  SAIDAS BALANÇO ANUAL -->
					<div class="row">
						<div class="col-sm-6" style=" text-align: left;">
							<strong><span style="font-size:14px; color:<?php echo "#C00" ?>">Saidas:</span></strong>
						</div>
						<div class="col-sm-6" style=" text-align: right;">
							<strong><span style="font-size:14px; color:<?php echo "#C00" ?>"><?php print formata_dinheiro($sai_acab) ?></span></strong>	
						</div>
						<hr style="border-top: 1px dotted #8c8b8b;">
					</div>
					<!--  SALDO ATUAL BALANÇO ANUAL -->
					<div class="row">
						<div class="col-sm-6" style=" text-align: left;">
							<strong><span style="font-size:14px; color:<?php echo "#006400" ?>">Saldo Atual:</span></strong>
						</div>
						<div class="col-sm-6" style=" text-align: right;">
							<strong><span style="font-size:14px; color:<?php echo "#006400" ?>"><?php print formata_dinheiro($saldo_acab) ?></span></strong>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>