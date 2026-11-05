<?php
// /* Strings - Declaradas e podem ser alteradas */
// $pi = 3.14;
// echo $pi;

// define('MOTO', 'HONDA-CB300'); // Cria uma constante que não pode ser alterada. Deve-se usar áspas simples no Define
// echo "<br><hr><br>";
// echo MOTO;

// /* Definição de Array */
// $opcionais = array(
//     'protetor_dianteiro' => 'sim',
//     'protetor_traseiro' => 'sim',
//     'alarme' => 'presencial',
// );
// echo "<br><hr><br>";
// echo "<pre>";
// print_r($opcionais);
// echo "</pre>";
// echo "<br><hr><br>";
// $valor = 22000.50;
// echo "<br><hr><br>";
// /* Formatação */

// echo number_format($valor, 2, ",", ".");
// echo "<br><hr><br>";
// echo $valor;
// echo "<br><hr><br>";


$real = 3000;
$moeda = "R$" . number_format($real, 2, ",", ".");
$porcentagem = $real . "%";
echo "Real => " . $real;
echo "<br>";
echo "Moeda => " . $moeda;
echo "<br>";
echo "Porcentagem => " . $porcentagem;



?>