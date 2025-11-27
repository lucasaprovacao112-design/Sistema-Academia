<?php
// =========================================================
// ARQUIVO: cadastrar-aluno.php
// FUNÇÃO: Formulário completo de cadastro de alunos
// =========================================================

// ⚠️ Se este arquivo for carregado fora do index.php, inclua a conexão:
// include('config.php'); 

// Busca os planos para popular o SELECT (necessário para a Foreign Key)
$sql_planos = "SELECT PlanoID, NomePlano FROM planos ORDER BY NomePlano ASC";
$res_planos = $conn->query($sql_planos);

if ($res_planos === false) {
    echo "<div class='alert alert-danger'>ERRO ao carregar planos: " . $conn->error . "</div>";
}
?>

<h1>Cadastrar Aluno</h1>
<form action="?page=salvar-aluno" method="POST">
    <input type="hidden" name="acao" value="cadastrar">
    
    <div class="mb-3">
        <label>Nome do Aluno</label>
        <input type="text" name="Nome" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label>CPF</label>
        <input type="text" name="CPF" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="Email" class="form-control">
    </div>

    <div class="mb-3">
        <label>Telefone</label>
        <input type="text" name="Telefone" class="form-control">
    </div>
    
    <div class="mb-3">
        <label>Data de Nascimento</label>
        <input type="date" name="DataNascimento" class="form-control">
    </div>

    <div class="mb-3">
        <label for="plano_select">Plano Contratado</label>
        <select name="id_plano" id="plano_select" class="form-control"> 
            <option value="">Selecione um Plano (Opcional)</option>
            <?php
            if ($res_planos && $res_planos->num_rows > 0) {
                while($row_plano = $res_planos->fetch_object()) {
                    print "<option value='{$row_plano->PlanoID}'>{$row_plano->NomePlano}</option>";
                }
            } else {
                 print "<option value='' disabled>Nenhum plano cadastrado.</option>";
            }
            ?>
        </select>
        <small class="form-text text-muted">A coluna 'id_plano' na tabela alunos deve aceitar NULL.</small>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
</form>