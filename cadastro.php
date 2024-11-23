<?php

include 'conexao.php';

$nome = $_POST["nome"];
$email = $_POST["email"];
$dataNascimento = $_POST["dataNascimento"];
$telefone = $_POST["telefone"];
$senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
$cep = $_POST["cep"];
$rua = $_POST["rua"];
$numero = $_POST["numero"];
$bairro = $_POST["bairro"];
$complemento = $_POST["complemento"];
$cidade = $_POST["cidade"];
$estado = $_POST["estado"];

$cmd = $conn->prepare("INSERT INTO tb_usuarios 
    (nome, email, data_nascimento, telefone, senha, cep, rua, numero, bairro, complemento, cidade, estado) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($cmd) {
    $cmd->bind_param(
        "ssssssssssss", 
        $nome, $email, $dataNascimento, $telefone, $senha, 
        $cep, $rua, $numero, $bairro, $complemento, $cidade, $estado
    );
    if($cmd->execute()) {
        echo "Operação realizada com sucesso!";
    } else {
        echo "Erro: " . $cmd->error;
    }
} else {
    echo "ERRO ao preparar SQL: " . $conn->error;
}

?>