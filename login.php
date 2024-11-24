<?php
session_start(); // Inicia a sessão para armazenar mensagens de erro
include 'conexao.php';

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
                // Login bem-sucedido
                header("Location: menu.html"); // Redireciona para o menu
                exit();
            } else {
                // Armazena a mensagem de erro na sessão
                $_SESSION['login_error'] = "Senha e/ou E-mail incorretos";
            }
        } else {
            // Armazena a mensagem de erro na sessão
            $_SESSION['login_error'] = "Email não encontrado.";
        }
    } else {
        // Armazena a mensagem de erro na sessão
        $_SESSION['login_error'] = "Erro ao preparar a consulta: " . $conn->error;
    }

    // Redireciona de volta para a página de login
    header("Location: index.php");
    exit();
}
?>