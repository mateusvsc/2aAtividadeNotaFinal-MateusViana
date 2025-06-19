<?php

$db = new SQLite3('tarefas.db');

$query = "CREATE TABLE IF NOT EXISTS tarefas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    descricao TEXT NOT NULL,
    vencimento DATE NOT NULL,
    concluida BOOLEAN DEFAULT 0
)";

if (!$db->exec($query)) {
    die("Erro ao criar tabela: " . $db->lastErrorMsg());
}
?>