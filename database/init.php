<?php
require_once __DIR__ . '/../config/database.php';

// Arquivo destinado para inicializar o banco de dados, criando as tabelas necessárias.
try {
    $sql = file_get_contents(__DIR__ . '/database.sql');
    $pdo->exec($sql);
    echo "Tabelas criadas com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao executar o SQL: " . $e->getMessage();
}
?>