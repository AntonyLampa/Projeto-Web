<?php
    include "conexao.php"
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menu.css">
    <title>Cardápio</title>
    <style>
        .carrinho{
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
        .sair{
        text-decoration: none;
        color: #357abd;
        font-size: 18px;
        padding: 10px; 
        background-color: #f1f1f1; 
        border-radius: 5px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Fazer um Pedido</h1>
        <a class="carrinho" href="carrinho.php">Carrinho</a>
        <div class="containergeral">
            <div class="image">
                <img src="images/logotipo.png" alt="Logotipo" width="70px">
            </div>
            <div class="menu-links">
                <a href="#salgadas">Pizzas Salgadas</a>
                <a href="#doces">Pizzas Doces</a>
                <a href="#bebidas">Bebidas</a>
            </div>
            <div class="salgadas" id="salgadas">
                <h2>Pizzas Salgadas</h2>
                <?php 
                    $cmd = $conn->prepare("SELECT id, nome, foto FROM tb_itens WHERE idCategoria = 1;");
                    if($cmd) {
                        $cmd->execute();
                        $res = $cmd->get_result();

                        if($res->num_rows > 0) {
                            while ($linha = $res->fetch_assoc()) {
                                echo '<div class="item">';
                                echo '<img class="imagens" src="' . htmlspecialchars($linha['foto']) . '" alt="' . htmlspecialchars($linha['nome']) . '">';
                                echo '<p>' . htmlspecialchars($linha['nome']) . '</p>';
                                echo '<a class="detalhes-link" href="detalhes.php?id=' . $linha['id'] . '">Ver Detalhes</a>';
                                echo '</div>';
                            }
                        }
                    }
                ?>
            </div>
            <div class="doces" id="doces">
                <h2>Pizzas Doces</h2>
                <?php 
                    $cmd = $conn->prepare("SELECT id, nome, foto FROM tb_itens WHERE idCategoria = 2;");
                    if($cmd) {
                        $cmd->execute();
                        $res = $cmd->get_result();

                        if($res->num_rows > 0) {
                            while ($linha = $res->fetch_assoc()) {
                                echo '<div class="item">';
                                echo '<img class="imagens" src="' . htmlspecialchars($linha['foto']) . '" alt="' . htmlspecialchars($linha['nome']) . '">';
                                echo '<p>' . htmlspecialchars($linha['nome']) . '</p>';
                                echo '<a class="detalhes-link" href="detalhes.php?id=' . $linha['id'] . '">Ver Detalhes</a>';
                                echo '</div>';
                            }
                        }
                    }
                ?>
            </div>
            <div class="bebidas" id="bebidas">
                <h2>Bebidas</h2>
                <?php 
                    $cmd = $conn->prepare("SELECT id, nome, foto FROM tb_itens WHERE idCategoria = 3;");
                    if($cmd) {
                        $cmd->execute();
                        $res = $cmd->get_result();

                        if($res->num_rows > 0) {
                            while ($linha = $res->fetch_assoc()) {
                                echo '<div class="item">';
                                echo '<img class="imagens" src="' . htmlspecialchars($linha['foto']) . '" alt="' . htmlspecialchars($linha['nome']) . '">';
                                echo '<p>' . htmlspecialchars($linha['nome']) . '</p>';
                                echo '<a class="detalhes-link" href="detalhes.php?id=' . $linha['id'] . '">Ver Detalhes</a>';
                                echo '</div>';
                            }
                        }
                    }
                ?>
            </div>
            <a class = "sair" href="logout.php">Sair</a>
        </div>
    </div>
</body>
</html>