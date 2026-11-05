<?php
include 'banco.php';

$acao = '';
if (isset($_POST['acao'])) {
    $acao = $_POST['acao'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Resultado - Banco</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="logo">Banco Digital</div>
</header>

<main>
    <div class="cartao resultado">
        <h2>Resultado</h2>
        <div class="saida">
            <?php
            if ($acao == 'cadastrar_usuario') {
                cadastrarUsuario($_POST['nome'], $_POST['cpf'], $_POST['login'], $_POST['senha']);
            } elseif ($acao == 'cadastrar_conta') {
                cadastrarConta($_POST['login']);
            } elseif ($acao == 'depositar') {
                $valor = str_replace(',', '.', $_POST['valor']);
                depositar($_POST['conta'], $valor);
            } elseif ($acao == 'sacar') {
                $valor = str_replace(',', '.', $_POST['valor']);
                sacar($_POST['conta'], $valor);
            } elseif ($acao == 'saldo') {
                consultarSaldo($_POST['conta']);
            } elseif ($acao == 'movimentacoes') {
                mostrarMovimentacoes($_POST['conta']);
            } else {
                echo 'Nenhuma acao escolhida<br>';
            }
            ?>
        </div>
        <a class="voltar" href="index.html">Voltar</a>
    </div>
</main>

<footer>Projeto Bancário - TDS</footer>

</body>
</html>
