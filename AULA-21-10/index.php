<?php
date_default_timezone_set('America/Sao_Paulo');
$timestamp = date('Y-m-d H:i:s');
echo $timestamp;
echo '<br><hr><br>';
echo date('d/m/Y H:i:s', strtotime($timestamp));
echo '<br><hr><br>';
$ano = '03/07/1973';
echo 'DIA ' .date('d' , strtotime($ano));
echo '<br>';
echo 'MES ' .date('M' , strtotime($ano));
echo '<br>';
echo 'ANO ' .date('Y' , strtotime($ano));
echo '<br><hr><br>';
// Criar um array com a data q vc quer
$ano2 = explode('/', $ano);

print_r($ano2);

$dia = $ano2[0];
$mes = $ano2[1];
$ano = $ano2[2];

echo '<br><hr><br>';
echo $dia , '/' , $mes , '/' , $ano;






