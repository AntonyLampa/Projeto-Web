<?php
session_start();


if (!isset($_SESSION['pedido'])) {
    $_SESSION['pedido'] = [];
}


if (isset($_POST['adicionar'])) {
    $item = [
        'id' => $_POST['id'],
        'nome' => $_POST['nome'],
        'preco' => $_POST['preco'],
        'quantidade' => 1 
    ];

    
    $item_encontrado = false;
    foreach ($_SESSION['pedido'] as &$produto) {
        if ($produto['id'] == $item['id']) {
            $produto['quantidade']++; 
            $item_encontrado = true;
            break;
        }
    }

    
    if (!$item_encontrado) {
        $_SESSION['pedido'][] = $item;
    }
}


if (isset($_POST['aumentar'])) {
    $index = $_POST['index'];
    $_SESSION['pedido'][$index]['quantidade']++; 
}


if (isset($_POST['diminuir'])) {
    $index = $_POST['index'];
    if ($_SESSION['pedido'][$index]['quantidade'] > 1) {
        $_SESSION['pedido'][$index]['quantidade']--; 
    }
}


if (isset($_POST['remover'])) {
    $index = $_POST['index'];
    if (isset($_SESSION['pedido'][$index])) {
        unset($_SESSION['pedido'][$index]);
        $_SESSION['pedido'] = array_values($_SESSION['pedido']);  
    }
}


$total = 0;
foreach ($_SESSION['pedido'] as $item) {
    $total += $item['preco'] * $item['quantidade']; 
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menu.css">
    <title>Carrinho de Compras</title>
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
        <a class = "menu" href="menu.php">Menu</a>
        <h1>Carrinho de Compras</h1>

        <div class="containergeral">
        
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
                            <td>
                                <form action="carrinho.php" method="POST" style="display:inline;">
                                    <button type="submit" name="diminuir" value="1">-</button>
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <?php echo $item['quantidade']; ?>
                                    <button type="submit" name="aumentar" value="1">+</button>
                                </form>
                            </td>
                            <td>R$ <?php echo number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?></td>
                            <td>
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

            <a href="finalizarPedido.php">
                <button>Finalizar Pedido</button>
            </a>
        <?php else: ?>
            <p>Seu carrinho está vazio.</p>
        <?php endif; ?>
        </div>
    </div>
</body>
</html>
