<?php
session_start();  // Inicia a sessão

// Inclui a conexão com o banco de dados
include('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "Você precisa estar logado para finalizar o pedido.";
    // Ou redirecionar para a página de login
    header("Location: index.php");
    exit();
}

// Verifica se o pedido existe na sessão
if (isset($_SESSION['pedido']) && !empty($_SESSION['pedido'])) {
    // Obtém o ID do usuário logado
    $idUsuario = $_SESSION['usuario_id'];  // O ID do usuário logado

    // Começa a transação para garantir integridade dos dados
    $conn->begin_transaction();

    try {
        // Insere os itens do pedido na tabela tb_itens_pedido
        foreach ($_SESSION['pedido'] as $item) {
            $idItem = $item['id'];  // ID do item
            $quantidade = $item['quantidade'];  // Quantidade
            $preco = $item['preco'];  // Preço do item

            // Preparando a query para inserir o pedido na tabela tb_itens_pedido
            $sql = "INSERT INTO tb_itens_pedido (idUsuario, idItem, quantidade, preco, finalizado) 
                    VALUES (?, ?, ?, ?, 1)";  // finalizado é 0 (não finalizado)

            // Usando prepared statements para evitar SQL injection
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiii", $idUsuario, $idItem, $quantidade, $preco);
            $stmt->execute();
        }

        // Se tudo correu bem, confirma a transação
        $conn->commit();

        // Limpar o pedido da sessão após o registro
        $_SESSION['pedido'] = [];

        // Redireciona o usuário para uma página de confirmação ou menu
        header("Location: confirmacao.php");
        exit;
    } catch (Exception $e) {
        // Caso ocorra algum erro, faz o rollback da transação
        $conn->rollback();
        echo "Erro ao finalizar o pedido: " . $e->getMessage();
    }
} else {
    echo "Seu carrinho está vazio.";
}
?>
