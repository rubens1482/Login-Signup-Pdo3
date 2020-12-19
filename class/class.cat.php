<?php

require_once('config/dbconfig.php');

class EVENTS_CAT
{	
	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function aviso($objeto){
		throw new PDOException("$objeto");
	}
		
	public function lastInsertId()
	{
        return $this->conn->lastInsertId();
	}

	public function Sql_Query($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	// CATEGORIAS COM MOVIMENTOS
	public function cat_mov($id)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT c.id FROM lc_movimento m, lc_cat c WHERE c.id=:id and c.id=m.cat ");
			$stmt->execute(array(':id'=>$id));
			$catRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($catRow->rowCount() > 0)
			{
				return $catRow;
			}else {
				echo "sem dados";
			}		
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	// 	ADICIONANDO NOVA CATEGORIA
	public function new_cat($nome,$operacao)
	{
		try
		{			
			$stmt = $this->conn->prepare("INSERT INTO lc_cat(nome,operacao)VALUES(:nome, :operacao)");									  
			$stmt->bindparam(":nome", $nome);
			$stmt->bindparam(":operacao", $operacao);									  
			
			$stmt->execute();	
			   return $stmt;
				
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	// ATUALIZANDO CATEGORIA EXISTENTE
	public function update_cat($id,$nome,$operacao)
	{
		try
		{			
			$stmt = $this->conn->prepare("UPDATE lc_cat SET nome = :nome ,operacao = :operacao WHERE id=:id");
			$stmt->bindparam(":id", $id);			
			$stmt->bindparam(":nome", $nome);
			$stmt->bindparam(":operacao", $operacao);									  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	// DELETANDO CATEGORIA
	public function delete_cat($id) 
	{
		try{
		$stmt = $this->conn->prepare("DELETE FROM lc_cat WHERE id = :id");
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		
		$stmt->execute();
		
		return $stmt;
		}
		catch (PDOException $e)
		{
		echo $e->getMessage();
		}
	}
	
	/*
	// 	ADICIONANDO NOVA MOVIMENTO
	public function new_mov($tipo,$dia,$mes,$ano,$idlivro,$folha,$cat,$descricao,$valor,$datamov,$idconta)
	{
		try
		{			
			$stmt = $this->conn->prepare("INSERT INTO lc_movimento(tipo,dia,mes,ano,idlivro,folha,cat,descricao,valor,datamov,idconta)VALUES(:tipo,:dia,:mes,:ano,:idlivro,:folha,:cat,:descricao,:valor,:datamov,:idconta)");
			
			$stmt->bindparam(":tipo", $tipo);
			$stmt->bindparam(":dia", $dia);
			$stmt->bindparam(":mes", $mes);	
			$stmt->bindparam(":ano", $ano);
			$stmt->bindparam(":idlivro", $idlivro);
			$stmt->bindparam(":folha", $folha);	
			$stmt->bindparam(":cat", $cat);	
			$stmt->bindparam(":descricao", $descricao);	
			$stmt->bindparam(":valor", $valor);	
			$stmt->bindparam(":datamov", $datamov);	
			$stmt->bindparam(":idconta", $idconta);	
			
			if($stmt->execute()){
			$erro = "inserido";
			echo $erro;
			return $stmt;
			}else{
				echo "nao inserido!";
			}
			;
			
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	*/
	
	public function update_mov($id,$tipo,$dia,$mes,$ano,$idlivro,$folha,$cat,$descricao, $valor, $datamov,$idconta)
	{
		try
		{			
			$stmt = $this->conn->prepare("UPDATE lc_movimento SET tipo=:tipo, dia=:dia, mes=:mes, ano=:ano, idlivro=:idlivro, folha=:folha, cat=:cat, descricao=:descricao, valor=:valor, datamov=:datamov, idconta=:idconta WHERE id=:id");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":tipo", $tipo);
			$stmt->bindparam(":dia", $dia);
			$stmt->bindparam(":mes", $mes);
			$stmt->bindparam(":ano", $ano);
			$stmt->bindparam(":idlivro", $idlivro);
			$stmt->bindparam(":folha", $folha);	
			$stmt->bindparam(":cat", $cat);	
			$stmt->bindparam(":descricao", $descricao);	
			$stmt->bindparam(":valor", $valor);	
			$stmt->bindparam(":datamov", $datamov);	
			$stmt->bindparam(":idconta", $idconta);	
				
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function select_lc($mes,$ano,$idconta)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM lc_movimento WHERE mes=:mes and ano=:ano and idconta=:idconta");
			$stmt->execute(array(':id'=>$id, ':datamov'=>$datamov,':descricao'=>$descricao,':tipo'=>$tipo,':valor'=>$valor,':cat'=>$cat,':idconta'=>$idconta));
			$lc_Row=$stmt->fetch(PDO::FETCH_ASSOC);
			
			foreach($result as $value)
			{
				return($result);
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	// DELETANDO CATEGORIA
	public function delete_mov($id) 
	{
		try
		{
			$stmt = $this->conn->prepare("DELETE FROM lc_movimento WHERE id = :id");
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			
			$stmt->execute();
		
			return $stmt;
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function lastId($id)
	{
		return $id;
	}
}	
?>