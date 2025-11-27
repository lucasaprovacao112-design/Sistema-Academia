<?php
// Inclui o arquivo de configuração e conexão
include('config.php');

// 1. Comando SQL para buscar todos os alunos
// Colunas: AlunoID, Nome, CPF, DataNascimento, Email, Telefone
$sql = "SELECT * FROM Alunos"; 
$res = $conn->query($sql);

if ($res === false) {
    // Bloco de diagnóstico de erro SQL, caso a tabela 'Alunos' não exista
    print "<div class='alert alert-danger'>Erro ao consultar alunos. Verifique o nome da tabela no MySQL. Detalhe: " . $conn->error . "</div>";
    exit();
}

$qtd = $res->num_rows;
?>

<h1>Listar Alunos (<?php print $qtd; ?>)</h1>

<?php if ($qtd > 0): ?>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>Data de Nascimento</th>
                <th>Plano</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $res->fetch_object()): ?>
            <tr>
                <!-- CORREÇÃO APLICADA: Usando os nomes das colunas PascalCase do SQL -->
                <td><?php print $row->AlunoID; ?></td>
                <td><?php print $row->Nome; ?></td>
                <td><?php print $row->Email; ?></td>
                <td><?php print $row->Telefone; ?></td>
                <td><?php print $row->CPF; ?></td>
                <td><?php print $row->DataNascimento; ?></td>
                 <td><?php print $row->id_plano; ?></td>
                <td>
                    <!-- Os IDs de edição e exclusão também usam AlunoID -->
                    <button onclick="location.href='?page=editar-aluno&id=<?php print $row->AlunoID; ?>';" 
                            class="btn btn-warning btn-sm">Editar</button>
                    
                    <button onclick="if(confirm('Tem certeza que deseja excluir o aluno <?php print $row->Nome; ?>?')){location.href='?page=salvar-aluno&acao=excluir&id=<?php print $row->AlunoID; ?>';}else{false;}" 
                            class="btn btn-danger btn-sm">Excluir</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info" role="alert">
        Nenhum aluno cadastrado.
    </div>
<?php endif; ?>