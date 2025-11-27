<h1>Editar planos</h1>

<?php
// A conexão ($conn) deve estar ativa antes deste ponto.

// 1. Inicializa a variável do ID
$planoID = 0;

// 2. Tenta obter o ID do plano de forma flexível (id_planos OU PlanoID)
if (isset($_REQUEST['id_planos']) && is_numeric($_REQUEST['id_planos'])) {
    $planoID = $_REQUEST['id_planos'];
} elseif (isset($_REQUEST['PlanoID']) && is_numeric($_REQUEST['PlanoID'])) {
    $planoID = $_REQUEST['PlanoID']; 
}

// 3. Verifica se um ID válido foi encontrado
if ($planoID == 0) {
    echo "<div class='alert alert-danger'>ERRO: ID do plano inválido ou ausente na URL.</div>";
    exit;
}

// 4. Consulta SQL usando placeholder (?)
$sql = "SELECT * FROM Planos WHERE PlanoID = ?";

$stmt = $conn->prepare($sql);

// Vincula o parâmetro (i = integer) usando a variável $planoID
$stmt->bind_param("i", $planoID); 

$stmt->execute();
$res = $stmt->get_result();
$stmt->close();

if ($res->num_rows == 0) {
    echo "<div class='alert alert-danger'>Plano não encontrado no banco de dados.</div>";
    exit;
}

$row = $res->fetch_object();
?>

<form action="?page=salvar-planos" method="POST">
    <input type="hidden" name="acao" value="editar">
    <input type="hidden" name="PlanoID" value="<?php print $row->PlanoID; ?>"> 
    
    <div class="mb-3">
        <label>Nome do Plano</label>
        <input type="text" name="NomePlano" class="form-control" value="<?php print $row->NomePlano; ?>" required>
    </div>
    
    <div class="mb-3">
        <label>Valor Mensal</label>
        <input type="number" step="0.01" name="ValorMensal" class="form-control" value="<?php print $row->ValorMensal; ?>" required>
    </div>
    
    <div class="mb-3">
        <label>Duração Meses</label>
        <input type="number" name="DuracaoMeses" class="form-control" value="<?php print $row->DuracaoMeses; ?>" required>
    </div>
    
    <div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </div>
</form>