<?php
require_once("class.cat.php");
$cat = new EVENTS_CAT();
public function UltimoId($tabela,$id)
{
	try{
		if($cat->new_cat($nome,$operacao)){	
			$cat->UltimoId("lc_cat",$id);
			return true;
		} else {
			echo return false;
		}
	}	catch (PDOException $erro){
			echo "erro ultimo id". $erro->getMessage();
	}
}


?>