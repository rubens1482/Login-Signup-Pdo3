<?php

function formata_dinheiro($valor) {
    $valor = number_format($valor, 2, ',', '.');
    return "R$ " . $valor;
}
?>
<?php
function mostraMes($m) {
    switch ($m) {
        case 01: case 1: $mes = "Jan";
            break;
        case 02: case 2: $mes = "Fev";
            break;
        case 03: case 3: $mes = "Mar";
            break;
        case 04: case 4: $mes = "Abr";
            break;
        case 05: case 5: $mes = "Mai";
            break;
        case 06: case 6: $mes = "Jun";
            break;
        case 07: case 7: $mes = "Jul";
            break;
        case 8: $mes = "Ago";
            break;
        case 9: case 9: $mes = "Set";
            break;
        case 10: $mes = "Out";
            break;
        case 11: $mes = "Nov";
            break;
        case 12: $mes = "Dez";
            break;
    }
    return $mes;
}
?>
<?php
function InvertData($campo){

    if(substr($campo,2,1)=='-'){
        $campo=substr($campo,6,4).'-'.substr($campo,3,2).'-'.substr($campo,0,2);//2012-10-10
    } else {
        $campo=substr($campo,8,2).'-'.substr($campo,5,2).'-'.substr($campo,0,4); //10/10/2012
    }

    return($campo);
}

?>
