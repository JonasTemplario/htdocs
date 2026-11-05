<?php
$arquivo = "clientes.json";

//Capturar dados do POST
$nome = $_POST['nome'] ?? null;
$telefone = $_POST['telefone'] ?? null;
$email = $_POST['email'] ?? null;

//Verificar se os campos foram enviados
if ($nome && $telefone && $email){
    // Criar Array
    $novoCliente = [
        "nome" => $nome,
        "telefone" => $telefone,
        "email" => $email
    ];
    // Verifico se o arquivo json existe no disco
    if(file_exists($arquivo)){
        // Recebe o conteudo do arquivo json
        $conteudo = file_get_contents($arquivo);
        //Transforma em objeto
        $cliente = json_decode($conteudo, true);
    } else{
        //Vou criar um Array de $cliente vazio
        $cliente = [];
    }
    //Adicionar o cliente ou novo cliente no Array
    $cliente [] = $novoCliente;
    $jsonData = json_encode($cliente, JSON_PRETTY_PRINT);

    file_put_contents($arquivo, $jsonData);
    echo "Cliente salvo com sucesso" ;
}else{
    echo "Por favor, preencha os campos";
}




