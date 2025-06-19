<?php


$db = new SQLite3('livraria.db');


$query = "CREATE TABLE IF NOT EXISTS livros (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    autor TEXT NOT NULL,
    ano_publicacao INTEGER NOT NULL
)";

if (!$db->exec($query)) {
    die("Erro ao criar tabela: " . $db->lastErrorMsg());
}
