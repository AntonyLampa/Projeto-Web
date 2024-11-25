<?php
    include "conexao.php";

    // Verifica se o parâmetro 'id' foi passado na URL
    if (isset($_GET['id'])) {
        // Sanitiza o id para evitar problemas de segurança
        $id = intval($_GET['id']); 

        // Consulta no banco de dados para pegar os detalhes do item
        $cmd = $conn->prepare("SELECT * FROM tb_itens WHERE id = ?");
        $cmd->bind_param("i", $id); // "i" significa integer
        $cmd->execute();
        $res = $cmd->get_result();

        if ($res->num_rows > 0) {
            // Caso o item exista, podemos pegar os dados
            $item = $res->fetch_assoc();
        } else {
            // Caso o item não exista
            $item = null;
        }
    } else {
        // Caso o parâmetro 'id' não seja passado na URL
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
</head>
<body>
    <div class="container">
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
                </div>
            <?php else: ?>
                <p>Item não encontrado.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
