<?php
// cria uma nova instancia
// $dados = new MOVS();
// cria uma variavel com os dados retornados
// $resultado = $dados->dados_saldo($contapd, $mes, $ano);
	require_once('config/dbconfig.php');
	require_once("class/class.lancamentos.php");
	include "functions.php";
	$contapd = 1;
	$busca = '%%';
	?>
<form action="" name="meu">
<input type="text" name="mes" value="mes">
<input type="text" name="ano" value="ano">
<input type="text" name="data_i" value="data_i">
<input type="text" name="data_f" value="data_f">
<input type="text" name="livro" value="livro">	
<input type="text" name="folha" value="folha">
<input type="submit" name="enviar" value="enviar">
</form>
	
	<br>
	BALANÇO POR FOLHA E LIVRO
	<table border="1">
		<?php
			$livro=1;
			$folha_i=1;
			$folha_f=1;
			$mostrar = new MOVS;
			$dados = $mostrar->bal_porfolha($contapd, $livro, $folha_i, $folha_f );
		?>
		<tr>
			<td colspan="15">BALANÇO POR FOLHA E LIVRO</td>
		</tr>	
		<tr>
			<th>Idconta</th>
			<th>IdLivro</th>
			<th>Folha</th>
			<th>Saldo_f_a</th>
			<th>Credito_f</th>
			<th>Debitos_f</th>
			<th>Saldo_Atual_f</th>
			<th>Bal_f</th>
			<th>Saldo_la</th>
			<th>Credito_Acum</th>
			<th>Cred_la</th>
			<th>Deb_Acum</th>
			<th>Debito_la</th>
			<th>Bal_cre</th>
			<th>Bal_Acum</th>
			
			
		</tr>
		<?php foreach($dados as $linha){ ?>
		<tr>
		

			<td><?php echo $linha['idconta']; ?> </td>
			<td><?php echo $linha['idlivro']; ?> </td>
			<td><?php echo $linha['folha']; ?> </td>
			<td><?php echo formata_dinheiro($linha['saldo_folha_ant']); ?> </td>
			<td><?php echo formata_dinheiro($linha['credito_f']); ?> </td>
			<td><?php echo formata_dinheiro($linha['debito_f']); ?> </td>
			<td><?php echo formata_dinheiro($linha['saldo_atual_f']); ?> </td>
			<td><?php echo formata_dinheiro($linha['credito_acum']); ?> </td>
			<td><?php echo formata_dinheiro($linha['debito_acum']); ?> </td>
			<td><?php echo formata_dinheiro($linha['bal_cre']); ?> </td>		
			<?php
		 } 
		$dados = null;
		?>
		</tr>
		<?php 
		?>
	</table>	
	<br>
	REGISTROS POR FOLHA, LIVRO E CAMPO DE BUSCA
	<table border="1">
		<?php
		$livro=1;
		$busca = '%%';
		$folha_i=1;
		$folha_f=1;
		$mostrares = new MOVS;
		$dados = $mostrares->dados_porfolha($contapd, $busca, $livro, $folha_i, $folha_f );
		?>
			<tr>
				<td colspan="11">REGISTROS POR FOLHA, LIVRO E CAMPO DE BUSCA</td>
			</tr>	
			<tr>
				<th>Conta</th>
				<th>id</th>
				<th>data</th>
				<th>Descricao</th>
				<th>Cat</th>
				<th>Livro</th>
				<th>Folha</th>
				<th>Saldo Anterior</th>
				<th>Creditos</th>
				<th>Debito</th>
				<th>Saldo Atual</th>
			</tr>
			<tr>
			<?php foreach($dados as $linha){ ?>
				
				<td><?php echo $linha['id']; ?> </td>
				<td><?php echo invertdata($linha['datamov']); ?> </td>
				<td><?php echo $linha['descricao']; ?> </td>
				<td><?php echo $linha['idlivro']; ?> </td>
				<td><?php echo $linha['folha']; ?> </td>
				<td><?php echo formata_dinheiro($linha['saldo_anterior']); ?> </td>
				<td><?php echo formata_dinheiro($linha['credito']); ?> </td>
				<td><?php echo formata_dinheiro($linha['debito']); ?> </td>
				<td><?php echo formata_dinheiro($linha['saldo_atual']); ?> </td>
				
				
				
			</tr>
			<?php } 
			$dados = null;
			?>
		</table>
	BALANÇO POR MES E ANO
	<table border="1">
		<?php
			$livro=1;
			$mes_hoje = 12;
			$ano_hoje = 2015;
			$mostrar = new MOVS;
	$dados = $mostrar->bal_pormes($contapd,$mes_hoje, $ano_hoje);
	
	foreach($dados as $linha){
	$saldo_aa = $linha['saldo_ano_ant'];
	$saldo_ant = $linha['saldo_anterior_mes'];
	$entradas_m = $linha['credito_mes'];
	$saidas_m = $linha['debito_mes'];
	$resultado_mes = $linha['saldo_atual_mes'];
	$ent_acab = $linha['credito_acum_ano'];
	$sai_acab = $linha['debito_acum_ano'];
	$saldo_acab = $linha['saldo_acum_ano'];
	//$saldo_acab = $saldo_aa + $ent_acab - $sai_acab;
	}
		?>
		<tr>
			<td colspan="15">BALANÇO POR MES E ANO</td>
		</tr>	
		<tr>
			<th>Idconta</th>
			<th>IdLivro</th>
			<th>Folha</th>
			<th>Saldo_f_a</th>
			<th>Credito_f</th>
			<th>Debitos_f</th>
			<th>Saldo_Atual_f</th>
			<th>Bal_f</th>
			<th>Saldo_la</th>
			<th>Credito_Acum</th>
			<th>Cred_la</th>
			<th>Deb_Acum</th>
			<th>Debito_la</th>
			<th>Bal_cre</th>
			<th>Bal_Acum</th>
			
			
		</tr>
		<?php
			foreach($dados as $linha){
			$saldo_aa = $linha['saldo_ano_ant'];
			$saldo_ant = $linha['saldo_anterior_mes'];
			$entradas_m = $linha['credito_mes'];
			$saidas_m = $linha['debito_mes'];
			$resultado_mes = $linha['saldo_atual_mes'];
			$ent_acab = $linha['credito_acum_ano'];
			$sai_acab = $linha['debito_acum_ano'];
			$saldo_acab = $linha['saldo_acum_ano'];
			//$saldo_acab = $saldo_aa + $ent_acab - $sai_acab;
		?>
		<tr>
		

			<td><?php echo $linha['idconta']; ?> </td>
			<td><?php echo $linha['mes']; ?> </td>
			<td><?php echo $linha['ano']; ?> </td>
			<td><?php echo formata_dinheiro($linha['saldo_ano_ant']); ?> </td>
			<td><?php echo formata_dinheiro($linha['saldo_anterior_mes']); ?> </td>
			<td><?php echo formata_dinheiro($linha['credito_mes']); ?> </td>
			<td><?php echo formata_dinheiro($linha['debito_mes']); ?> </td>
			<td><?php echo formata_dinheiro($linha['saldo_atual_mes']); ?> </td>
			<td><?php echo formata_dinheiro($linha['bal_mes']); ?> </td>
			<td><?php echo formata_dinheiro($linha['credito_acum_ano']); ?> </td>	
			<td><?php echo formata_dinheiro($linha['debito_acum_ano']); ?> </td>
			<td><?php echo formata_dinheiro($linha['bal_acum']); ?> </td>	
			<td><?php echo formata_dinheiro($linha['saldo_acum_ano']); ?> </td>				
			<?php
		 } 
		
		?>
		</tr>
		<?php 
		?>
	</table>
	<br>
	DADOS POR MES / ANO
	<table border="1">
		<?php
		$mes_hoje = 12;
		$ano_hoje = 2014;
		$mostrares = new MOVS;
		$dados = $mostrares->dados_pormes($contapd, $mes_hoje, $ano_hoje );
		?>
			<tr>
				<td colspan="11">DADOS POR MES / ANO</td>
			</tr>	
			<tr>
				<th>Conta</th>
				<th>id</th>
				<th>data</th>
				<th>Descricao</th>
				<th>Cat</th>
				<th>Livro</th>
				<th>Folha</th>
				<th>Saldo Anterior</th>
				<th>Creditos</th>
				<th>Debito</th>
				<th>Saldo Atual</th>
			</tr>
			<tr>
			<?php foreach($dados as $linha){ ?>
				
				<td><?php echo $linha['id']; ?> </td>
				<td><?php echo invertdata($linha['datamov']); ?> </td>
				<td><?php echo $linha['descricao']; ?> </td>
				
				<td><?php echo $linha['idlivro']; ?> </td>
				<td><?php echo $linha['folha']; ?> </td>
				
				<td><?php echo formata_dinheiro($linha['saldo_anterior']); ?> </td>
				<td><?php echo formata_dinheiro($linha['credito']); ?> </td>
				<td><?php echo formata_dinheiro($linha['debito']); ?> </td>
				<td><?php echo formata_dinheiro($linha['saldo_atual']); ?> </td>
				
				
				
			</tr>
			<?php } 
			$dados = null;
			?>
	</table>

	BALANÇO POR DATA
	<table border="1">
		<?php
			$livro=1;
			$data_i = invertData('01-01-2020');
			$data_f = invertData('31-01-2020');
			$mostrar = new MOVS;
			$dados = $mostrar->bal_pordata($contapd, $data_i, $data_f);
		?>
		<tr>
			<td colspan="15">BALANÇO POR DATA</td>
		</tr>	
		<tr>
			<th>Idconta</th>
			<th>IdLivro</th>
			<th>Folha</th>
			<th>Saldo_f_a</th>
			<th>Credito_f</th>
			<th>Debitos_f</th>
			<th>Saldo_Atual_f</th>
			<th>Bal_f</th>
			<th>Saldo_la</th>
			<th>Credito_Acum</th>
			<th>Cred_la</th>
			<th>Deb_Acum</th>
			<th>Debito_la</th>
			<th>Bal_cre</th>
			<th>Bal_Acum</th>
			
			
		</tr>
		<?php foreach($dados as $linha){ ?>
		<tr>
		

			<td><?php echo $linha['idconta']; ?> </td>
			<td><?php echo $linha['saldo_ant_per']; ?> </td>
			<td><?php echo formata_dinheiro($linha['credito_per']); ?> </td>
			<td><?php echo formata_dinheiro($linha['debito_per']); ?> </td>
			<td><?php echo formata_dinheiro($linha['bal_per']); ?> </td>
			<td><?php echo formata_dinheiro($linha['saldo_atual_per']); ?> </td>
			<td><?php echo formata_dinheiro($linha['credito_acum_per']); ?> </td>
			<td><?php echo formata_dinheiro($linha['debito_acum_per']); ?> </td>
			
			<?php
		 } 
		$dados = null;
		?>
		</tr>
		<?php 
		?>
	</table>
	<br>	
	
	DADOS POR INTERVALO DE DATAS
	<table border="1">
		<?php
		$busca = '%%';
		$data_i = '2020-01-01';
		$data_f = '2020-01-31';
		$mostrares = new MOVS;
		$dados = $mostrares->dados_pordata($contapd, $busca, $data_i, $data_f );
		?>
			<tr>
				<td colspan="11">DADOS POR INTERVALO DE DATAS</td>
			</tr>	
			<tr>
				<th>Conta</th>
				<th>id</th>
				<th>data</th>
				<th>Descricao</th>
				<th>Cat</th>
				<th>Livro</th>
				<th>Folha</th>
				<th>Saldo Anterior</th>
				<th>Creditos</th>
				<th>Debito</th>
				<th>Saldo Atual</th>
			</tr>
			<tr>
			<?php foreach($dados as $linha){ ?>
				
				<td><?php echo $linha['id']; ?> </td>
				<td><?php echo invertdata($linha['datamov']); ?> </td>
				<td><?php echo $linha['descricao']; ?> </td>
				
				<td><?php echo $linha['idlivro']; ?> </td>
				<td><?php echo $linha['folha']; ?> </td>
				
				<td><?php echo formata_dinheiro($linha['saldo_anterior']); ?> </td>
				<td><?php echo formata_dinheiro($linha['credito']); ?> </td>
				<td><?php echo formata_dinheiro($linha['debito']); ?> </td>
				<td><?php echo formata_dinheiro($linha['saldo_atual']); ?> </td>
				
				
				
			</tr>
			<?php } 
			$dados = null;
			?>
	</table>