<?php
// Verifica se o parâmetro 'id' foi fornecido na URL via GET
if (isset($_GET['id'])) {
    // Obtém o ID do contato a ser excluído e sanitiza a entrada
    $id = htmlspecialchars($_GET['id']);

    // Dados de conexão com o banco de dados PostgreSQL
    $dsn = "pgsql:host=localhost;port=5432;dbname=list_contact_paper;";
    $username = "rafael"; // Nome de usuário para a conexão com o banco de dados
    $password = "senha"; // Senha para a conexão com o banco de dados

    try {
        // Tenta criar uma nova instância de PDO para se conectar ao banco de dados
        $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Prepara uma consulta SQL para excluir o contato com o ID fornecido
        $sql = "DELETE FROM contatos WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        // Executa a consulta passando o ID do contato como parâmetro
        $stmt->execute([$id]);

        // Redireciona de volta para a página principal após a exclusão
        header("Location: ../index.php");
        exit(); // Garante que o script seja interrompido após o redirecionamento
    } catch (PDOException $e) {
        // Captura e exibe qualquer erro que ocorra durante a conexão ou execução da consulta
        echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    }
} else {
    // Exibe uma mensagem de erro se o ID do contato não for fornecido
    echo "ID do contato não fornecido!";
}
?>
