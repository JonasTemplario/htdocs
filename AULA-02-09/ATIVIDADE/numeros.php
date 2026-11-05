<?php
echo "teste";

$novoArray = array();

for ($i = 0; $i < 25; $i++ ){
    $novoArray[$i] = rand(1, 100);
}
$contagem = array();

for ($i = 0; $i < 25; $i++){

    $numero = $novoArray[$i];
    $jaContado = false;
    // Verifica se ná rodamos esse número
    for($j = 0; $j < count($contagem); $j++){
        if($contagem[$j][0] == $numero){
            $contagem[$j][1]++; // incrementa a quantidade
            $jaContado = true;
        }
    }
    // se não foi contado, adiciono um novo na contagem
    if( !$jaContado ){
        $contagem[] = array($numero, 1);
    }
}
// exibir os resultados

for ( $i = 0; $i < count($contagem); $i++ ){
    echo "Numero" . $contagem[$i][0] . " apareceu " . $contagem[$i][1] . " vez(es) <br>";
}
    echo "<pre><br><hr><br>";
    echo print_r($contagem);
    echo "</pre><br><hr><br>";
