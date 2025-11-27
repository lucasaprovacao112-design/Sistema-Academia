<?php 

    // O erro anterior mencionou 'academia12', então estamos usando-o aqui.
    // Se o seu banco de dados correto for 'academia1', ajuste 'BASE' de volta para 'academia1'.

    // Usa 'defined()' para garantir que as constantes só sejam definidas uma vez.
    if (!defined('HOST')) {
        define('HOST', 'localhost: 3306');
    }
    
    if (!defined('USER')) {
        define('USER', 'root');
    }
    
    if (!defined('PASS')) {
        define('PASS', '');
    }
    
    if (!defined('BASE')) {
        // CORREÇÃO: Usando 'academia12' conforme a última comunicação de erro
        define('BASE', 'academia12'); 
    }

    // A conexão com o banco de dados é feita fora do bloco 'defined'.
    // Note: O PHP não vai reclamar se você tentar criar a conexão múltiplas vezes, 
    // mas a variável $conn será sobrescrita.
    $conn = new MySQLi(HOST, USER, PASS, BASE);

    // Opcional: Adicionar verificação de erro de conexão
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

?>