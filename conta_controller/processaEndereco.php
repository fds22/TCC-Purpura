<?php
session_start();
require_once '../data/conexao.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// LOG
file_put_contents(__DIR__ . "/log.txt", "======== NOVO ENVIO ========\n", FILE_APPEND);
file_put_contents(__DIR__ . "/log.txt", "POST:\n" . print_r($_POST, true), FILE_APPEND);
file_put_contents(__DIR__ . "/log.txt", "SESSION:\n" . print_r($_SESSION, true), FILE_APPEND);

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    file_put_contents(__DIR__ . "/log.txt", "Usuário NÃO logado. Redirecionando para login.\n", FILE_APPEND);
    header("Location: ../login/login.php");
    exit();
}

// Processa dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeEnd = trim($_POST['nomeEnd'] ?? '');
    $cep = trim($_POST['cep'] ?? '');
    $rua = trim($_POST['rua'] ?? '');
    $numero = intval($_POST['numero'] ?? 0);
    $complemento = trim($_POST['complemento'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $estado = trim($_POST['estado'] ?? '');

    $conexao = conectarBanco();
    if (!$conexao) {
        file_put_contents(__DIR__ . "/log.txt", "Erro ao conectar ao banco.\n", FILE_APPEND);
        exit("Erro na conexão com banco.");
    }

    $sql = "INSERT INTO endereco (nomeEnd, cep, rua, numero, complemento, bairro, cidade, estado, idUsuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        file_put_contents(__DIR__ . "/log.txt", "Erro no prepare(): " . $conexao->error . "\n", FILE_APPEND);
        exit("Erro prepare.");
    }

    $stmt->bind_param("ssssssssi", $nomeEnd, $cep, $rua, $numero, $complemento, $bairro, $cidade, $estado, $_SESSION['usuario_id']);

    if ($stmt->execute()) {
        file_put_contents(__DIR__ . "/log.txt", "SUCESSO: Endereço cadastrado.\n", FILE_APPEND);
        $_SESSION['cadastro_sucesso'] = "Cadastro realizado com sucesso!";
        header("Location: conta.php");
        exit();
    } else {
        file_put_contents(__DIR__ . "/log.txt", "ERRO MySQL: " . $stmt->error . "\n", FILE_APPEND);
        $_SESSION['cadastro_erro'] = "Erro ao cadastrar endereço. Tente novamente.";
        header("Location: conta.php");
        exit();
    }
}
