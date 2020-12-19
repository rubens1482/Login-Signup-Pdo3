<?php

require_once('config/dbconfig.php');

class ACCOUNT
{	
	private $conn;
//	FUN플O DE CONEX홒
	public function __construct()
	{
		$database = new Database();
		$dbs = $database->dbConnection();
		$this->conn = $dbs;
    }
//	FUN플O DE CONSULTA	
	public function SqlQuery($sqli)
	{
		$stmt = $this->conn->prepare($sqli);
		return $stmt;
	}
//	FUN플O DE REGISTRO	
	public function register($account,$prop,$pass_c)
	{
		try
		{
			$new_password = password_hash($pass_c, PASSWORD_DEFAULT);
			
			$stmt = $this->conn->prepare("INSERT INTO lc_contass(conta,proprietario,password) 
		                                               VALUES(:account, :prop, :pass)");
												  
			$stmt->bindparam(":account", $account);
			$stmt->bindparam(":prop", $prop);
			$stmt->bindparam(":pass", $new_password);										  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}	
//	FUN플O DE SELE플O	
	public function doLogin_c($account,$prop,$pass_c)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT idconta, conta, proprietario, password FROM lc_contass WHERE conta=:account OR proprietario=:prop ");
			$stmt->execute(array(':account'=>$account, ':prop'=>$prop));
			$accountRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($pass_c, $accountRow['password']))
				{
					$_SESSION['account_session'] = $accountRow['idconta'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
//	FUN플O DE VERIFICA플O LOGADO	
	public function is_loggedin_c()
	{
		if(isset($_SESSION['account_session']))
		{
			return true;
		}
	}
//	FUN플O DE REDIRECIONAMENTO	
	public function redirect($url)
	{
		header("Location: $url");
	}
//	FUN플O DE LOGOUT	
	public function doLogout_c()
	{
		//session_destroy();
		unset($_SESSION['account_session']);
		return true;
	}
}
?>