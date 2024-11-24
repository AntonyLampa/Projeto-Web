<?php
session_start(); // Inicia a sessão
include 'conexao.php';

// Verifica se o usuário já está logado
if (isset($_SESSION['usuario_id'])) {
    // Redireciona diretamente para o menu se estiver logado
    header("Location: menu.html");
    exit();
}

// Verifica se os campos foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST["email"]));
    $senha = $_POST["senha"];

    // Prepara a query
    $cmd = $conn->prepare("SELECT * FROM tb_usuarios WHERE email = ?");

    if ($cmd) {
        // Associa os parâmetros
        $cmd->bind_param("s", $email);

        // Executa a consulta
        $cmd->execute();

        // Obtém o resultado
        $result = $cmd->get_result();

        if ($result->num_rows > 0) {
            // Verifica se a senha está correta
            $usuario = $result->fetch_assoc();
            if (password_verify($senha, $usuario['senha'])) {
                // Armazena o ID do usuário e outras informações na sessão
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];

                // Redireciona para o menu
                header("Location: menu.html");
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

    // Redireciona de volta para a página de login
    header("Location: index.php");
    exit();
}
?>