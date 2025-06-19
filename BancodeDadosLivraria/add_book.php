<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano_publicacao = $_POST['ano_publicacao'];


    $stmt = $db->prepare("INSERT INTO livros (titulo, autor, ano_publicacao) VALUES (:titulo, :autor, :ano)");
    $stmt->bindValue(':titulo', $titulo, SQLITE3_TEXT);
    $stmt->bindValue(':autor', $autor, SQLITE3_TEXT);
    $stmt->bindValue(':ano', $ano_publicacao, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        header("Location: index.php?status=added");
    } else {
        die("Erro ao adicionar livro: " . $db->lastErrorMsg());
    }
} else {
    header("Location: index.php");
}

$db->close();
