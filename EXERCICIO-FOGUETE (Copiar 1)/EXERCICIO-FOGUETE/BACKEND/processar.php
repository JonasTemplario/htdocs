<?php

$combustivel = $_POST['combustivel'];
$consumo = $_POST['consumo'];

$totalTanque = (float) $_POST['combustivel'];
$consumoPorTrecho = (float) $_POST['consumo'];

$historico = [];

$distanciaTotal = 384400;
$distanciaTrecho = 0;
$totalConsumo = $consumoPorTrecho * 25;
$tanque = $totalTanque;
$i = 0;

while ($distanciaTrecho < $distanciaTotal){
    $tanque -= $consumoPorTrecho;

    $distanciaTrecho += 15376;

    if($tanque < 0){
        echo "Faltaram " . ($totalConsumo - $totalTanque) . " para chegar à Lua.";
        break;
    }
    else{
        echo "<li>";
        echo "Combustível no tanque = " . $tanque . " || Distância =" . $distanciaTrecho;
        echo "<br>";
    }
    $historico[$i] = $tanque;
    $i++;
}

if ($distanciaTrecho == $distanciaTotal){
    foreach($historico as $contagem){
    echo $contagem . "<br>";
    }
}