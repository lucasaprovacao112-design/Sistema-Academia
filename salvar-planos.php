<?php
// Inclui o arquivo de configuração e conexão com o banco de dados
include('config.php');

// Define a ação
switch(@$_REQUEST['acao']) {
    
    // --- 1. CADASTRO (INSERT) ---
    case 'cadastrar':
        $nomePlano = $_POST['NomePlano'];         
        $valorMensal = $_POST['ValorMensal'];
        $duracaoMeses = $_POST['DuracaoMeses']; 
        
        // SQL com 3 placeholders
        $sql = "INSERT INTO Planos (NomePlano, ValorMensal, DuracaoMeses) 
                 VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        // Bind dos parâmetros CORRIGIDO: s(Nome), d(Valor Mensal), i(Duracao Meses)
        $stmt->bind_param("sdi", $nomePlano, $valorMensal, $duracaoMeses);

        if($stmt->execute()) {
            print "<script>alert('Plano cadastrado com sucesso!');</script>";
        } else {
            print "<script>alert('Erro ao cadastrar plano: " . $stmt->error . "');</script>";
        }
        $stmt->close();
        print "<script>location.href='?page=listar-plano';</script>";
        break;

    // --- 2. EDIÇÃO (UPDATE) ---
    case 'editar':
        $nomePlano = $_POST['NomePlano'];
        $valorMensal = $_POST['ValorMensal'];
        $duracaoMeses = $_POST['DuracaoMeses'];
        $planoID = $_REQUEST['PlanoID'];
        
        $sql = "UPDATE Planos SET NomePlano = ?, ValorMensal = ?, DuracaoMeses = ? WHERE PlanoID = ?";

        $stmt = $conn->prepare($sql);
        
        // Bind dos parâmetros CORRIGIDO: s(Nome), d(Valor Mensal), i(Duracao Meses), i(PlanoID)
        // Usa "sdii" (4 tipos)
        $stmt->bind_param("sdii", $nomePlano, $valorMensal, $duracaoMeses, $planoID);

        if($stmt->execute()){
            print "<script>alert('Plano editado com sucesso!');</script>";
        } else {
            print "<script>alert('Não foi possível editar o plano. Erro: " . $stmt->error . "');</script>";
        }
        $stmt->close();
        print "<script>location.href='?page=listar-plano';</script>";
        break;

    // --- 3. EXCLUSÃO (DELETE) ---
    case 'excluir':
        $planoID = $_REQUEST['PlanoID'];

        $sql = "DELETE FROM Planos WHERE PlanoID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $planoID);

        if($stmt->execute()){
            print "<script>alert('Plano excluído com sucesso!');</script>";
        } else {
            print "<script>alert('Não foi possível excluir o plano. Erro: " . $stmt->error . "');</script>";
        }
        $stmt->close();
        print "<script>location.href='?page=listar-plano';</script>";
        break;
}
?>