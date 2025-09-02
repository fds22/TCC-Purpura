<?php
session_start();
require_once '../../data/conexao.php';

$erro = '';
$sucesso = '';

// Processa o formulário de recuperação de senha
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $nova_senha = trim($_POST['nova_senha'] ?? '');
    $confirmar_senha = trim($_POST['confirmar_senha'] ?? '');
    
    // Validações
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Por favor, informe um e-mail válido.";
    } elseif ($nova_senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem.";
    } else {
        $conexao = conectarBanco();
        
        // Verifica se o email existe no banco de dados
        $sql = "SELECT idUsuario FROM usuario WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 0) {
            $erro = "Este e-mail não está cadastrado em nosso sistema.";
        } else {
            // Atualiza a senha do usuário
            $senhaHash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $usuario = $resultado->fetch_assoc();
            
            $sql = "UPDATE usuario SET senha = ? WHERE idUsuario = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("si", $senhaHash, $usuario['idUsuario']);
            
            if ($stmt->execute()) {
                $sucesso = "Senha redefinida com sucesso!";
                header("Location: ../login.php");
            } else {
                $erro = "Erro ao redefinir a senha. Por favor, tente novamente.";
            }
        }
        $stmt->close();
        $conexao->close();
    }
}
?>