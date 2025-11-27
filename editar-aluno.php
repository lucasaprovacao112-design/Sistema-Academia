<?php
// =========================================================
// ARQUIVO: editar-aluno.php
// FUNÇÃO: Busca o aluno, busca os planos e exibe o formulário pré-preenchido
// =========================================================

// ⚠️ Se este arquivo não for carregado dentro de um índice que já inclua a conexão,
// DESCOMENTE a linha abaixo para incluir o arquivo de configuração e conexão com o banco de dados.
// include('config.php'); 

// --- 1. BUSCA E VALIDAÇÃO DO ID DO ALUNO (CORREÇÃO DE UNDEFINED KEY) ---
// Tenta buscar o ID usando 'id' (parâmetro comum na URL) ou 'id_aluno'
$aluno_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : (isset($_REQUEST['id_aluno']) ? $_REQUEST['id_aluno'] : null);

// Validação crucial para evitar o erro Fatal Error SQL
if (empty($aluno_id) || !is_numeric($aluno_id)) {
    echo "<div class='alert alert-danger'>Erro: ID do aluno não fornecido ou inválido.</div>";
    echo "<script>location.href='?page=listar-alunos';</script>";
    exit;
}

// --- 2. BUSCA DO ALUNO ESPECÍFICO ---
// ⚠️ ATENÇÃO: Verifique se o nome da chave primária na sua tabela é 'AlunoID'
$sql = "SELECT * FROM alunos WHERE AlunoID = $aluno_id";
$res = $conn->query($sql);

if ($res === false || $res->num_rows === 0) {
    echo "<div class='alert alert-danger'>Aluno não encontrado ou erro na consulta: " . $conn->error . "</div>";
    echo "<script>location.href='?page=listar-alunos';</script>";
    exit;
}

// 🟢 Agora $row está definido corretamente (CORREÇÃO DE UNDEFINED VARIABLE $row)
$row = $res->fetch_object();


// --- 3. BUSCA DE PLANOS (CORREÇÃO DE UNDEFINED VARIABLE $res_planos) ---
$sql_planos = "SELECT PlanoID, NomePlano FROM planos ORDER BY NomePlano ASC";
$res_planos = $conn->query($sql_planos);

if ($res_planos === false) {
    echo "<div class='alert alert-danger'>ERRO ao carregar planos: " . $conn->error . "</div>";
}
?>

<h1>Editar Aluno: <?php print $row->Nome; ?></h1>
<form action="?page=salvar-aluno" method="POST">
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="AlunoID" value="<?php print $row->AlunoID; ?>"> 
    
    <div class="mb-3">
        <label>Nome do Aluno</label>
        <input type="text" name="Nome" class="form-control" value="<?php print $row->Nome; ?>" required>
    </div>
    
    <div class="mb-3">
        <label>CPF</label>
        <input type="text" name="CPF" class="form-control" value="<?php print $row->CPF; ?>" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="Email" class="form-control" value="<?php print $row->Email; ?>">
    </div>

    <div class="mb-3">
        <label>Telefone</label>
        <input type="text" name="Telefone" class="form-control" value="<?php print $row->Telefone; ?>">
    </div>
    
    <div class="mb-3">
        <label>Data de Nascimento</label>
        <input type="date" name="DataNascimento" class="form-control" value="<?php print $row->DataNascimento; ?>">
    </div>

    <div class="mb-3">
        <label for="plano_select">Plano Contratado</label>
        <select name="id_plano" id="plano_select" class="form-control"> 
            <option value="">Selecione um Plano (Opcional)</option>
            <?php
            // 🟢 Verifica se a busca de planos foi bem-sucedida
            if ($res_planos && $res_planos->num_rows > 0) {
                while($row_plano = $res_planos->fetch_object()) {
                    // Seleciona o plano atual do aluno
                    $selected = ($row_plano->PlanoID == $row->id_plano) ? 'selected' : '';
                    print "<option value='{$row_plano->PlanoID}' {$selected}>{$row_plano->NomePlano}</option>";
                }
            } else {
                 print "<option value='' disabled>Nenhum plano cadastrado.</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-success">Salvar Alterações</button>
    </div>
</form>