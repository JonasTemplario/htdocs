<?php
$senhaSalva = md5("123Sale");
$email = $_REQUEST['email'];
$senha = $_REQUEST['senha'];
// Senha recebe ela mesma, mas criptografaga com md5 ( método de criptografia )
$senha = md5($senha);

echo "O usuário digitou o email $email </br>";
echo "O usuário digitou a senha $senha </br>";   

if ($senha == $senhaSalva){
    echo "Acertou a Senha </br>";   
    header('Location: produtos.php');
    exit;
}else{
    echo "Errou a Senha </br>";   
}