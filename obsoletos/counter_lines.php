<?phpfunction contaLinhas($text, $maxwidth){	
	$lines=0;
	if($text==''){
		$cont = 1;
	}else{
		$cont = strlen($text);
	}
	if($cont < $maxwidth){
		$lines = 1;
	}else{
		if($cont % $maxwidth > 0){
			$lines = ($cont / $maxwidth) + 1; 
		}else{
			$lines = ($cont / $maxwidth); 
		}
	} 
	$lines = $lines + substr_count(nl2br($text),'
');
	return $lines;
}
?>