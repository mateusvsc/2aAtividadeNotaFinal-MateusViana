<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $stmt = $db->prepare("UPDATE tarefas SET concluida = 1 WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    
    if ($stmt->execute()) {
        header("Location: index.php?status=updated");
    } else {
        die("Erro ao atualizar tarefa: " . $db->lastErrorMsg());
    }
} else {
    header("Location: index.php");
}

$db->close();
?>