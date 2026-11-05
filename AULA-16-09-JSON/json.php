<?php

$data = [
"nome" => "Joao",
"idade" => 53,
"cidade" => "Aracatuba"
];

echo "<h1>Trabalhando com JSON</h1>";   

print_r($data);
echo "<br><hr><br>";
var_dump($data);

// Converter o Array em JSON
$jsonDados = json_encode($data, JSON_PRETTY_PRINT /* Formata a impressão como se fosse Array */);
echo "<br<>hr><br>";
echo "<pre>"; // Não funciona em JSON
print_r($jsonDados);    
echo "</pre>";

// Salvar arquivo JSON em arquivo
file_put_contents("dados.json", $jsonDados);
echo "Arquivo JSON salvo com sucesso.";