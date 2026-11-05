<?php
// string básica
$nome = "Julius";
$sobrenome = "César";
$texto = "Olá, mundo!";

//Comprimento da string
echo strlen($nome); // Mostra quantos caractéries tem na string 
echo "<br><hr><br>";//BR - da espaços entre as linhas. HR - coloca uma linha horizontal

echo $nome." ".$sobrenome;// Concatena as variáveis
echo "<br><hr><br>";

//Subsring
echo substr($nome, 0, 6); // O primeiro número (0), indica a posição inicial. O segundo (4) inidica quantas letras vai mostrar
echo "<br><hr><br>";

echo strpos($sobrenome  , "r");
echo "<br><hr><br>";

//Replace
echo str_replace("C", "c", $sobrenome); // Se econtrar a primeira letra, substitui pela segunda ("C" por "c")
echo "<br><hr><br>";

// Função Multilingual
echo mb_strlen($texto);
echo "<br>";
echo mb_strlen($nome);
echo "<br><hr><br>";

//Dividir uma frase
$categorias = "PHP,JavaScript,Python";
$arrayCategoria = explode(",", $categorias); // Transforma a string ($arrayCategoria) em Array e traz um elemento "separador", no caso, a vírgula faz isso
echo "<pre>"; // Separa em linhas ( quase igual json )
print_r($arrayCategoria); // Mostra o conteúdo do Array



?>