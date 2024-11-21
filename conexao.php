<?php
    // PARÂMETROS DA CONEXÃO
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "db_usuarios";

    // Estabelecer a conexão
    $conn = new mysqli($servidor,$usuario,$senha,$banco);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    echo "Conexão realizada com sucesso!";
?>