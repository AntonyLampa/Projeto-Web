<?php
session_start(); // Inicia a sessão
include 'conexao.php'; // Inclui a conexão com o banco de dados

// Verifica se o usuário já está logado
if (isset($_SESSION['usuario_id'])) {
    header("Location: menu.php");
    exit();
}

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));
    $senha = $_POST['senha'];

    // Prepara a consulta segura
    $cmd = $conn->prepare("SELECT * FROM tb_usuarios WHERE email = ?");
    
    if ($cmd) {
        $cmd->bind_param("s", $email);
        $cmd->execute();
        $result = $cmd->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            // Verifica a senha com hash
            if (password_verify($senha, $usuario['senha'])) {
                // Configura as variáveis de sessão
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                
                header("Location: menu.php");
                exit();
            } else {
                $_SESSION['login_error'] = "Senha e/ou E-mail incorretos.";
            }
        } else {
            $_SESSION['login_error'] = "Email não encontrado.";
        }
    } else {
        $_SESSION['login_error'] = "Erro ao preparar a consulta: " . $conn->error;
    }

    // Redireciona de volta para o formulário de login
    header("Location: index.html"); // Alterado para redirecionar para o HTML agora
    exit();
}
?>