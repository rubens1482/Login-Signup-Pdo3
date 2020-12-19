<?php
require_once("class.cat.php");
$id=$_GET['id'];
$pdo = new Database();
$db = $pdo->dbConnection();

	$stmt = $db->prepare("DELETE FROM lc_cat WHERE id=:id");
	$stmt->bindParam(':id', $_POST['id'], PDO::PARAM_STR);
	$stmt->execute();
	header ("location: list_cat.php");
	

?>