<div class="panel panel-primary">
	<div class="panel-body">
		<footer class="footer" border="1">
			<table class="table table-responsive table-bordered table-striped table-condensed table-hover" >
				
				<tr>
					<td style="text-align: right; " ><strong style="font-size:13px;"> A TRANSPORTAR TOTAIS DO DIA </strong></td>
					<td style="text-align: center; color: #0000FF;"><strong style="font-size:13px;"><?php echo formata_dinheiro($entradas_m); ?></strong></td>
					<td style="text-align: center; color: #C00;"><strong style="font-size:13px;"><?php echo formata_dinheiro($saidas_m) ?></strong></td>
					<td style="text-align: center; "><strong style="font-size:13px; color:<?php if ($saldo_m<0) echo "#C00"; else echo "#0000FF"?>"><?php echo formata_dinheiro($saldo_m) ?></strong></td>
				</tr>
				<tr>
					<td style="text-align: right; " ><strong style="font-size:13px;"> SALDO ANTERIOR </strong></td>
					<td style="text-align: center; "></td>
					<td style="text-align: center; "></td>
					<td style="text-align: center; color: #0000FF;"><strong style="font-size:13px; color:<?php if ($saldoanterior<0) echo "#C00"; else echo "#0000FF"?>"><?php echo formata_dinheiro($saldoanterior) ?></strong></td>
				</tr>
				<tr>
					<td style="text-align: right; " ><strong style="font-size:13px;"> SALDO ATUAL </strong></td>
					<td style="text-align: center; color: #0000FF;"><strong style="font-size:13px;"><?php echo formata_dinheiro($resultado_mes) ?></strong></td>
					<td style="text-align: center; "></td>
					<td style="text-align: center; "></td>
				</tr>
			</table>	
		</footer>
	</div>
</div>