<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $vencimento = $_POST['vencimento'];
    
    $stmt = $db->prepare("INSERT INTO tarefas (descricao, vencimento) VALUES (:descricao, :vencimento)");
    $stmt->bindValue(':descricao', $descricao, SQLITE3_TEXT);
    $stmt->bindValue(':vencimento', $vencimento, SQLITE3_TEXT);
    
    if ($stmt->execute()) {
        header("Location: index.php?status=added");
    } else {
        die("Erro ao adicionar tarefa: " . $db->lastErrorMsg());
    }
} else {
    header("Location: index.php");
}

$db->close();
?>