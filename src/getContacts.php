<?php
// Definir os dados de conexão com o banco de dados PostgreSQL
$dsn = "pgsql:host=localhost;port=5432;dbname=list_contact_paper;"; // Data Source Name contendo o host, a porta e o nome do banco de dados
$username = "rafael"; // Nome de usuário para a conexão com o banco de dados
$password = "senha"; // Senha para a conexão com o banco de dados

try {
    // Tentar criar uma nova instância de PDO (PHP Data Objects) para se conectar ao banco de dados
    $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Preparar uma consulta SQL para buscar todos os contatos na tabela "contatos"
    $sql = "SELECT id, nome, email, telefone FROM contatos";
    $stmt = $pdo->prepare($sql);

    // Executar a consulta preparada
    $stmt->execute();

    // Buscar todos os resultados da consulta e armazenar no array $contatos
    $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Capturar qualquer exceção (erro) que ocorrer durante a conexão ou execução da consulta e exibir a mensagem de erro
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    $contatos = []; // Definir $contatos como um array vazio se ocorrer um erro
}
?>
