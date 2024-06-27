<!DOCTYPE html>
<html>

<head>
  <!-- Define o título da página e inclui os arquivos CSS necessários -->
  <title>Agenda de contatos</title>
  <link rel="stylesheet" type="text/css" href="src/css/estilo.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <!-- Cabeçalho da página -->
  <div id="header">
    <h1>Agenda de Contatos</h1>
  </div>

  <!-- Conteúdo principal da página -->
  <div id="content">
    <h2>Contatos</h2>
    <table border="1">
      <thead>
        <!-- Cabeçalho da tabela de contatos -->
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th>Telefone</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Inclui o script PHP que obtém os contatos
        include 'src/getContacts.php';

        // Verifica se há contatos e os exibe na tabela
        if (!empty($contatos)) {
            foreach ($contatos as $contato) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($contato['nome']) . "</td>";
                echo "<td>" . htmlspecialchars($contato['email']) . "</td>";
                echo "<td>" . htmlspecialchars($contato['telefone']) . "</td>";
                echo "<td>
                      <!-- Botões para editar e deletar contatos -->
                      <button class='edit-button' onclick=\"openEditModal('" . htmlspecialchars($contato['id']) . "', '" . htmlspecialchars($contato['nome']) . "', '" . htmlspecialchars($contato['email']) . "', '" . htmlspecialchars($contato['telefone']) . "')\"><i class='fas fa-edit'></i></button>
                      <button class='delete-button' onclick=\"confirmDelete('" . htmlspecialchars($contato['id']) . "')\"><i class='fas fa-trash'></i></button>
                    </td>";
                echo "</tr>";
            }
        }
        ?>
      </tbody>
    </table>

    <h2>Adicionar Novo Contato</h2>
    <!-- Botão para abrir o modal de adicionar contato -->
    <button class="add-contact-button" id="myBtn">Adicionar Contato</button>
  </div>

  <!-- Modal para adicionar um novo contato -->
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <form action="src/createContact.php" method="POST">
        <!-- Campos do formulário para adicionar um novo contato -->
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required>
        <input type="submit" value="Adicionar Contato">
      </form>
    </div>
  </div>

  <!-- Modal para editar um contato existente -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close-edit">&times;</span>
      <form id="editForm" action="src/updateContact.php" method="POST">
        <!-- Campos do formulário para editar um contato -->
        <input type="hidden" id="edit_id" name="id">
        <label for="edit_nome">Nome:</label>
        <input type="text" id="edit_nome" name="nome" required>
        <label for="edit_email">Email:</label>
        <input type="email" id="edit_email" name="email" required>
        <label for="edit_telefone">Telefone:</label>
        <input type="text" id="edit_telefone" name="telefone" required>
        <input type="submit" value="Atualizar Contato">
      </form>
    </div>
  </div>

  <!-- Script JavaScript para manipulação dos modais -->
  <script>
    // Variáveis que referenciam os modais
    var modal = document.getElementById("myModal");
    var editModal = document.getElementById("editModal");

    // Botão que abre o modal de adicionar contato
    var btn = document.getElementById("myBtn");

    // Span que fecha o modal de adicionar contato
    var span = document.getElementsByClassName("close")[0];
    // Span que fecha o modal de editar contato
    var spanEdit = document.getElementsByClassName("close-edit")[0];

    // Função para abrir o modal de adicionar contato
    btn.onclick = function() {
      modal.style.display = "block";
    }

    // Função para fechar o modal de adicionar contato
    span.onclick = function() {
      modal.style.display = "none";
    }

    // Função para fechar o modal de editar contato
    spanEdit.onclick = function() {
      editModal.style.display = "none";
    }

    // Função para fechar os modais ao clicar fora deles
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      } else if (event.target == editModal) {
        editModal.style.display = "none";
      }
    }

    // Função para abrir o modal de editar contato com os dados do contato
    function openEditModal(id, nome, email, telefone) {
      document.getElementById("edit_id").value = id;
      document.getElementById("edit_nome").value = nome;
      document.getElementById("edit_email").value = email;
      document.getElementById("edit_telefone").value = telefone;
      editModal.style.display = "block";
    }

    // Função para confirmar a exclusão de um contato
    function confirmDelete(id) {
      if (confirm("Tem certeza que deseja excluir este contato?")) {
        window.location.href = "src/deleteContact.php?id=" + id;
      }
    }
  </script>
</body>

</html>
