<form>
							
<table class="table table-bordered"><!-- TABELA ADICIONAR MOVIMENTOS -->	
	<tr style="width:150px;">
		<td align="right" style="width:150px;"><!-- CAMPO AÇÃO VALUE 1 -->
			<span><strong>Pagina: </strong></span><input type="text" name="acao" class="form-control"  value="1" size="10"/>
		</td>
		<td align="left" style="width:150px;"><!-- CAMPO DATA -->
			Data: <input type="data" href="javascript:;" class="form-control" onclick="ds_sh(this);" id="datam" style="cursor: text" name="datamov" size="11" maxlength="10" value="" class="tcal"/>
			
		</td>
	</tr>		
	<tr style="width:150px;">
		<td align="right"><!-- CAMPO AÇÃO DATAMOV -->
			Data: <input type="text" name="datamov" class="form-control" id="datamov" size="11" maxlength="10" value="<?php echo $dia_hoje?>-<?php echo $mes_hoje ?>-<?php echo $ano_hoje ?>">
		</td>
		<td align="left"><!-- CAMPO TIPO -->
		Tipo:
			<label for="tipo_receita" style="color:#030"><input class="form-control" type="radio" name="tipo" value="1" id="tipo_receita" /> Receita</label>&nbsp; 
			<label for="tipo_despesa" style="color:#C00"><input class="form-control" type="radio" name="tipo" value="0" id="tipo_despesa" /> Despesa</label>
		</td>
	</tr>			
	<tr style="width:150px;">
		<td align="left"><!-- CAMPO CATEGORIA -->
		Categoria:
			<select name="cat" class="form-control">
				<option value="<?php echo $row['id']?>"><?php echo $row['nome']?></option>
			</select>
		</td>
		<td align="right"><!-- CAMPO  DESCRIÇÃO-->
			<strong> Descrição: </strong><input type="text" name="descricao" class="form-control" size="40" maxlength="255" />
		</td>
	</tr>
	<tr style="width:150px;">
		<td align="right"><!-- CAMPO VALOR -->
			<strong>Valor:</strong>
			R$ <input type="text" name="valor" class="form-control" size="8" maxlength="10" />
		</td>
		<td>Conta:
			<select name="idconta" id="idc" class="form-control">
				<option value="<?php echo $row['idconta']?>"><?php echo $row['conta']?></option>
			</select>
		</td>
	</tr>
	<tr style="width:150px;">
		<td>
			Folha: <input type="text" name="folha" class="form-control" size="2" id="folha"/>
		</td>
		<td align="right"><!-- BOTÃO ENVIAR  -->
			<input type="submit" class="input" class="form-control" value="Enviar" />
		</td>
	</tr>
</form>	