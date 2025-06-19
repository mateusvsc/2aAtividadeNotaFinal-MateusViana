<?php
require 'database.php';

$livros = $db->query("SELECT * FROM livros ORDER BY titulo ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livraria - Gerenciamento de Livros</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo::before {
            content: "📚";
            font-size: 28px;
        }

        .add-book-form {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .form-title {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-title::before {
            content: "+";
            background: #2c3e50;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        input {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
            align-self: flex-end;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .books-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::before {
            content: "📖";
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .action-btn {
            padding: 6px 12px;
            font-size: 14px;
            margin-right: 5px;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #7f8c8d;
        }

        .empty-icon {
            font-size: 50px;
            margin-bottom: 15px;
            opacity: 0.3;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container header-content">
            <div class="logo">Livraria Moderna</div>
        </div>
    </header>

    <main class="container">
        <section class="add-book-form">
            <h2 class="form-title">Adicionar Novo Livro</h2>
            <form action="add_book.php" method="post" id="bookForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="autor">Autor</label>
                        <input type="text" id="autor" name="autor" required>
                    </div>
                    <div class="form-group">
                        <label for="ano_publicacao">Ano de Publicação</label>
                        <input type="number" id="ano_publicacao" name="ano_publicacao" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-primary">Adicionar Livro</button>
                    </div>
                </div>
            </form>
        </section>

        <section class="books-section">
            <h2 class="section-title">Catálogo de Livros</h2>

            <?php if ($livros->fetchArray() === false): ?>
                <div class="empty-state">
                    <div class="empty-icon">📚</div>
                    <h3>Nenhum livro cadastrado</h3>
                    <p>Adicione seu primeiro livro usando o formulário acima</p>
                </div>
            <?php else: ?>
                <?php $livros->reset(); ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Ano</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($livro = $livros->fetchArray(SQLITE3_ASSOC)): ?>
                            <tr>
                                <td><?= htmlspecialchars($livro['id']) ?></td>
                                <td><?= htmlspecialchars($livro['titulo']) ?></td>
                                <td><?= htmlspecialchars($livro['autor']) ?></td>
                                <td><?= htmlspecialchars($livro['ano_publicacao']) ?></td>
                                <td>
                                    <form action="delete_book.php" method="post" class="delete-form">
                                        <input type="hidden" name="id" value="<?= $livro['id'] ?>">
                                        <button type="submit" class="action-btn btn-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </main>

    <script>
        document.getElementById('bookForm').addEventListener('submit', function(e) {
            const titulo = document.getElementById('titulo').value.trim();
            const autor = document.getElementById('autor').value.trim();
            const ano = document.getElementById('ano_publicacao').value;

            if (!titulo || !autor || !ano) {
                alert('Por favor, preencha todos os campos!');
                e.preventDefault();
                return;
            }

            const currentYear = new Date().getFullYear();
            if (ano < 1000 || ano > currentYear) {
                alert(`Por favor, insira um ano válido entre 1000 e ${currentYear}`);
                e.preventDefault();
            }
        });

        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Tem certeza que deseja excluir este livro?')) {
                    e.preventDefault();
                }
            });
        });

        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });

            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    </script>
</body>

</html>

<?php
$db->close();
?>