<?php
    include "conexao.php";

    
    if (isset($_GET['id'])) {
        
        $id = intval($_GET['id']); 

        
        $cmd = $conn->prepare("SELECT * FROM tb_itens WHERE id = ?");
        $cmd->bind_param("i", $id); 
        $cmd->execute();
        $res = $cmd->get_result();

        if ($res->num_rows > 0) {
            
            $item = $res->fetch_assoc();
        } else {
            $item = null;
        }
    } else {
        $item = null;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menu.css">
    <title>Detalhes</title>
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
    </style>
</head>
<body>
    <div class="container">
        <a class ="menu" href="menu.php">Menu</a>
        <h1>Detalhes do Item</h1>
        <div class="containergeral">
            <?php if ($item): ?>
                <div class="image">
                    <img src="<?php echo htmlspecialchars($item['foto']); ?>" alt="<?php echo htmlspecialchars($item['nome']); ?>" width="200px">
                </div>
                <div class="details">
                    <h2><?php echo htmlspecialchars($item['nome']); ?></h2>
                    <p><strong>Descrição:</strong> <?php echo htmlspecialchars($item['descricao']); ?></p>
                    <p><strong>Preço:</strong> R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>

                    <form action="carrinho.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="nome" value="<?php echo htmlspecialchars($item['nome']); ?>">
                        <input type="hidden" name="preco" value="<?php echo $item['preco']; ?>">
                        <button type="submit" name="adicionar" value="1">Adicionar ao Pedido</button>
                    </form>
                </div>
            <?php else: ?>
                <p>Item não encontrado.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
