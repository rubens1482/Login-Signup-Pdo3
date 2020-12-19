<div class="container-fluid" style="margin-top:0px; margin-left:120px; margin-right: 120px; padding: 0;">
	<div class="container container-fluid" style="margin-top: 0px; margin-left: 0px; margin-right: 5px; padding: 0; width:100%; ">
	<!-- FORMULARIO DE BUSCA, DATA INICIAL, DATA FINAL E FILTRO DE CATEGORIAS  -->
		<form class="form-inline" name="form_filtro_cat" method="get" action="">
			<div class="panel panel-default">
				<div class="panel-body">	
					<span><strong> filtrar por cod/desc: </strong></span><input type="text" name="filtrar" class="form-control input-sm" style="width:180px;" value="">
					<span><strong><label> Categoria: </label></strong></span>
						<select class="form-control input-sm" name="filtro_cat" style="width: 90px;" onchange="form_filtro_cat.submit()" >
						<option value="">Tudo</option>	
							<?php
							$sql = $db->prepare("SELECT DISTINCT c.id, c.nome FROM lc_cat c, lc_movimento m WHERE m.cat=c.id and m.idconta=:contapd and month(m.datamov)=:mes_hoje and year(m.datamov)=:ano_hoje");
							$sql->bindparam(':contapd', $contapd );
							$sql->bindparam(':mes_hoje', $mes_hoje );
							$sql->bindparam(':ano_hoje', $ano_hoje );
							$sql->execute();
							while ($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
							<option <?php if (isset($_GET['filtro_cat']) && $_GET['filtro_cat']==$row['id'])echo "selected=selected"?> value="<?php echo $row['id']?>"><?php echo $row['nome']?></option>
							<?php } ?>
						</select>
					<input type="hidden" name="data_hoje" value="<?php echo $dia_hoje . "-" . mostraMes($mes_hoje) ."-" . $ano_hoje ?>">
					<button type="submit" name="enviar" class="btn btn-default btn-sm"  value="Filtrar" style="border: solid 1px; border-radius:1px; box-shadow: 1px 1px 1px 1px black; width:80px;" >Filtrar</button>	
				</div>
			</div>
		</form>
	</div>
</div>

<div class="container-fluid" style="margin-top:0px; margin-left: 120px; margin-right: 120px; padding: 0; ">
	<div class="panel panel-default" >
		<!--  CABEÇALHO DA TABELA DE DADOS -->
        <div class="panel-heading"  >
			<div class="row">
				<div class="col-sm-6" >
					<strong>RELATORIO DE CAIXA POR PERIODO E/OU MES</strong>
				</div>
				<div class="col-sm-6" style="text-align: right;">
					<strong>
						<?php if (isset($_GET["filtrarvarios"])){ $saldoanterior = $saldo_di?>
						SALDO ANTERIOR:  
						<?php echo formata_dinheiro($saldoanterior) ?>
						<?php }else{ $saldoanterior = $saldo_ant?>
						SALDO ANTERIOR:  
						<?php echo formata_dinheiro($saldoanterior) ?>
						<?php }?>
					</strong>
				</div>
			</div>
		</div>
		<!--  CORPO DA TABELA DE DADOS -->
		<div class="panel-body" >
			<div class="container-fluid" style="margin-top:0px; margin-left: 0px; margin-right: 0px; padding: 0; ">
				<table class="table table-responsive table-bordered table-striped table-condensed table-hover" >
					<thead>
						<th style="width:8px; text-align: center;">Seq.</th>
						<th style="width:60px; text-align: center;">Id.</th>
						<th style="width:90px; text-align: center;">Data</th>
						<th style="width:350px; text-align: left;">Descricao</th>
						<th style="width:50px; text-align: center;">Categoria</th>
						<th style="width:50px; text-align: center;">Folha</th>
						<th style="width:100px; text-align: center;">Entradas</th>
						<th style="width:100px; text-align: center;">Saidas</th>
						<th style="width:100px; text-align: center;">Saldo</th>
					</thead>					
					<tbody>
					
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
							<td style="width: 8px; text-align: center;"><?php echo $seq; ?></td>
							<td style="width:60px; text-align: center;">
								<a href="#edit<?php echo $row['id']; ?>" data-toggle="modal" name="btn_edit_mov" ><b><i><u><?php echo $row['id']; ?></u></i></b></a>									
							<?php include('edit_mov.php'); ?>
							</td>
							<td style="width:90px; text-align: center;"><?php echo InvertData($row['datamov']); ?></td>
							<td style="width:350px; text-align: left;"><?php echo $row['descricao']; ?></td>
							<td style="width:50px; text-align: left;"><a href="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>&filtro_cat=<?php echo $cat?>"><?php echo $categoria?></a></td>
							<td style="width:50px; text-align: center;"><?php echo $row['folha']; ?></td>
							<td style="width:100px; text-align: center;">
								<p style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><?php if ($row['tipo']==1) echo "+" ; else echo ""?><?php if ($row['tipo']==1) echo formata_dinheiro($row['valor']); else echo "";?></p>
							</td>
							<td style="width:100px; text-align: center;">
								<p style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#030"?>"><?php if ($row['tipo']==0) echo "-"; else echo ""?><?php if ($row['tipo']==0) echo formata_dinheiro($row['valor']); else echo ""?></p>
							</td>
							<?php if ($row['tipo']==1) formata_dinheiro($saldo=$saldo+$row['valor']); else formata_dinheiro($saldo=$saldo-$row['valor']); ?>
							<?php $acumulado = $saldo_ant+$saldo;?>
							<td style="width:100px; text-align: center;">
								<p style="color:<?php if ($acumulado>0) echo "#00f"; else echo"#C00" ?>"><?php echo formata_dinheiro($acumulado);?></p>
							</td>							
						</tr>					
					<?php  }} ?>						
					</tbody>
				</table>
			</div>
		</div>
		<!--  RODAPÉ DA TABELA DE DADOS -->
		<div class="panel-footer" >
			<div class="container-fluid" style="margin-top:0px; margin-left: 0px; margin-right: 0px; padding: 0; ">
				<table class="table table-responsive table-bordered table-striped table-condensed table-hover" >
					<tr>
						<td style="width:180px; text-align: right; " COLSPAN="4"><strong> A TRANSPORTAR TOTAIS DO DIA </strong></td>
						<td style="width:100px; text-align: center; "><?php echo formata_dinheiro($entradas_m); ?></td>
						<td style="width:100px; text-align: center; "><?php echo formata_dinheiro($saidas_m) ?></td>
						<td style="width:100px; text-align: center; "><?php echo $row['valor']; ?></td>
					</tr>
					<tr>
						<td style="width:180px; text-align: right; " COLSPAN="4"><strong> SALDO ANTERIOR </strong></td>
						<td style="width:100px; text-align: center; "></td>
						<td style="width:100px; text-align: center; "></td>
						<td style="width:100px; text-align: center; "><?php echo formata_dinheiro($saldoanterior) ?></td>
					</tr>
					<tr>
						<td style="width:180px; text-align: right; " COLSPAN="4"><strong> SALDO ATUAL </strong></td>
						<td style="width:100px; text-align: center; "><?php echo formata_dinheiro($resultado_mes) ?></td>
						<td style="width:100px; text-align: center; "></td>
						<td style="width:100px; text-align: center; "></td>
					</tr>
				</table>
			</div>
        </div>
	</div>
</div>