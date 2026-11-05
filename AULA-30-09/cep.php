<?php
//Receber o Campo name="cep"
//Verificar se existe o campo cep vindo.
//Se não existir ("dar uma msg").
// ! = negação ( é um operador de negação ).
if(!isset($_REQUEST['cep'])){
    echo "CEP não encontrado!" . "<br>"
    . "<a href='index.php>" .
    "Voltar ao Formulário </a>";
    exit;
} 
// Variável $cep recebe CEP vindo do form
$cep = $_REQUEST['cep'];
// montar uma urll para enviar para o navegador.
// Você vai juntar o cep com a url
$url = "https://viacep.com.br/ws/". $cep . "/json/";

// echo "Entrou aqui..."; echo "<h1>$url</h1>";
//Criar um cliente URL que recebe a estrutura.
// Para a comunicação com a página.

$curl = curl_init();
curl_setopt_array(
    $curl, 
    [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url
    ]
);
//Armazenar o Retorno em algum lugar.
$resposta = curl_exec($curl);
$form = file_get_contents("cep.html");
//Vou pegar somente os campos que interessam.
$dados = json_decode($resposta, true);
$endereco = "";
$endereco = "<br><br>" . "<h2>" .
    $dados["cep"] . "<br>" . 
    $dados["logradouro"] . "<br>" . 
    $dados["bairro"] . "<br>" . 
    $dados["localidade"] . "<br>" . 
    $dados["estado"];
$form = str_replace("#resultado", 
                $endereco,
                $form
            ) . "</h2>";
echo $form;





?>