<?php
session_start(); // Inicia a sessão

// Verifica se o usuário já está logado
if (isset($_SESSION['usuario_id'])) {
    header("Location: menu.html"); // Redireciona para o menu se estiver logado
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-image: url(images/restaurante.png);
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            min-height: 100vh;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        h1 {
            color: white;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        form {
            opacity: 0.9;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            min-width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        label {
            color: rgb(0, 0, 0);
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
        }
        .error-message {
            color: #ff4444;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
        .error-message.active {
            display: block;
        }
        .button {
            background-color: #4a90e2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #357abd;
        }
        .button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .links-container {
            text-align: center;
            margin-top: 20px;
        }

        .link {
            color: #4a90e2;
            text-decoration: none;
            font-size: 14px;
            margin: 0 10px;
        }

        .link:hover {
            text-decoration: underline;
        }

        .image{
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media (max-width: 480px) {
            form {
                min-width: auto;
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        
        <form action="login.php" method="post" id="loginForm">

            <div class="image">
                <img src="images/logotipo.png" alt="Logotipo" width="70px">
            </div>

            <div class="form-group">
                <label for="email">E-mail*</label>
                <input type="email" id="email" name="email" required autofocus>
            </div>
            <div class="form-group">
                <label for="senha">Senha*</label>
                <input type="password" id="senha" name="senha" required>
            </div>

            <!-- Exibição da mensagem de erro -->
            <?php
            session_start();
            if (isset($_SESSION['login_error'])) {
                echo '<div class="error-message active">' . $_SESSION['login_error'] . '</div>';
                unset($_SESSION['login_error']); // Limpa o erro após exibir
            }
            ?>
            
            <div id="loginError" class="error-message"></div>
            <button type="submit" class="button">Logar</button>

            <div class="links-container">
                <a href="cadastro.html" class="link">Criar uma conta</a>
            </div>
        </form>
    </div>
    <script>
        // Função para exibir mensagens de erro
        function mostrarErro(mensagem) {
            const errorElement = document.getElementById('loginError');
            errorElement.textContent = mensagem;
            errorElement.classList.add('active');
        }

        // Validação do formulário antes do envio
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;

            // Validação básica
            if (!email || !senha) {
                e.preventDefault();
                mostrarErro('Por favor, preencha todos os campos.');
                return;
            }

            // Validação de formato de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                mostrarErro('Por favor, insira um email válido.');
                return;
            }
        });

        // Limpar mensagem de erro quando o usuário começar a digitar
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function () {
                document.getElementById('loginError').classList.remove('active');
            });
        });
    </script>
</body>
</html>