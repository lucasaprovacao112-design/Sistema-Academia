<h1 class="mt-4">Listar Planos</h1>
<hr>

<?php
    // Assume-se que a conexão ($conn) já foi incluída pelo index.php

    $sql = "SELECT * FROM Planos";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
?>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Nome do Plano</th>
                    <th>Valor Mensal</th>
                    <th>Duração (Meses)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = $res->fetch_object()) {
                        print "<tr>";
                        print "<td>" . $row->PlanoID . "</td>";
                        print "<td>" . $row->NomePlano . "</td>";
                        print "<td>R$ " . number_format($row->ValorMensal, 2, ',', '.') . "</td>";
                        print "<td>" . $row->DuracaoMeses . "</td>";
                        
                        // CORREÇÃO CRÍTICA: Link de Edição usa 'id_planos'
                        print "<td>
                                <a href='?page=editar-planos&id_planos=" . $row->PlanoID . "' 
                                   class='btn btn-success btn-sm me-1'>
                                    Editar
                                </a>
                                
                                <button onclick=\"if(confirm('Tem certeza que deseja excluir o Plano " . $row->NomePlano . "?')){location.href='?page=salvar-planos&acao=excluir&PlanoID=" . $row->PlanoID . "';}else{false;}\"
                                   class='btn btn-danger btn-sm'>
                                    Excluir
                                </button>
                               
                            </td>";
                        print "</tr>";
                    }
                ?>
            </tbody>
        </table>

<?php
    } else {
        print "<p class='alert alert-warning'>Nenhum plano cadastrado!</p>";
    }
?>