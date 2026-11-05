<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();

if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = array();
    $_SESSION['contas'] = array();
    $_SESSION['movimentacoes'] = array();
}

function cadastrarUsuario($nome, $cpf, $login, $senha)
{
    if ($nome == '' || $cpf == '' || $login == '' || $senha == '') {
        echo 'Preencha todos os campos<br>';
        return;
    }

    foreach ($_SESSION['usuarios'] as $u) {
        if ($u['login'] == $login) {
            echo 'Esse login ja existe<br>';
            return;
        }
    }

    $_SESSION['usuarios'][] = array(
        'nome' => $nome,
        'cpf' => $cpf,
        'login' => $login,
        'senha' => $senha
    );
    echo 'Usuario ' . $nome . ' cadastrado<br>';
}

function cadastrarConta($login)
{
    $existe = false;
    foreach ($_SESSION['usuarios'] as $u) {
        if ($u['login'] == $login) {
            $existe = true;
        }
    }

    if ($existe == false) {
        echo 'Usuario nao encontrado<br>';
        return;
    }

    $numero = count($_SESSION['contas']) + 1;
    $_SESSION['contas'][$numero] = array(
        'numero' => $numero,
        'login' => $login,
        'saldo' => 0
    );
    echo 'Conta ' . $numero . ' criada para ' . $login . '<br>';
}

function registrarMovimentacao($conta, $tipo, $valor)
{
    $_SESSION['movimentacoes'][] = array(
        'conta' => $conta,
        'tipo' => $tipo,
        'valor' => $valor,
        'data' => date('d/m/Y H:i:s')
    );
}

function depositar($numero, $valor)
{
    if (!isset($_SESSION['contas'][$numero])) {
        echo 'Conta nao encontrada<br>';
        return;
    }

    if (!is_numeric($valor) || $valor <= 0) {
        echo 'Valor invalido<br>';
        return;
    }

    $_SESSION['contas'][$numero]['saldo'] = $_SESSION['contas'][$numero]['saldo'] + $valor;
    registrarMovimentacao($numero, 'Deposito', $valor);
    echo 'Deposito de R$ ' . $valor . ' feito na conta ' . $numero . '<br>';
}

function sacar($numero, $valor)
{
    if (!isset($_SESSION['contas'][$numero])) {
        echo 'Conta nao encontrada<br>';
        return;
    }

    if (!is_numeric($valor) || $valor <= 0) {
        echo 'Valor invalido<br>';
        return;
    }

    if ($valor > $_SESSION['contas'][$numero]['saldo']) {
        echo 'Saldo insuficiente<br>';
        return;
    }

    $_SESSION['contas'][$numero]['saldo'] = $_SESSION['contas'][$numero]['saldo'] - $valor;
    registrarMovimentacao($numero, 'Saque', $valor);
    echo 'Saque de R$ ' . $valor . ' feito na conta ' . $numero . '<br>';
}

function consultarSaldo($numero)
{
    if (!isset($_SESSION['contas'][$numero])) {
        echo 'Conta nao encontrada<br>';
        return;
    }

    echo 'Saldo da conta ' . $numero . ': R$ ' . $_SESSION['contas'][$numero]['saldo'] . '<br>';
}

function mostrarMovimentacoes($numero)
{
    echo 'Movimentacoes da conta ' . $numero . ':<br>';
    foreach ($_SESSION['movimentacoes'] as $m) {
        if ($m['conta'] == $numero) {
            echo $m['data'] . ' - ' . $m['tipo'] . ' - R$ ' . $m['valor'] . '<br>';
        }
    }
}
