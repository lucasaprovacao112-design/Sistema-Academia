<?php
// =========================================================
// ARQUIVO: listar-matriculas.php
// FUNÇÃO: Listar matrículas com JOIN nas tabelas de Alunos e Planos
// =========================================================

// A variável $conn (conexão) é assumida como inclusa pelo index.php.

$sql = "SELECT 
            m.MatriculaID,
            a.Nome AS NomeAluno,
            a.AlunoID,
            p.NomePlano AS NomeDoPlano,
            p.PlanoID,
            m.DataContratacao,
            m.DataExpiracao,
            m.ValorTotalPago
        FROM 
            Matriculas m
        JOIN 
            Alunos a ON a.AlunoID = m.AlunoID_FK
        JOIN 
            Planos p ON p.PlanoID = m.PlanoID_FK
        ORDER BY 
            m.DataContratacao DESC";

$res = $conn->query($sql);
$qtd = $res->num_rows;

if ($qtd === false) {
    echo "<div class='alert alert-danger'>ERRO na consulta: " . $conn->error . "</div>";
    exit();
}
?>

<h1>Matrículas Cadastradas</h1>
<p>Total de Matrículas: <?php print $qtd; ?></p>
<table class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Aluno</th>
            <th>Plano</th>
            <th>Contratação</th>
            <th>Expiração</th>
            <th>Valor Pago</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($qtd > 0) {
            while ($row = $res->fetch_object()) {
                // Formatação de valores e datas
                $valor_formatado = number_format($row->ValorTotalPago, 2, ',', '.');
                $data_contratacao = date("d/m/Y", strtotime($row->DataContratacao));
                $data_expiracao = date("d/m/Y", strtotime($row->DataExpiracao));
                
                print "<tr>";
                print "<td>" . $row->MatriculaID . "</td>";
                print "<td>" . $row->NomeAluno . "</td>";
                print "<td>" . $row->NomeDoPlano . "</td>";
                print "<td>" . $data_contratacao . "</td>";
                print "<td>" . $data_expiracao . "</td>";
                print "<td>R$ " . $valor_formatado . "</td>";
                
                // CORREÇÃO DO LINK DE EDIÇÃO E EXCLUSÃO
                print "<td>
                    <a href='?page=editar-matriculas&MatriculaID=" . $row->MatriculaID . "' 
                       class='btn btn-success btn-sm'>
                        Editar
                    </a>
                    <button onclick=\"if(confirm('Tem certeza que deseja excluir a matrícula do aluno " . $row->NomeAluno . "?')){location.href='?page=salvar-matriculas&acao=excluir&MatriculaID=" . $row->MatriculaID . "';}else{false;}\" 
                       class='btn btn-danger btn-sm'>
                        Excluir
                    </button>
                </td>";
                print "</tr>";
            }
        } else {
            print "<tr><td colspan='7'>Nenhuma matrícula cadastrada.</td></tr>";
        }
        ?>
    </tbody>
</table>