<?php
session_start();

if (isset($_SESSION['pedido'])) {
    $_SESSION['pedido'] = []; 
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menu.css">
    <title>Finalizar Pedido</title>
    <style>
        .menu{
            position: absolute;
            top: 20px; 
            right: 20px; 
            text-decoration: none;
            color: #357abd;
            font-size: 18px; 
            padding: 10px; 
            background-color: #f1f1f1; 
            border-radius: 5px; 
        }
        .message {
            text-align: center;
            margin-top: 50px;
            font-size: 24px;
            color: green;
        }
        .message a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #357abd;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a class="menu" href="menu.php">Menu</a>
        <div class="title">
            <h1>Pedido Efetuado com Sucesso!</h1>
        </div>
        <div class="containergeral">
        <div class="message">
            <p>Seu pedido foi registrado com suceso. Obrigado pela sua compra!</p>
            <a href="menu.php">Menu</a>
            <div>
        </div>
    </div>
</body>
</html>
