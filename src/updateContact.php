<?php
// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário e sanitiza a entrada
    $id = htmlspecialchars($_POST['id']); // Obtém e sanitiza o ID
    $nome = htmlspecialchars($_POST['nome']); // Obtém e sanitiza o nome
    $email = htmlspecialchars($_POST['email']); // Obtém e sanitiza o email
    $telefone = htmlspecialchars($_POST['telefone']); // Obtém e sanitiza o telefone

    // Valida os dados para garantir que não estão vazios
    if (!empty($id) && !empty($nome) && !empty($email) && !empty($telefone)) {
        // Dados de conexão com o banco de dados PostgreSQL
        $dsn = "pgsql:host=localhost;port=5432;dbname=list_contact_paper;";
        $username = "rafael"; // Nome de usuário para a conexão com o banco de dados
        $password = "senha"; // Senha para a conexão com o banco de dados

        try {
            // Tenta criar uma nova instância de PDO para se conectar ao banco de dados
            $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            // Prepara uma consulta SQL para atualizar os dados do contato com o ID fornecido
            $sql = "UPDATE contatos SET nome = ?, email = ?, telefone = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);

            // Executa a consulta passando os parâmetros do formulário
            $stmt->execute([$nome, $email, $telefone, $id]);

            // Redireciona de volta para a página principal após a atualização
            header("Location: ../index.php");
            exit(); // Garante que o script seja interrompido após o redirecionamento
        } catch (PDOException $e) {
            // Captura e exibe qualquer erro que ocorra durante a conexão ou execução da consulta
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
        }
    } else {
        // Exibe uma mensagem de erro se algum campo obrigatório estiver vazio
        echo "Todos os campos obrigatórios (nome, email, telefone) devem ser preenchidos!";
    }
} else {
    // Exibe uma mensagem de erro se o método de requisição não for POST
    echo "Método de requisição inválido!";
}
?>
