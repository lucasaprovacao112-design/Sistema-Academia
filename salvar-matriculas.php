<?php
// =========================================================
// ARQUIVO: salvar-matriculas.php
// FUNÇÃO: Processar as ações de cadastro, edição e exclusão de matrículas
// =========================================================

// Inclui o arquivo de conexão com o banco de dados
include('config.php');

switch (@$_REQUEST['acao']) {
    
    // --- 1. CADASTRO (INSERT) ---
    case 'cadastrar':
        $alunoFK = $_POST['AlunoID_FK']; 
        $planoFK = $_POST['PlanoID_FK']; 
        $dataContratacao = $_POST['DataContratacao']; 
        $dataExpiracao = $_POST['DataExpiracao']; 
        $valorTotalPago = $_POST['ValorTotalPago']; 

        $sql = "INSERT INTO Matriculas (AlunoID_FK, PlanoID_FK, DataContratacao, DataExpiracao, ValorTotalPago) 
                 VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        // Tipos: i(AlunoID), i(PlanoID), s(DataContratacao), s(DataExpiracao), d(ValorTotalPago - decimal)
        $stmt->bind_param("iissd", $alunoFK, $planoFK, $dataContratacao, $dataExpiracao, $valorTotalPago);

        if ($stmt->execute()) {
            print "<script>alert('Matrícula cadastrada com sucesso!');</script>";
        } else {
            print "<script>alert('Erro ao cadastrar matrícula: " . $conn->error . "');</script>";
        }
        
        $stmt->close();
        print "<script>location.href='?page=listar-matriculas';</script>";
        break;
    
    // --- 2. EDIÇÃO (UPDATE) - NOVO! ---
    case 'editar':
        // 1. Coleta os dados do formulário de edição
        $alunoFK = $_POST['AlunoID_FK'];        
        $planoFK = $_POST['PlanoID_FK'];        
        $dataContratacao = $_POST['DataContratacao'];  
        $dataExpiracao = $_POST['DataExpiracao']; 
        $valorTotalPago = $_POST['ValorTotalPago'];
        $matriculaID = $_POST['MatriculaID']; // ID da Matrícula a ser editada
        
        // 2. Comando SQL de UPDATE
        $sql = "UPDATE Matriculas 
                SET AlunoID_FK = ?, PlanoID_FK = ?, DataContratacao = ?, DataExpiracao = ?, ValorTotalPago = ? 
                WHERE MatriculaID = ?";

        $stmt = $conn->prepare($sql);
        
        // 3. Bind dos parâmetros: i(AlunoID), i(PlanoID), s(DataContratacao), s(DataExpiracao), d(ValorTotalPago), i(MatriculaID)
        // Total de 6 variáveis.
        $stmt->bind_param("iissdi", $alunoFK, $planoFK, $dataContratacao, $dataExpiracao, $valorTotalPago, $matriculaID);

        if($stmt->execute()){
            print "<script>alert('Matrícula editada com sucesso!');</script>";
        } else {
            print "<script>alert('Não foi possível editar a Matrícula. Erro: " . $stmt->error . "');</script>";
        }
        $stmt->close();
        print "<script>location.href='?page=listar-matriculas';</script>";
        break;

    // --- 3. EXCLUSÃO (DELETE) - NOVO! ---
    case 'excluir':
        $matriculaID = $_REQUEST['MatriculaID'];

        $sql = "DELETE FROM Matriculas WHERE MatriculaID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $matriculaID);

        if($stmt->execute()){
            print "<script>alert('Matrícula excluída com sucesso!');</script>";
        } else {
            // Pode falhar se o ID for inválido ou se houver outras FKs (improvável aqui, mas bom ter)
            print "<script>alert('Não foi possível excluir a Matrícula. Erro: " . $stmt->error . "');</script>";
        }
        $stmt->close();
        print "<script>location.href='?page=listar-matriculas';</script>";
        break;
        
    default:
        print "<script>location.href='?page=listar-matriculas';</script>";
        break;
}
?>