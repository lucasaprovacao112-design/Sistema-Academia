<h1>Editar Matrícula</h1>

<?php
// A variável $conn (conexão) é assumida como inclusa pelo index.php.

// --- 1. Busca e Validação do ID da Matrícula ---
$matriculaID = 0;

// Tenta obter o ID do link (usando o nome de parâmetro corrigido: MatriculaID)
if (isset($_REQUEST['MatriculaID']) && is_numeric($_REQUEST['MatriculaID'])) {
    $matriculaID = $_REQUEST['MatriculaID'];
} 

if ($matriculaID == 0) {
    echo "<div class='alert alert-danger'>ERRO: ID da Matrícula inválido ou ausente na URL.</div>";
    exit;
}

// Prepara e executa a consulta para a Matrícula
$sql_matricula = "SELECT * FROM Matriculas WHERE MatriculaID = ?";
$stmt_matricula = $conn->prepare($sql_matricula);
$stmt_matricula->bind_param("i", $matriculaID); 
$stmt_matricula->execute();
$res_matricula = $stmt_matricula->get_result();
$stmt_matricula->close();

if ($res_matricula->num_rows == 0) {
    echo "<div class='alert alert-danger'>Matrícula (ID: {$matriculaID}) não encontrada.</div>";
    exit;
}

$dados_matricula = $res_matricula->fetch_object();

// --- 2. Busca de Alunos e Planos para Dropdowns ---

// Busca todos os alunos
$sql_alunos = "SELECT AlunoID, Nome FROM Alunos ORDER BY Nome";
$res_alunos = $conn->query($sql_alunos);

// Busca todos os planos
$sql_planos = "SELECT PlanoID, NomePlano FROM Planos ORDER BY NomePlano";
$res_planos = $conn->query($sql_planos);
?>

<form action="?page=salvar-matriculas" method="POST">
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="MatriculaID" value="<?php print $dados_matricula->MatriculaID; ?>"> 
    
    <div class="mb-3">
        <label for="AlunoID_FK" class="form-label">Aluno</label>
        <select name="AlunoID_FK" id="AlunoID_FK" class="form-select" required>
            <?php
            if ($res_alunos->num_rows > 0) {
                while($aluno = $res_alunos->fetch_object()) {
                    $selected = ($aluno->AlunoID == $dados_matricula->AlunoID_FK) ? 'selected' : '';
                    print "<option value='{$aluno->AlunoID}' {$selected}>{$aluno->Nome}</option>";
                }
            } else {
                print "<option value=''>Nenhum aluno cadastrado</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="PlanoID_FK" class="form-label">Plano</label>
        <select name="PlanoID_FK" id="PlanoID_FK" class="form-select" required>
            <?php
            if ($res_planos->num_rows > 0) {
                while($plano = $res_planos->fetch_object()) {
                    $selected = ($plano->PlanoID == $dados_matricula->PlanoID_FK) ? 'selected' : '';
                    print "<option value='{$plano->PlanoID}' {$selected}>{$plano->NomePlano}</option>";
                }
            } else {
                print "<option value=''>Nenhum plano cadastrado</option>";
            }
            ?>
        </select>
    </div>
    
    <div class="mb-3">
        <label for="DataContratacao" class="form-label">Data de Início</label>
        <input type="date" name="DataContratacao" id="DataContratacao" class="form-control" 
               value="<?php print $dados_matricula->DataContratacao; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="DataExpiracao" class="form-label">Data de Expiração</label>
        <input type="date" name="DataExpiracao" id="DataExpiracao" class="form-control" 
               value="<?php print $dados_matricula->DataExpiracao; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="ValorTotalPago" class="form-label">Valor Total Pago</label>
        <input type="number" step="0.01" name="ValorTotalPago" id="ValorTotalPago" class="form-control" 
               value="<?php print $dados_matricula->ValorTotalPago; ?>" required>
    </div>
    
    <div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </div>
</form>