<?php

//carregar o form em um variável
$form = file_get_contents("cep.html");

//substitui o resultado por nada.
$form = str_replace("#resultado"/*id do resultado* */, ""/*NADA*/, $form/*form alterado com nada dentro*/);




echo $form;
?>
