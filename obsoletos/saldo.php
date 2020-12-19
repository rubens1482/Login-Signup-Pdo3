<?php if ($row['tipo']==1) formata_dinheiro($saldo=$saldo+$row['valor']); else formata_dinheiro($saldo=$saldo-$row['valor']); ?>
							<?php if(isset($_GET["filtrarvarios"])) $acumulado = $saldoanterior + $saldo; else $acumulado = $saldoanterior+$saldo;?>
							<td style="width:100px; text-align: center;">
								<p style="color:<?php if ($acumulado>0) echo "#00f"; else echo"#C00" ?>"><?php echo formata_dinheiro($acumulado);?></p>
							</td>	