<?php
// =========================================================
// ARQUIVO: salvar-aluno.php
// FUNÇÃO: Processar cadastro, edição e exclusão de alunos
// =========================================================

// Inclui o arquivo de configuração e conexão com o banco de dados
include('config.php');

// Define a ação
switch (@$_REQUEST['acao']) {
    case 'cadastrar':
        
        // 1. Recebe os dados
        $nome = $_POST['Nome'];
        $cpf = $_POST['CPF'];
        $email = $_POST['Email'];
        $telefone = $_POST['Telefone'];
        $dataNascimento = $_POST['DataNascimento'];
        $idPlano = isset($_POST['id_plano']) ? $_POST['id_plano'] : null;

        // 2. Trata o idPlano: Se vazio (''), define como NULL (necessário para a FK)
        $idPlano_para_db = empty($idPlano) ? NULL : $idPlano;

        // 3. Validação básica
        if (empty($nome) || empty($cpf)) {
             print "<script>alert('Nome e CPF são campos obrigatórios!');</script>";
             print "<script>location.href='?page=cadastrar-aluno';</script>";
             exit;
        }

        // 4. Constrói a consulta SQL para INSERÇÃO (7 colunas)
        $sql = "INSERT INTO alunos (Nome, CPF, Email, Telefone, DataNascimento, id_plano) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        // 5. Bind dos parâmetros: 5 strings + 1 integer para id_plano
        $stmt->bind_param("sssssi", $nome, $cpf, $email, $telefone, $dataNascimento, $idPlano_para_db);

        if ($stmt->execute()) {
            print "<script>alert('Aluno cadastrado com sucesso!');</script>";
        } else {
            print "<script>alert('Erro ao cadastrar aluno. Detalhe: " . $stmt->error . "');</script>";
        }
        
        $stmt->close();
        print "<script>location.href='?page=listar-alunos';</script>";
        break;
        
    case 'editar':
        // 1. Recebe os dados do formulário (NOMES CORRIGIDOS)
        $idAluno = $_POST['AlunoID']; // ID do aluno a ser atualizado
        $nome = $_POST['Nome'];
        $cpf = $_POST['CPF'];
        $email = $_POST['Email'];
        $telefone = $_POST['Telefone'];
        $dataNascimento = $_POST['DataNascimento'];
        $idPlano = isset($_POST['id_plano']) ? $_POST['id_plano'] : null;
        
        // 2. Trata o idPlano para NULL
        $idPlano_para_db = empty($idPlano) ? NULL : $idPlano;

        // 3. Validação básica
        if (empty($idAluno) || empty($nome) || empty($cpf)) {
             print "<script>alert('Erro: ID do aluno, Nome e CPF são obrigatórios para a edição!');</script>";
             print "<script>location.href='?page=listar-alunos';</script>";
             exit;
        }

        // 4. Constrói a consulta SQL de UPDATE (Prepared Statement)
        $sql = "UPDATE alunos SET 
                    Nome = ?, 
                    CPF = ?, 
                    Email = ?, 
                    Telefone = ?, 
                    DataNascimento = ?, 
                    id_plano = ?
                WHERE 
                    AlunoID = ?";
        
        $stmt = $conn->prepare($sql);
        
        // 5. Bind dos parâmetros: 5 strings + 1 integer (id_plano) + 1 integer (AlunoID)
        $stmt->bind_param("sssssii", 
            $nome, 
            $cpf, 
            $email, 
            $telefone, 
            $dataNascimento, 
            $idPlano_para_db, 
            $idAluno
        );

        if ($stmt->execute()) {
            print "<script>alert('Aluno editado com sucesso!');</script>";
        } else {
            print "<script>alert('Erro ao editar aluno. Detalhe: " . $stmt->error . "');</script>";
        }
        
        $stmt->close();
        print "<script>location.href='?page=listar-alunos';</script>";
        break;

    case 'excluir':
        
        // 1. Recebe o ID do aluno
        $id_aluno = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
        
        // 2. Validação
        if (empty($id_aluno) || !is_numeric($id_aluno)) {
            print "<script>alert('Erro: ID do aluno para exclusão inválido ou não fornecido.');</script>";
            print "<script>location.href='?page=listar-alunos';</script>";
            exit();
        }

        // 3. Instrução SQL de exclusão (DELETE)
        $sql = "DELETE FROM alunos WHERE AlunoID = ?"; 
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param("i", $id_aluno); // i = integer

        if ($stmt->execute()) {
            print "<script>alert('Aluno excluído com sucesso!');</script>";
        } else {
            // Captura o erro 1451 (Chave Estrangeira ativa)
            if ($stmt->errno == 1451) {
                print "<script>alert('ERRO: Não é possível excluir o aluno. Ele possui matrículas ativas ou dados dependentes. Exclua a matrícula primeiro.');</script>";
            } else {
                print "<script>alert('Erro ao excluir aluno: " . $stmt->error . "');</script>";
            }
        }
        
        $stmt->close();
        print "<script>location.href='?page=listar-alunos';</script>";
        break;
        
    default:
        print "<script>location.href='?page=cadastrar-aluno';</script>";
        break;
}
?>