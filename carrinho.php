<?php
session_start();

// Verifica se a sessão de pedido existe, caso contrário, cria uma nova
if (!isset($_SESSION['pedido'])) {
    $_SESSION['pedido'] = [];
}

// Adicionar item ao carrinho
if (isset($_POST['adicionar'])) {
    $item = [
        'id' => $_POST['id'],
        'nome' => $_POST['nome'],
        'preco' => $_POST['preco']
    ];
    $_SESSION['pedido'][] = $item;
}

// Remover item do carrinho
if (isset($_POST['remover'])) {
    $index = $_POST['index'];
    if (isset($_SESSION['pedido'][$index])) {
        unset($_SESSION['pedido'][$index]);
        $_SESSION['pedido'] = array_values($_SESSION['pedido']);  // Reindexa os itens após remoção
    }
}

// Calcular o total do pedido
$total = 0;
foreach ($_SESSION['pedido'] as $item) {
    $total += $item['preco'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menu.css">
    <title>Carrinho de Compras</title>
</head>
<body>
    <div class="container">
        <a href="menu.php">Menu</a>
        <h1>Carrinho de Compras</h1>

        <!-- Se o carrinho não estiver vazio, exibe os itens -->
        <?php if (count($_SESSION['pedido']) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome do Item</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['pedido'] as $index => $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nome']); ?></td>
                            <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                            <td>1</td> <!-- Supondo quantidade 1 para cada item -->
                            <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                            <td>
                                <!-- Formulário para remover o item -->
                                <form action="carrinho.php" method="POST">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <input type="hidden" name="remover" value="1">
                                    <button type="submit">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p><strong>Total:</strong> R$ <?php echo number_format($total, 2, ',', '.'); ?></p>

            <a href="finalizar_pedido.php">
                <button>Finalizar Pedido</button>
            </a>
        <?php else: ?>
            <p>Seu carrinho está vazio.</p>
        <?php endif; ?>
    
<!-- <h2>Adicionar Item ao Carrinho</h2>
        -- Formulário para adicionar um item (exemplo) 
        <form action="carrinho.php" method="POST">
            <input type="hidden" name="id" value="1">
            <input type="hidden" name="nome" value="Item Exemplo">
            <input type="hidden" name="preco" value="99.90">
            <button type="submit" name="adicionar" value="1">Adicionar ao Carrinho</button>
        </form>
        -->
    </div>
</body>
</html>
