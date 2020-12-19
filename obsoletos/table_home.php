
	<div class="panel panel-primary" >
		<!--  CABEÇALHO DA TABELA DE DADOS -->
		<div class="panel-heading"  >
			<div class="row">
				<div class="col-sm-6" >
					<strong>RELATORIO DE CAIXA <?php if (isset($_GET['data_i'])){ ?>Data Inicial:  <?php echo invertData($data_i) ?><?php }else{ ?> :  <?php echo $mes_hoje ?>/<?php echo $ano_hoje ?><?php }?></strong>
				</div>
				<div class="col-sm-6" style="text-align: right;">
					<strong>
						<?php if (isset($_GET['filtrar_data'])){ $saldoanterior = $saldo_dti?>
							SALDO ANTERIOR:  <?php echo formata_dinheiro($saldoanterior) ?>
						<?php }else{ $saldoanterior = $saldo_ant?>
							SALDO ANTERIOR:  <?php echo formata_dinheiro($saldoanterior) ?>
						<?php }?>
					</strong>
				</div>
			</div>
		</div>
		<!--  CORPO DA TABELA DE DADOS -->
		<div class="panel-body" >
			<?php 
				$pdo = new Database();
				$db = $pdo->dbConnection();
				//$stmt = $db->prepare("SELECT * FROM lc_movimento WHERE idconta='$contapd' and mes='$mes_hoje' and ano='$ano_hoje'");
				//$stmt = $db->prepare("SELECT * FROM lc_movimento WHERE month(datamov)='$mes_hoje' and year(datamov)='$ano_hoje' and idconta='$contapd'");
				$stmt = $db->prepare("SELECT * FROM lc_movimento WHERE idconta=:contapd and month(datamov)=:mes_hoje and year(datamov)=:ano_hoje ORDER BY datamov ASC");
				$stmt->bindparam(':contapd', $contapd );
				$stmt->bindparam(':mes_hoje', $mes_hoje );
				$stmt->bindparam(':ano_hoje', $ano_hoje );
				$stmt->execute();
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
				$cont=0;
				$seq=0;
				$saldo=0;
			?>
			<table id="tb_home" class="table table-responsive table-bordered table-striped table-condensed table-hover" id="datadados">
				<thead>
					<tr >
						<th >Seq.</th>
						<th >Id.</th>
						<th >Data</th>
						<th >Descricao</th>
						<th >Categoria</th>
						<th >Folha</th>
						<th >Entradas</th>
						<th >Saidas</th>
						<th >Saldo</th>
					</tr>
				</thead>					
				<tbody>
				<?php
					if ($stmt->rowCount() > 0) { 
						foreach ($result as $row) {
						$cont++;
						$seq++;
						
						$cat = $row['cat'];
						$stmt = $db->prepare("SELECT * FROM lc_cat WHERE id='$cat'");
						$stmt->execute();
						$qr2=$stmt->fetch(PDO::FETCH_ASSOC);
						$categoria = $qr2['nome'];	
				?>
					<tr >
						<td style="text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $seq; ?></strong></td>
						<td style="text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>">
							<a style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>;" href="#edit<?php echo $row['id']; ?>" data-toggle="modal" name="btn_edit_mov" ><strong style="font-size:12px;"><b><i><u><?php echo $row['id']; ?></u></i></b></a>									
						<?php include('operations/edit_mov.php'); ?>
						</td>
						<td style="text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo InvertData($row['datamov']); ?></strong></td>
						<td style="text-align: left; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $row['descricao']; ?></strong></td>
						<td style="text-align: left; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><a style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>;" href="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>&filtro_cat=<?php echo $cat?>"><?php echo $categoria?></strong></a></td>
						<td style="text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $row['folha']; ?></strong></td>
						<td style="text-align: center;">
							<p style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><?php if ($row['tipo']==1) echo "+" ; else echo ""?><strong style="font-size:12px;"><?php if ($row['tipo']==1) echo formata_dinheiro($row['valor']); else echo "";?></strong></p>
						</td>
						<td style="text-align: center;">
							<p style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#030"?>"><?php if ($row['tipo']==0) echo "-"; else echo ""?><strong style="font-size:12px;"><?php if ($row['tipo']==0) echo formata_dinheiro($row['valor']); else echo ""?></strong></p>
						</td>
						<?php if ($row['tipo']==1) formata_dinheiro($saldo=$saldo+$row['valor']); else formata_dinheiro($saldo=$saldo-$row['valor']); ?>
						<?php $acumulado = $saldo_ant+$saldo;?>
						<td style="text-align: center;">
							<p style="color:<?php if ($acumulado>0) echo "#00f"; else echo"#C00" ?>"><strong style="font-size:12px;"><?php echo formata_dinheiro($acumulado);?></strong></p>
						</td>							
					</tr>					
				<?php  }} ?>						
				</tbody>
				<tfoot>
					<tr>
						<th >Seq.</th>
						<th >Id.</th>
						<th >Data</th>
						<th >Descricao</th>
						<th >Categoria</th>
						<th >Folha</th>
						<th >Entradas</th>
						<th >Saidas</th>
						<th >Saldo</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>