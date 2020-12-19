
<div class="panel panel-danger" >
	<!--  CABEÇALHO DA TABELA DE DADOS -->
	<div class="panel-heading"  >
		<div class="row">
			<div class="col-sm-6" >
				<strong>RELATORIO DE CAIXA POR PERIODO E/OU MES</strong>
			</div>
			<div class="col-sm-6" style="text-align: right;">
				<strong>
					<?php if (isset($_GET["filtrarvarios"])){ $saldoanterior = $saldo_di?>
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
		<table  name="tb_home_2" id="tb_home_2" class="table table-responsive table-bordered table-striped table-condensed table-hover" >
			<thead>
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
					<td ><?php echo $seq; ?></td>
					<td style="text-align: center;">
						<a href="#edit<?php echo $row['id']; ?>" data-toggle="modal" name="btn_edit_mov" ><b><i><u><?php echo $row['id']; ?></u></i></b></a>									
					<?php //include('edit_mov.php'); ?>
					</td>
					<td ><?php echo InvertData($row['datamov']); ?></td>
					<td ><?php echo $row['descricao']; ?></td>
					<td ><a href="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>&filtro_cat=<?php echo $cat?>"><?php echo $categoria?></a></td>
					<td ><?php echo $row['folha']; ?></td>
					<td >
						<p style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><?php if ($row['tipo']==1) echo "+" ; else echo ""?><?php if ($row['tipo']==1) echo formata_dinheiro($row['valor']); else echo "";?></p>
					</td>
					<td >
						<p style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#030"?>"><?php if ($row['tipo']==0) echo "-"; else echo ""?><?php if ($row['tipo']==0) echo formata_dinheiro($row['valor']); else echo ""?></p>
					</td>
					<?php if ($row['tipo']==1) formata_dinheiro($saldo=$saldo+$row['valor']); else formata_dinheiro($saldo=$saldo-$row['valor']); ?>
					<?php $acumulado = $saldo_ant+$saldo;?>
					<td >
						<p style="color:<?php if ($acumulado>0) echo "#00f"; else echo"#C00" ?>"><?php echo formata_dinheiro($acumulado);?></p>
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
		<!--  RODAPÉ DA TABELA DE DADOS -->		
</div>