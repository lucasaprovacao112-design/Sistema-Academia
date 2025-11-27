<?php
// =========================================================
// ARQUIVO: cadastrar-matriculas.php
// FUNÇÃO: Exibir o formulário e preencher as listas suspensas
// =========================================================

// ⚠️ ASSUME-SE QUE O ARQUIVO 'config.php' COM A CONEXÃO ($conn) ESTÁ INCLUÍDO ANTERIORMENTE.
// Se for um arquivo autônomo, descomente a linha abaixo:
// include('config.php');

// --- 1. BUSCA DE ALUNOS ---
$sql_alunos = "SELECT AlunoID, Nome FROM Alunos ORDER BY Nome ASC";
$res_alunos = $conn->query($sql_alunos);

if ($res_alunos === false) {
    echo "<div class='alert alert-danger'>ERRO ao carregar alunos: " . $conn->error . "</div>";
}

// --- 2. BUSCA DE PLANOS ---
$sql_planos = "SELECT PlanoID, NomePlano, ValorMensal FROM Planos ORDER BY NomePlano ASC";
$res_planos = $conn->query($sql_planos);

if ($res_planos === false) {
    echo "<div class='alert alert-danger'>ERRO ao carregar planos: " . $conn->error . "</div>";
}
?>

<script>
    /**
     * Função JavaScript para preencher automaticamente o Valor Total Pago
     * com base no Plano selecionado.
     */
    function preencherValorTotal() {
        const selectPlano = document.getElementById('plano_select');
        const inputValor = document.getElementById('valor_total_pago');
        
        const selectedOption = selectPlano.options[selectPlano.selectedIndex];
        
        // Pega o valor do atributo 'data-valor'
        const valorPlano = selectedOption.getAttribute('data-valor');
        
        // Define o Valor Total Pago
        inputValor.value = valorPlano || 0.00; 
    }
</script>

<h1>Cadastrar matrículas</h1>
<form action="?page=salvar-matriculas" method="POST">
    <input type="hidden" name="acao" value="cadastrar">
    
    <div class="mb-3">
        <label for="aluno_select">Aluno</label>
        <select name="AlunoID" id="aluno_select" class="form-control" required>
            <option value="">Selecione um Aluno</option>
            <?php
            // LOOP PARA PREENCHER ALUNOS
            if ($res_alunos && $res_alunos->num_rows > 0) {
                while($row_aluno = $res_alunos->fetch_object()) {
                    print "<option value='{$row_aluno->AlunoID}'>{$row_aluno->Nome}</option>";
                }
            } else {
                print "<option value='' disabled>Nenhum aluno cadastrado.</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="plano_select">Plano</label>
        <select name="PlanoID" id="plano_select" class="form-control" onchange="preencherValorTotal()" required>
            <option value="">Selecione um Plano</option>
            <?php
            // LOOP PARA PREENCHER PLANOS
            if ($res_planos && $res_planos->num_rows > 0) {
                while($row_plano = $res_planos->fetch_object()) {
                    $valor_formatado = number_format($row_plano->ValorMensal, 2, ',', '.');
                    print "<option value='{$row_plano->PlanoID}' data-valor='{$row_plano->ValorMensal}'>";
                    print "{$row_plano->NomePlano} (R$ {$valor_formatado}/mês)";
                    print "</option>";
                }
            } else {
                 print "<option value='' disabled>Nenhum plano cadastrado.</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Data de Contratação</label>
        <input type="date" name="dataContratacao_matriculas" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label>Data de Expiração</label>
        <input type="date" name="dataexpiracao_matriculas" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label>Valor total pago</label>
        <input type="number" name="valortotalpago_matriculas" id="valor_total_pago" class="form-control" step="0.01" required>
    </div>
    
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
</form>