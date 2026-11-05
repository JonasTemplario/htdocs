<?php
    $nome = "João";
    $idade = 53;

    
    echo "<h1>Meu nome é $nome e tenho $idade anos.</h1>";

    $login = file_get_contents("html/login.html");

    echo $login;


?>