<?php
include 'conexao.php';

// Recebe os dados do formulário
$email = htmlspecialchars(trim($_POST["email"]));
$senha = $_POST["senha"]; // A senha será verificada com password_verify()

// Prepara a query (agora verifica apenas o email)
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
            echo "Login realizado com sucesso!";
            // Redirecionar ou iniciar sessão
        } else {
            echo "Usuário ou senha inválidos.";
        }
    } else {
        echo "Usuário ou senha inválidos.";
    }
} else {
    echo "Erro ao preparar a consulta: " . $conn->error;
}
?>