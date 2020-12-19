<?php
require_once("config/session.php");
$pdo = new Database();
$db = $pdo->dbConnection();

$id = '';
$nome = '';
$operacao = '';

function getcat()
{
	$posts = array();
	$posts[0] = $_POST['id'];
	$posts[1] = $_POST['nome'];
	$posts[2] = $_POST['operacao'];
	
	return $posts;
}

if (isset($_POST['search']))
{
	$data = getcat();
	if (empty($data[0]))
	{
		echo "digite o codigo";
	} else {
		$search = $db->prepare("SELECT * FROM lc_cat WHERE id = :id");
		$search->execute(array(
		':id'=>$data[0]
		));
		if ($search){
			$dados = $search->fetch();
		if(empty($dados))
		{ ?>
		<div id="error">
		<?php
		echo "Categoria inexistente!";
		?>
		</div>
		<?php 	
		}else {
		$id = $dados[0];
		$nome = $dados[1];
		$operacao = $dados[2];
		}
		}
		
	}
}
// INSERT INTO lc_cat
if (isset($_POST['insert']))
{
	$data1 = getcat();
	if (empty($data1[1]) || empty($data1[2]))
	{
		echo "digite os dados para lancamento!";
	} else {
		$insert = $db->prepare("INSERT INTO lc_cat (nome, operacao) VALUES (:nome, :operacao)");
		$insert->execute(array(
				':nome'=>$data1[1],
				':operacao'=>$data1[2],
		));
		if ($insert)
		{
			echo "dados inseridos com sucesso!";
		} else {
			echo "erro ao inserir!";
		}
		
	}
}
?>

<div class="modal fade" id="crud_cat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel">Editar Categoria n&#186; </h4></center>
                </div>
                <div class="modal-body" >
				
				<div class="container-fluid" >
				<form method="POST" action="crud_cat.php" >
					<div class="row" >
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Id:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="id" class="form-control" value="<?php echo $id ?>">
						</div>
					</div>
					<div class="row" >
						<div class="col-lg-2">
							<label style="position:relative; top:7px;">Descrição:</label>
						</div>
						<div class="col-lg-10">
							<input type="text" name="nome" class="form-control" value="<?php echo $nome ?>">
						</div>
					</div>
					<div style="height:10px;"></div>
					<div class="row" >
						<div class="col-lg-2" >
							<label style="position:relative; bottom:1px;">Operacao:</label>
						</div>
						<div class="col-lg-10" >
							<label for="operacao<?php echo $operacao?>" style="color:#030"><input <?php if($operacao =="credito") echo "checked=checked"?> type="radio" name="operacao" value="<?php echo $operacao?>" id="tipo_receita<?php echo $operacao?>" /> Credito</label>&nbsp; 
							<label for="operacao<?php echo $operacao?>" style="color:#C00"><input <?php if($operacao =="debito") echo "checked=checked"?> type="radio" name="operacao" value="<?php echo $operacao?>" id="operacao<?php echo $operacao?>" /> Despesa</label>
						</div
					</div>
					<div style="height:10px;"></div>	
                </div> 
				</div>
                <div class="modal-footer">
					<button type="button" class="btn btn-default" name="insert" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span> insert </button>
					<button type="button" class="btn btn-default" name="update" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span> Update </button>
                    <button type="button" class="btn btn-default" name="delete" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span> Delete </button>
                    <button type="submit" class="btn btn-warning" name="search"><span class="glyphicon glyphicon-check"></span> Search </button>
                </div>
				</form>
            </div>
        </div>
    </div>