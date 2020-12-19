<?php
 require_once("class/class.cat.php");
 $cat = new EVENTS_CAT();

	// EVENTO PARA ADICIONAR CATEGORIAS NOVAS
	if(isset($_POST['btn-addcat']))
	{
		$nome = strip_tags($_POST['nome']);
		$operacao = strip_tags($_POST['operacao']);
		
		if($nome=="")	
		{
			$error[] = "Digite o nome !";	
		}
		else if($operacao=="")	
		{
			$error[] = "falta a operacao !";	
		}
		else
		{
			try
			{
				$stmt = $cat->Sql_Query("SELECT nome, operacao FROM lc_cat WHERE nome=:nome and operacao=:operacao");
				$stmt->execute(array(':nome'=>$nome, ':operacao'=>$operacao));
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
					
				if($row['nome']==$nome) 
				{
					$error[] = "categoria ja existe !";
				}
				else if($row['operacao']==$operacao) 
				{
					$error[] = "Operacao já existe para esta categoria!";
				}
				else
				{
					if($cat->new_cat($nome,$operacao))
					{	
						$cat->redirect('list_cat.php');
					} else 
					{
						echo $error;
						$cat->redirect('list_cat.php?Categoria_nao_inserida');	
					}
				}
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}	
	}
	// EVENTO PARA ATUALIZAR INFORMAÇÕES DA CATEGORIA
	if (isset($_POST['btn_update_cat']))
	{
		
		$id = $_POST['id'];
		$nome = $_POST['nome'];
		$operacao = $_POST['operacao'];
		
		if($cat->update_cat($id,$nome,$operacao))
		{
			$cat->redirect('list_cat.php?pagina=1');
		}else
		{
			$status = "Dados Incorretos !";
		}
	}
	// EVENTO PARA DELETAR CATEGORIA
	if (isset($_POST['btn_delete']))
	{
		$id = $_POST['id'];
		/*
		$nome = $_POST['nome'];
		$operacao = $_POST['operacao'];
		*/
		if($cat->delete_cat($id))
		{
			$cat->redirect('list_cat.php?pagina=1');
		} else 
		{
			$status = "Categoria não deletada!";	
		}
	} 

?>